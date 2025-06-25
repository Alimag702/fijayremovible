<?php

/*
Plugin Name: Manage Clinics
Plugin URI: http://localhost/fijayremovible/gestion-clinicas/
Descripción: Gestion de la base de la tabla usuarios de la base de datos.
Author: Alicia Martin Gonzalez
Version: 2024031700
Author URI: http://localhost/fijayremovible/gestion-clinicas/
*/


//TODO: FALTAN PERMISOS POR CAPABILITY SOLO PARA EL ROLE EDITOR

// Asegúrate de que SITEURL esté definido
define('SITEURL', get_site_url());

// Definir el shortcode para mostrar la tabla de usuarios
function show_user_table_shortcode() {
    ob_start(); // Iniciar el búfer de salida

    $users = get_users();

    if ( !empty( $users )) {
        echo '<table class="manageclinics">';
        echo '<tr>
                <th>Clínica</th>
                <th>Email</th>
                <th>Acciones</th>   
              </tr>';
        foreach ( $users as $user ) {

            $editurl = site_url ( '/editar-clinica/?userid='. $user->ID );
                        
            echo '<tr>';
            echo '<td>' . $user->user_login . '</td>';
            echo '<td>' . $user->user_email . '</td>';
            echo '<td>
                    <a href="' . esc_url($editurl) . '">
                        <i class="fa fa-pencil" aria-hidden="true" style="margin-right:10px;"></i>
                    </a>
                    <a href="#" id="link_delete_user" data-user-id="'.$user->ID.'">
                    <i class="fa fa-trash"></i>
                    </a>
                </td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No se encontraron usuarios.';
    }

    return ob_get_clean(); // Devolver y limpiar el búfer de salida
}
add_shortcode('show_user_table', 'show_user_table_shortcode');


function edit_user_table_shortcode( $atts ) {
    ob_start();// inicia buffer de salida
   
    //obtengo los atributos del shortcode
    $atts = shortcode_atts (
        array(
            'userid' =>'',
        ),
        $atts,
        'edit_user_table'
    );

    //Recupero el valor de la url
    $userid = isset($_GET['userid']) ? $_GET['userid'] : '';

    if (!empty($userid)) {

        $user = get_userdata( $userid );
           
            ?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <input type="hidden" name="action" value="submit_edit_user_form">
        <input type="hidden" id="identificador" name="identificador" value= "<?php echo esc_attr( $user->ID );?>" readonly ><br>
        <label for="user_login">Nombre Clínica:</label><br>
        <input type="text" id="name" name="name" value= "<?php echo esc_attr( $user->user_login );?>" readonly><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value= "<?php echo esc_attr( $user->user_email );?>" required><br>
        <input type="submit" value="Enviar">
    </form>
    <?php

      
    } else {
        return '<p>No se proporcionó ningún parámetro en la URL.</p>';
    }
 
    

    return ob_get_clean();
}

add_shortcode('edit_user_table', 'edit_user_table_shortcode');
add_action('admin_post_submit_edit_user_form', 'handle_edit_user_form_submission');

function handle_edit_user_form_submission() {

      // Verifica si el formulario ha sido enviado y si la acción es válida
    if (isset($_POST['action']) && $_POST['action'] === 'submit_edit_user_form') {
        // Valida y limpia los datos del formulario
        $user_ID = isset($_POST['identificador']) ? intval($_POST['identificador']) : 0;
        $username = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

        // Realiza la validación adicional según tus necesidades
        if (empty($username) || empty($email)) {
            // Si faltan campos obligatorios, muestra un mensaje de error
            wp_die('Por favor, completa todos los campos del formulario.');
        }

        // Actualiza los datos del usuario en la base de datos
        $user_data = array(
            'ID' => $user_ID,
            'user_login' => $username,
            'user_email' => $email,
        );

        $updated = wp_update_user($user_data);
        
        if (is_wp_error($updated)) {
            // Si ocurre un error al actualizar los datos, muestra un mensaje de error
            wp_die('Ha ocurrido un error al actualizar los datos del usuario.');
        }

        // Redirige al usuario a una página de éxito o a donde desees
        $manageurl = site_url ( '/gestion-clinica/' );
        wp_redirect($manageurl);
        exit;       
    }
}



