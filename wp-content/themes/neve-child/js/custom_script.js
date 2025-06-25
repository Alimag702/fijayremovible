jQuery(document).ready(function($) {
    // Escuchar clic en el enlace de eliminación
    $(document).on('click', '#link_delete_user', function(e) {
        e.preventDefault(); // Prevenir el comportamiento predeterminado del enlace

        // Obtener el ID de usuario del atributo de datos del enlace
        var userId = $(this).data('user-id');

        // Mostrar un mensaje de confirmación
        var confirmacion = confirm("¿Estás seguro de que deseas eliminar este usuario?");

        // Si se confirma la eliminación
        if (confirmacion) {
            // Realizar una solicitud AJAX para eliminar el usuario
            $.ajax({
                url: ajaxurl, // La URL del archivo admin-ajax.php proporcionada por WordPress
                type: 'POST',
                data: {
                    action: 'delete_user', // El nombre de la acción que definimos anteriormente
                    user_id: userId // El ID de usuario a eliminar
                },
                success: function(response) {
                    // Manejar la respuesta del servidor
                    if (response === 'success') {
                        alert('Usuario eliminado correctamente.');
                        // Aquí puedes hacer otras acciones después de eliminar el usuario, como recargar la página
                        location.reload();
                    } else if (response === 'invalid') {
                        alert('ID de usuario no válido.');
                    } else {
                        alert('Error al eliminar el usuario.');
                    }
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la solicitud AJAX
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
