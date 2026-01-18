<?php
//---TEMA HIJO NEVE CHILD Y ESTILOS---

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

// ---CREAR USUARIOS Y REGISTRO ---

// menu para redirigir  al usuario a registro o a pagina cliente
function menu_area_cliente_condicional( $items, $args ) {
    foreach ( $items as $item ) {
        if ( $item->title === 'Área Cliente' ) {
            $item->url = is_user_logged_in()
                ? site_url('/area-cliente/')
                : site_url('/area-cliente/mi-cuenta/');
        }
    }
    return $items;

}
add_filter( 'wp_nav_menu_objects', 'menu_area_cliente_condicional', 10, 2 );


//Redirecciona dependiendo del role al registrarse
function redirect_byrol_user_registration( $redirect_to, $user_id ) {

    if ( isset( $user_id->roles ) && is_array( $user_id->roles ) ) {
        if ( in_array( 'administrator', $user_id->roles ) ) {
            return admin_url(); // Admin → Escritorio
        } elseif ( in_array( 'subscriber', $user_id->roles ) ) {
            return site_url('/area-cliente/'); // Suscriptor → Área cliente
        } elseif ( in_array( 'editor', $user_id->roles ) ) {
            return site_url('/administrar/'); // Editor → Página administrar
        } else {
            return site_url('/'); // fallback
        }
    }
    return $redirect_to;
}

// 🔹 Aplica redirección tras login y registro de User Registration
add_filter( 'user_registration_login_redirect', 'redirect_byrol_user_registration', 10, 2 );
add_filter( 'user_registration_registration_redirect', 'redirect_byrol_user_registration', 10, 2 );


// Guardar Nombre y apellidos que van siempre en el firstname de WP en el campo "Doctor" de User Registration
function sync_wp_user_to_user_registration( $user_id ) {
    $user = get_userdata( $user_id );

    if ( ! $user ) {
        return;
    }

    // Obtener Nombre y Apellidos estándar de WP
    $first_name = get_user_meta( $user_id, 'first_name', true );
  
    // Cambia 'doctor' por el meta key real de tu campo en User Registration
    update_user_meta( $user_id, 'first_name', $first_name );
    //update_user_meta( $user_id, 'firstname', $doctor );
}
add_action( 'profile_update', 'sync_wp_user_to_user_registration', 10, 1 );
add_action( 'user_register', 'sync_wp_user_to_user_registration', 10, 1 );



// Rellenar automáticamente el campo "fuente" al crear usuarios desde el admin
function rellenar_fuente_wp_admin( $user_id ) {

    // Meta key exacto del campo “Fuente” en la base de datos
    $meta_key_fuente = 'fuente';

    // Valor que quieres asignar, por ejemplo "WP Admin"
    $valor_fuente = 'formulario registro';

    update_user_meta( $user_id, $meta_key_fuente, $valor_fuente );
}
add_action( 'user_register', 'rellenar_fuente_wp_admin', 10, 1 );

// Permitir que los gestores vean el formulario de registro aunque estén logueados
add_shortcode('user_registration_for_gestor', function() {
    // Verificar si el usuario está logueado y es gestor
    if ( is_user_logged_in() && current_user_can('editor') ) {
        // Mostrar el formulario de registro normal
        ob_start();
        echo do_shortcode('[user_registration_form id="1519"]'); // <-- cambia XXX por el ID de tu formulario
        return ob_get_clean();
    }

    // Si no es gestor, usar el comportamiento normal del plugin
    if ( !is_user_logged_in() ) {
        ob_start();
        echo do_shortcode('[user_registration_form id="1519"]'); // mismo ID
        return ob_get_clean();
    }

    // Si está logueado pero no es gestor, mostrar mensaje
    return '<p>Ya estás conectado y no tienes permisos para registrar nuevos usuarios.</p>';
});