(function () {
    'use strict';

    var popupEl = null;
    var overlayEl = null;
    var contentEl = null;
    var closeBtnEl = null;
    var lastShownByUnitTag = Object.create(null);

    function closestWpcf7Container(node) {
        if (!node) return null;
        if (node.classList && node.classList.contains('wpcf7')) return node;
        if (node.closest) return node.closest('.wpcf7');
        return null;
    }

    function getMessageFromEventOrOutput(event, container) {
        var message = '';
        try {
            if (event && event.detail && event.detail.apiResponse && typeof event.detail.apiResponse.message === 'string') {
                message = event.detail.apiResponse.message;
            }
        } catch (e) {}

        if (!message && container && container.querySelector) {
            var out = container.querySelector('.wpcf7-response-output');
            if (out) message = (out.textContent || '').trim();
        }

        return (message || '').trim();
    }

    function ensurePopup() {
        if (popupEl) return;

        overlayEl = document.createElement('div');
        overlayEl.className = 'cf7-popup-overlay';
        overlayEl.setAttribute('hidden', 'hidden');

        popupEl = document.createElement('div');
        popupEl.className = 'cf7-popup';
        popupEl.setAttribute('role', 'dialog');
        popupEl.setAttribute('aria-modal', 'true');

        closeBtnEl = document.createElement('button');
        closeBtnEl.type = 'button';
        closeBtnEl.className = 'cf7-popup-close';
        closeBtnEl.setAttribute('aria-label', 'Cerrar');
        closeBtnEl.textContent = '\u00d7';

        contentEl = document.createElement('div');
        contentEl.className = 'cf7-popup-content';
        contentEl.setAttribute('aria-live', 'polite');

        popupEl.appendChild(closeBtnEl);
        popupEl.appendChild(contentEl);
        overlayEl.appendChild(popupEl);
        document.body.appendChild(overlayEl);

        overlayEl.addEventListener('click', function (e) {
            if (e.target === overlayEl) hidePopup();
        });

        closeBtnEl.addEventListener('click', hidePopup);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') hidePopup();
        });
    }

    function showPopup(message, type) {
        ensurePopup();

        overlayEl.removeAttribute('hidden');
        overlayEl.classList.add('is-open');

        popupEl.classList.remove('is-sent', 'is-error');
        if (type === 'sent') popupEl.classList.add('is-sent');
        if (type === 'error') popupEl.classList.add('is-error');

        contentEl.textContent = message;
        closeBtnEl.focus();
    }

    function hidePopup() {
        if (!overlayEl) return;
        overlayEl.classList.remove('is-open');
        overlayEl.setAttribute('hidden', 'hidden');
        if (contentEl) contentEl.textContent = '';
    }

    function hideInlineResponse(container) {
        if (!container || !container.querySelectorAll) return;
        container.querySelectorAll('.wpcf7-response-output').forEach(function (el) {
            el.style.display = 'none';
        });
    }

    function isDuplicate(event, container, message, type) {
        // Evita dobles disparos muy seguidos (p.ej. DOMContentLoaded + pageshow, o dobles eventos).
        // No debe impedir que el usuario vuelva a enviar el formulario en la misma página.
        var unitTag = '';
        try {
            if (event && event.detail && typeof event.detail.unitTag === 'string') unitTag = event.detail.unitTag;
        } catch (e) {}
        if (!unitTag && container && container.id) unitTag = container.id;
        if (!unitTag) unitTag = 'default';

        var now = Date.now();
        var prev = lastShownByUnitTag[unitTag];
        if (prev && prev.message === message && prev.type === type && now - prev.time < 800) return true;

        lastShownByUnitTag[unitTag] = { message: message, type: type, time: now };
        return false;
    }

    function onMailSent(event) {
        var container = closestWpcf7Container(event.target) || event.target;
        var message = getMessageFromEventOrOutput(event, container);
        if (!message) return;
        if (isDuplicate(event, container, message, 'sent')) return;
        hideInlineResponse(container);
        showPopup(message, 'sent');
    }

    function onMailFailed(event) {
        var container = closestWpcf7Container(event.target) || event.target;
        var message = getMessageFromEventOrOutput(event, container);
        if (!message) return;
        if (isDuplicate(event, container, message, 'error')) return;
        hideInlineResponse(container);
        showPopup(message, 'error');
    }

    function onInvalid(event) {
        var container = closestWpcf7Container(event.target) || event.target;
        var message = getMessageFromEventOrOutput(event, container);
        if (!message) return;
        if (isDuplicate(event, container, message, 'error')) return;
        hideInlineResponse(container);
        showPopup(message, 'error');
    }

    function onSpam(event) {
        var container = closestWpcf7Container(event.target) || event.target;
        var message = getMessageFromEventOrOutput(event, container);
        if (!message) return;
        if (isDuplicate(event, container, message, 'error')) return;
        hideInlineResponse(container);
        showPopup(message, 'error');
    }

    function onSubmit(event) {
        // Fallback: wpcf7submit se dispara siempre y nos permite cubrir estados no contemplados (p.ej. unaccepted).
        var container = closestWpcf7Container(event.target) || event.target;
        var message = getMessageFromEventOrOutput(event, container);
        if (!message) return;

        var type = 'error';
        try {
            if (event && event.detail && event.detail.apiResponse && event.detail.apiResponse.status === 'mail_sent') type = 'sent';
        } catch (e) {}

        if (isDuplicate(event, container, message, type)) return;
        hideInlineResponse(container);
        showPopup(message, type);
    }

    function bootstrapNonAjax() {
        // En modo no-AJAX no se disparan eventos: si hay un response-output con contenido
        // y el form está en estado "sent/failed", lo mostramos como popup al cargar.
        var containers = document.querySelectorAll('.wpcf7');
        for (var i = 0; i < containers.length; i++) {
            var c = containers[i];
            var form = c.querySelector('form');
            var out = c.querySelector('.wpcf7-response-output');
            if (!form || !out) continue;

            var message = (out.textContent || '').trim();
            if (!message) continue;

            var type = null;
            if (form.classList.contains('sent')) type = 'sent';
            if (form.classList.contains('failed') || form.classList.contains('aborted')) type = 'error';
            if (form.classList.contains('invalid') || form.classList.contains('unaccepted') || form.classList.contains('spam')) type = 'error';
            if (!type) continue;

            if (isDuplicate(null, c, message, type)) continue;
            hideInlineResponse(c);
            showPopup(message, type);
            // Solo mostramos 1 popup por carga
            break;
        }
    }

    // AJAX mode events
    document.addEventListener('wpcf7mailsent', onMailSent, true);
    document.addEventListener('wpcf7mailfailed', onMailFailed, true);
    document.addEventListener('wpcf7invalid', onInvalid, true);
    document.addEventListener('wpcf7spam', onSpam, true);
    document.addEventListener('wpcf7submit', onSubmit, true);

    // Non-AJAX / fallback
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bootstrapNonAjax, { once: true });
    } else {
        bootstrapNonAjax();
    }
    window.addEventListener('pageshow', function (e) {
        if (e && e.persisted) bootstrapNonAjax();
    });
})();
