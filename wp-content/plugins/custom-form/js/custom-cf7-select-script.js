jQuery(document).ready(function ($) {
    function loadClinicas() {
        const selectClinica = $('select[name="select_clinica"]');
        const hiddenInput = $('input[name="idclinica"]');

        if (!selectClinica.length || !hiddenInput.length) {
            console.warn("Campos select_clinica o idclinica no encontrados aún. Esperando...");
            return;
        }

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: { 'action': 'get_users_db' },
            success: function (response) {
                try {
                    const valores = JSON.parse(response);
                    console.log("Usuarios obtenidos:", valores);

                    selectClinica.find('option:not(:first)').remove();

                    var opcionesTexto = "";
                    $.each(valores, function (index, value) {
                        selectClinica.append(
                            $('<option>', {
                                value: value.ID,
                                text: value.user_nicename
                            })
                        );
                    });
     
                    // Actualizar campo oculto y forzar valor del select
                    selectClinica.off('change').on('change', function () {
                        const selectedId = $(this).val();
                        console.log("ID clínica seleccionado:", selectedId);
                        hiddenInput.val(selectedId);
                        selectClinica.val(selectedId); // Forzar valor para CF7
                    });

                } catch (e) {
                    console.error('Error al parsear la respuesta JSON:', e);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
            }
        });
    }

    document.addEventListener('wpcf7init', function () {
        loadClinicas();
    });

    loadClinicas();

    // Forzar valor antes del envío del formulario
    document.addEventListener('wpcf7submit', function () {
        const selectedId = $('select[name="select_clinica"]').val();
        $('input[name="idclinica"]').val(selectedId);
    });

    // CÓDIGO TIPO TRABAJO
    $(document).on('change', 'select.wpcf7-select[name="tipodetrabajo"]', function (e) {
        var selectedOption = $(this).val();
        $('#fijaOptions, #implanteOptions, #removibleOptions, #esqueleticoOptions').hide();
        if (selectedOption === 'Fija' || selectedOption === 'Implante' || selectedOption === 'Removible' || selectedOption === 'Esqueléticos') {
            $('#' + selectedOption.toLowerCase() + 'Options').show();
        }
    });

    // CÓDIGO GUÍA DE COLOR
    $(document).on('change', 'select.wpcf7-select[name="guiadecolor"]', function (e) {
        var selectedOption = $(this).val();
        $('#vivodentOptions, #vitaOptions').hide();
        if (selectedOption === 'Vivodent' || selectedOption === 'Vita') {
            $('#' + selectedOption.toLowerCase() + 'Options').show();
        }
    });

    console.log("Archivo JS cargado");
});


