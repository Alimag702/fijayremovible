(function () {
    'use strict';

    function dispatchResizeSoon() {
        // Ayuda a que contenedores (p.ej. pestañas de Elementor) recalculen alturas
        try {
            window.requestAnimationFrame(function () {
                window.dispatchEvent(new Event('resize'));
            });
        } catch (e) {}
    }

    function debounce(fn, wait) {
        var timer = null;
        return function () {
            var ctx = this;
            var args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                fn.apply(ctx, args);
            }, wait);
        };
    }

    function isTextLikeField(el) {
        if (!el || el.nodeType !== 1) return false;
        var tag = el.tagName.toLowerCase();
        if (tag === 'textarea') return true;
        if (tag !== 'input') return false;
        var type = (el.getAttribute('type') || 'text').toLowerCase();
        return type === 'text' || type === 'email' || type === 'tel' || type === 'url' || type === 'number' || type === 'search' || type === 'password';
    }

    function shouldClearValueForPlaceholder(field) {
        // Para que el mensaje se vea "dentro" del input como placeholder, el campo debe estar vacío.
        // En tel (y algunos campos similares) CF7 puede marcar como inválido aunque haya valor.
        // En ese caso vaciamos el valor (guardándolo) para que el usuario vea el mensaje en el placeholder.
        if (!field || !field.getAttribute) return false;
        if (field.tagName && field.tagName.toLowerCase() !== 'input') return false;

        var type = (field.getAttribute('type') || '').toLowerCase();
        if (type === 'tel') return true;

        // Fallbacks por nombre o clases frecuentes
        var name = (field.getAttribute('name') || '').toLowerCase();
        if (name.indexOf('tel') !== -1 || name.indexOf('phone') !== -1 || name.indexOf('telefono') !== -1) return true;

        try {
            if (field.classList && (field.classList.contains('wpcf7-tel') || field.classList.contains('wpcf7-validates-as-tel'))) return true;
        } catch (e) {}

        return false;
    }

    function removeOverlay(field) {
        if (!field || !field.closest) return;
        var wrap = field.closest('.wpcf7-form-control-wrap');
        if (!wrap) return;
        wrap.classList.remove('cf7-inline-error-wrap');
        var overlay = wrap.querySelector('.cf7-inline-error-overlay');
        if (overlay) overlay.remove();
    }

    function restoreField(field) {
        if (!field || !field.classList || !field.classList.contains('cf7-inline-error')) return;
        var original = field.getAttribute('data-cf7-orig-placeholder');
        field.setAttribute('placeholder', original || '');
        field.classList.remove('cf7-inline-error');
        removeOverlay(field);

        // Si vaciamos el valor para mostrar el placeholder, restaurarlo al enfocar/escribir
        var storedValue = field.getAttribute('data-cf7-orig-value');
        if (storedValue !== null) {
            field.removeAttribute('data-cf7-orig-value');
            if (!field.value) field.value = storedValue;
        }
    }

    function clearInlineErrors(container) {
        if (!container || !container.querySelectorAll) return;
        var fields = container.querySelectorAll('.cf7-inline-error');
        for (var i = 0; i < fields.length; i++) {
            restoreField(fields[i]);
        }
    }

    function ensureOverlay(wrap, msg) {
        if (!wrap || !wrap.querySelector) return;
        wrap.classList.add('cf7-inline-error-wrap');
        var overlay = wrap.querySelector('.cf7-inline-error-overlay');
        if (!overlay) {
            overlay = document.createElement('span');
            overlay.className = 'cf7-inline-error-overlay';
            overlay.setAttribute('aria-hidden', 'true');
            wrap.appendChild(overlay);
        }
        overlay.textContent = msg;
    }

    function applyInlineErrors(container) {
        if (!container || !container.querySelectorAll) return;

        var tips = container.querySelectorAll('.wpcf7-not-valid-tip, .wpcf7-not-valid-tip-no-ajax');
        for (var i = 0; i < tips.length; i++) {
            var tip = tips[i];
            var wrap = tip.closest ? tip.closest('.wpcf7-form-control-wrap') : null;
            if (!wrap) continue;

            var field = wrap.querySelector('input.wpcf7-form-control, textarea.wpcf7-form-control');
            if (!isTextLikeField(field)) continue;

            var msg = (tip.textContent || '').trim();
            if (!msg) continue;

            if (!field.hasAttribute('data-cf7-orig-placeholder')) {
                field.setAttribute('data-cf7-orig-placeholder', field.getAttribute('placeholder') || '');
            }

            field.classList.add('cf7-inline-error');

            // Solo "metemos" el mensaje dentro del placeholder si está vacío.
            // Si hay valor (p.ej. teléfono con formato inválido), mostramos un overlay dentro del campo.
            if (!field.value) {
                removeOverlay(field);
                field.setAttribute('placeholder', msg);
                tip.style.display = 'none';
            } else {
                if (shouldClearValueForPlaceholder(field)) {
                    // Comportamiento tipo "placeholder": vaciamos el valor para que se vea el mensaje dentro del input
                    if (!field.hasAttribute('data-cf7-orig-value')) field.setAttribute('data-cf7-orig-value', field.value);
                    field.value = '';
                    removeOverlay(field);
                    field.setAttribute('placeholder', msg);
                    tip.style.display = 'none';
                } else {
                    // Mantén el placeholder original y muestra el mensaje "dentro" del input sin borrar el valor.
                    field.setAttribute('placeholder', field.getAttribute('data-cf7-orig-placeholder') || '');
                    ensureOverlay(wrap, msg);
                    tip.style.display = 'none';
                }
            }
        }

        dispatchResizeSoon();
    }

    function findClosestContainer(node) {
        if (!node || !node.closest) return document;
        return node.closest('.wpcf7') || node.closest('form') || document;
    }

    // Quitar el placeholder de error en cuanto el usuario interactúa con el campo
    document.addEventListener(
        'input',
        function (event) {
            restoreField(event.target);
        },
        true
    );

    document.addEventListener(
        'focusin',
        function (event) {
            restoreField(event.target);
        },
        true
    );

    // Contact Form 7 dispara estos eventos como CustomEvent; por compatibilidad escuchamos en captura
    document.addEventListener(
        'wpcf7invalid',
        function (event) {
            applyInlineErrors(findClosestContainer(event.target));
        },
        true
    );

    document.addEventListener(
        'wpcf7mailsent',
        function (event) {
            clearInlineErrors(findClosestContainer(event.target));
        },
        true
    );

    function bootstrapInlineErrors() {
        // Para modo no-AJAX (o si el tip ya está en el HTML al cargar), aplicar al cargar.
        applyInlineErrors(document);
        // Y de nuevo un poco después por si CF7 o algún script lo inyecta con delay.
        setTimeout(function () {
            applyInlineErrors(document);
        }, 150);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootstrapInlineErrors, { once: true });
    } else {
        bootstrapInlineErrors();
    }

    window.addEventListener('pageshow', bootstrapInlineErrors);

    // Fallback: si por lo que sea el evento no se captura, observamos el DOM y convertimos tips en placeholder
    var scheduled = debounce(function (root) {
        applyInlineErrors(root || document);
    }, 50);

    try {
        var observer = new MutationObserver(function (mutations) {
            for (var i = 0; i < mutations.length; i++) {
                var m = mutations[i];
                for (var j = 0; j < m.addedNodes.length; j++) {
                    var node = m.addedNodes[j];
                    if (!node || node.nodeType !== 1) continue;
                    if (
                        node.classList.contains('wpcf7-not-valid-tip') ||
                        node.classList.contains('wpcf7-not-valid-tip-no-ajax') ||
                        (node.querySelector && node.querySelector('.wpcf7-not-valid-tip, .wpcf7-not-valid-tip-no-ajax'))
                    ) {
                        scheduled(findClosestContainer(node));
                        return;
                    }
                }
            }
        });

        observer.observe(document.documentElement, { childList: true, subtree: true });
    } catch (e) {
        // Si MutationObserver no está disponible, no pasa nada: seguiremos con los eventos.
    }
})();
