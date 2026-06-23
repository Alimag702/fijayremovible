<?php

/*
 * Plugin Name: Custom-form
 * Plugin URI: http://localhost/fijayremovible/registro-trabajos/
 * Description: Añade un nuevos tipo de campo a Contact Form 7 para registrar trabajos.
 * Version: 2.0
 * Author: Alicia Martin Gonzalez
 * Author URI:  http://localhost/fijayremovible.com

*/

// ============================
// Encolar script personalizado para CF7
// ============================
add_action('wp_enqueue_scripts', 'custom_cf7_select_script');
function custom_cf7_select_script()
{

    $custom_script_url = plugins_url('js/custom-cf7-select-script.js', __FILE__);
    $custom_script_path = plugin_dir_path(__FILE__) . 'js/custom-cf7-select-script.js';
    $custom_script_ver = file_exists($custom_script_path) ? filemtime($custom_script_path) : '1.0';
    wp_enqueue_script('custom-cf7-select-script', $custom_script_url, array('jquery'), $custom_script_ver, true);
    wp_localize_script('custom-cf7-select-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));

    // Mostrar los mensajes de validación dentro de los campos (placeholder) y ocultar el tip bajo el campo
    $inline_errors_js = plugins_url('js/cf7-inline-errors.js', __FILE__);
    $inline_errors_js_path = plugin_dir_path(__FILE__) . 'js/cf7-inline-errors.js';
    $inline_errors_js_ver = file_exists($inline_errors_js_path) ? filemtime($inline_errors_js_path) : '1.0';
    wp_enqueue_script('custom-cf7-inline-errors', $inline_errors_js, array(), $inline_errors_js_ver, true);

    $inline_errors_css = plugins_url('css/cf7-inline-errors.css', __FILE__);
    $inline_errors_css_path = plugin_dir_path(__FILE__) . 'css/cf7-inline-errors.css';
    $inline_errors_css_ver = file_exists($inline_errors_css_path) ? filemtime($inline_errors_css_path) : '1.0';
    wp_enqueue_style('custom-cf7-inline-errors', $inline_errors_css, array(), $inline_errors_css_ver);

    // Mostrar wpcf7-response-output como popup (enviado / error)
    $popup_js = plugins_url('js/cf7-popup-response.js', __FILE__);
    $popup_js_path = plugin_dir_path(__FILE__) . 'js/cf7-popup-response.js';
    $popup_js_ver = file_exists($popup_js_path) ? filemtime($popup_js_path) : '1.0';
    wp_enqueue_script('custom-cf7-popup-response', $popup_js, array(), $popup_js_ver, true);

    $popup_css = plugins_url('css/cf7-popup-response.css', __FILE__);
    $popup_css_path = plugin_dir_path(__FILE__) . 'css/cf7-popup-response.css';
    $popup_css_ver = file_exists($popup_css_path) ? filemtime($popup_css_path) : '1.0';
    wp_enqueue_style('custom-cf7-popup-response', $popup_css, array(), $popup_css_ver);

    // Ajustes responsive (especialmente útil dentro de pestañas de Elementor)
    $responsive_css = plugins_url('css/cf7-responsive.css', __FILE__);
    $responsive_css_path = plugin_dir_path(__FILE__) . 'css/cf7-responsive.css';
    $responsive_css_ver = file_exists($responsive_css_path) ? filemtime($responsive_css_path) : '1.0';
    wp_enqueue_style('custom-cf7-responsive', $responsive_css, array(), $responsive_css_ver);
}

add_filter('wpcf7_form_class_attr', 'custom_cf7_form_class_attr');
function custom_cf7_form_class_attr($class_attr)
{
    if (!function_exists('wpcf7_get_current_contact_form')) {
        return $class_attr;
    }

    $contact_form = wpcf7_get_current_contact_form();
    if (!$contact_form || !method_exists($contact_form, 'scan_form_tags')) {
        return $class_attr;
    }

    $tag_names = wp_list_pluck($contact_form->scan_form_tags(), 'name');
    if (in_array('select_clinica', $tag_names, true) || in_array('doctor', $tag_names, true)) {
        $class_attr .= ' custom-work-register-form';
    }

    return trim($class_attr);
}

// ============================
// Crear nuevo campo para Contact Form 7: select_clinica
// ============================
add_action('wpcf7_init', 'wpcf7_add_form_tag_select_clinica');
function wpcf7_add_form_tag_select_clinica()
{
    wpcf7_add_form_tag(
        array('select_clinica', 'select_clinica*'),
        'custom_wpcf7_select_clinica_form_tag_handler',
        array('name-attr' => true)
    );
}

function custom_wpcf7_select_clinica_form_tag_handler($tag)
{
    if (empty($tag->name)) return '';

    global $wpdb;
    $usuarios = $wpdb->get_results("SELECT ID, user_nicename FROM {$wpdb->prefix}users");
    $options_html = '<option value="">Selecciona una clínica</option>';
    foreach ($usuarios as $usuario) {
        $options_html .= sprintf(
            '<option value="%d">%s</option>',
            esc_attr($usuario->ID),
            esc_html($usuario->user_nicename)
        );
    }

    return sprintf(
        '<span class="wpcf7-form-control-wrap %s">
            <select name="%s" class="wpcf7-form-control wpcf7-select">
                %s
            </select>
            <input type="hidden" name="idclinica" value="">
        </span>',
        esc_attr($tag->name),
        esc_attr($tag->name),
        $options_html
    );
}

// ============================
// AJAX: Devolver usuarios para el <select>
// ============================
add_action('wp_ajax_get_users_db', 'get_users_db_callback');
add_action('wp_ajax_nopriv_get_users_db', 'get_users_db_callback');

function get_users_db_callback()
{
    global $wpdb;
    $results = $wpdb->get_results("SELECT ID, user_nicename FROM {$wpdb->prefix}users", ARRAY_A);

    echo json_encode($results ?: array());
    wp_die();
}

// ============================
// Crear tabla personalizada al activar plugin
// ============================
register_activation_hook(__FILE__, 'create_table_works_register');

function create_table_works_register()
{
    global $wpdb;
    $tabla_nombre = $wpdb->prefix . 'works_register';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $tabla_nombre (
        id INT NOT NULL AUTO_INCREMENT,
        idclinica INT NOT NULL,
        clinica VARCHAR(100) NOT NULL,
        doctor VARCHAR(100) NOT NULL,
        paciente VARCHAR(100) NOT NULL,
        fecha_llegada DATE NOT NULL,
        fecha_envio DATE NOT NULL,
        tipo_trabajo VARCHAR(100) NOT NULL,
        fija VARCHAR(100) NOT NULL,
        implante VARCHAR(100) NOT NULL,
        removible VARCHAR(100) NOT NULL,
        guiadecolor VARCHAR(100) NOT NULL,
        colorvivo VARCHAR(100) NOT NULL,
        colorvita VARCHAR(100) NOT NULL,
        adjuntar_imagen VARCHAR(255) DEFAULT '',
        anotaciones VARCHAR(255) DEFAULT '',
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// ============================
// Guardar datos del formulario CF7 en la tabla
// ============================
add_action('wpcf7_mail_sent', 'save_form_works_register');


function save_form_works_register($contact_form)
{
    global $wpdb;

    $submission = WPCF7_Submission::get_instance();
    if (!$submission) return;

    $data = $submission->get_posted_data();

    // ID de la clínica
    $id_clinica = isset($data['idclinica']) ? intval($data['idclinica']) : 0;


    // Función auxiliar para obtener y sanitizar un valor del array
    $get_value = function ($key) use ($data) {
        return isset($data[$key][0]) ? sanitize_text_field($data[$key][0]) : '';
    };

    // Extrae los campos check box del formulario
    $fija_string = get_fixworks($get_value);
    $remove_string = get_removeworks($get_value);
    $impla_string = get_implaworks($get_value);
    $colorvivo_str = get_colorvivo($get_value);
    $colorvita_str = get_colorvita($get_value);

    // Insertar en la base de datos
    $wpdb->insert(
        $wpdb->prefix . 'works_register',
        [
            'idclinica'       => $id_clinica,
            'clinica'         => sanitize_text_field($data['select_clinica']),
            'doctor'          => sanitize_text_field($data['doctor']),
            'paciente'        => sanitize_text_field($data['paciente']),
            'fecha_llegada'   => sanitize_text_field($data['Fechallegada']),
            'fecha_envio'     => sanitize_text_field($data['Fechaenvio']),
            'tipo_trabajo'    => $get_value('tipodetrabajo'),
            'fija'            => $fija_string,
            'implante'        => $impla_string,
            'removible'       => $remove_string,
            'guiadecolor'     => $get_value('guiadecolor'),
            'colorvivo'       => $colorvivo_str,
            'colorvita'       => $colorvita_str,
            'adjuntar_imagen' => sanitize_text_field($data['Adjuntarimagen']),
            'anotaciones'   => sanitize_text_field($data['anotaciones']),
        ]
    );

    // Log para depuración
    error_log(print_r($data, true));
}



// ============================
// Evitar el envío del correo de CF7
// ============================
add_filter('wpcf7_skip_mail', 'skip_cf7_email_sending', 10, 2);
function skip_cf7_email_sending($skip_mail, $contact_form)
{
    $form_id = $contact_form->id();

    // SOLO el formulario con ID 123 NO enviará email
    if ($form_id == "5e94f23") {
        return true;
    }

    return false;
}
// ============================
// Personalizar mensaje de éxito
// ============================
add_filter('wpcf7_feedback_response', 'custom_cf7_response_message', 10, 2);
function custom_cf7_response_message($response, $result)
{
    if (!isset($result['status']) || $result['status'] !== 'mail_sent') {
        return $response;
    }

    // Evita afectar a otros formularios CF7 del sitio: solo aplica si se detectan campos de este formulario
    $submission = class_exists('WPCF7_Submission') ? WPCF7_Submission::get_instance() : null;
    $posted_data = $submission ? $submission->get_posted_data() : null;
    if (!is_array($posted_data) || (!isset($posted_data['select_clinica']) && !isset($posted_data['doctor']))) {
        return $response;
    }

    $response['message'] = '¡Formulario guardado correctamente en la base de datos!';
    return $response;
}


function get_fixworks($get_value)
{

    $fija_keys = [
        'coronam',
        'cormmetal',
        'cormbizcocho',
        'cormterminada',
        'cormpu',
        'cormpi',
        'coronaz',
        'corzbizcocho',
        'corzterminada',
        'corzpi',
        'corzpu',
        'provpmma',
        'provpi',
        'provpu',
        'incrustaciones',
        'carilla',
        'perno',
        'colocacerm'
    ];

    $fijaOptions = array_filter(array_map($get_value, $fija_keys));
    $fija_string = implode(', ', $fijaOptions);

    return $fija_string;
}

function get_removeworks($get_value)
{
    $remove_keys = [
        'aparato',
        'aparatodient',
        'aparatotermi',
        'compostura',
        'comppegar',
        'compapi',
        'revase',
        'ferula',
        'plancharemo'
    ];

    $removeOptions = array_filter(array_map($get_value, $remove_keys));
    $remove_string = implode(', ', $removeOptions);

    return $remove_string;
}

function get_implaworks($get_value)
{
    $impla_keys = [
        'coronaSI',
        'corsimetal',
        'corsibizcocho',
        'carsiterminada',
        'corsipi',
        'corsipu',
        'sobredent',
        'sbdentmetal',
        'sbdentdient',
        'sbdentter',
        'hibrida',
        'hibridametal',
        'hibridadient',
        'hibridater'
    ];

    $implaOptions = array_filter(array_map($get_value, $impla_keys ));
    $impla_string = implode(', ', $implaOptions);

    return $impla_string;
}

function get_colorvivo($get_value)
{
    $vivo_keys = [
        'vivo1A',
        'vivo2A',
        'vivo3A',
        'vivo4A',
        'vivo2B',
        'vivo4B',
        'vivo5B',
        'vivo6B',
        'vivo1C',
        'vivo2C',
        'vivo3C',
        'vivo4C',
        'vivo6C',
        'vivo1D',
        'vivo4D',
        'vivo6D',
        'vivo1E',
        'vivo2E',
        'vivo3E',
    ];

    $vivoOptions = array_filter(array_map($get_value, $vivo_keys ));
    $colorvivo_str = implode(', ', $vivoOptions);

    return $colorvivo_str;
}

function get_colorvita($get_value)
{
    $vita_keys = [
        'vitaA1',
        'vitaB1',
        'vitaC1',
        'vitaD1',
        'vitaA2',
        'vitaB2',
        'vitaC2',
        'vitaD2',
        'vitaA3',
        'vitaB3',
        'vitaC3',
        'vitaD3',
        'vitaA35',
        'vitaA4',
        'vitaB4',
        'vitaC4',
        'vitaD4',
    ];

    $vitaOptions = array_filter(array_map($get_value, $vita_keys ));
    $colorvita_str = implode(', ', $vitaOptions);

    return $colorvita_str;
}

