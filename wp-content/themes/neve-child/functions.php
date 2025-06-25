<?php

//importar estilos tema padre
function enqueue_styles_child_theme() {

	$parent_style = 'neve';
	$child_style  = 'neve-child';
	//coloca en cola los estilos tema padre
	wp_enqueue_style( $parent_style,
				get_template_directory_uri() . '/style.css' );
	//coloca en cola estilo tema hijo
	wp_enqueue_style( $child_style,
				get_stylesheet_directory_uri() . '/style.css',
				array( $parent_style ),
				wp_get_theme()->get('Version')
				);
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles_child_theme' );


// Verifica si la página actual es la página deseada
function activate_plugin_manageclinics() {
    // Reemplaza 'gestion-clinicas' con el slug de tu página
    if (is_page('manageclinics')) {
        include_once(ABSPATH . 'wp-content/plugins/manageclinics/manageclinics.php');
    }
}
add_action('wp', 'activate_plugin_manageclinics');

//carga script de tema hijo neve child
function cargar_scripts() {
	$custom_script_url = get_theme_file_uri('js/custom_script.js');
    // Enqueue el script personalizado
    wp_enqueue_script('custom-script', $custom_script_url, array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'cargar_scripts');

// TODO INCLUIR ELIMINAR LOS TRABAJOS DE LA TABLA WORKS-REGISTER
// Función para procesar la eliminación de un usuario
add_action('wp_ajax_delete_user', 'delete_user_callback');
add_action( 'wp_head', 'my_ajax_url' );
function my_ajax_url() {
    echo '<script type="text/javascript">var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";</script>';
}

function delete_user_callback() {
    // Verificar si el usuario actual tiene permiso para eliminar usuarios
   //TODO:activar capability que esta comentada y dar permisos al gestor y admin
    //if ( current_user_can('delete_users') ) { // Reemplaza 'delete_users' con la capacidad correcta
        // Verificar si se recibió un ID de usuario válido
        if (isset($_POST['user_id']) && is_numeric($_POST['user_id'])) {
            $user_id = intval($_POST['user_id']);
           
            // Eliminar el usuario
            if (wp_delete_user($user_id)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
        // Si no se recibió un ID válido, mostrar un mensaje de error
        else {
            echo 'invalid';
        }
    //} else {
    //    echo 'unauthorized'; // Usuario no autorizado
    //}

    // Es importante detener la ejecución después de enviar la respuesta
    wp_die();
}

