<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-dark-mode', [
    'label' => __('Dark Mode', 'tpebl'),
    'description' => __('Adds the The Plus "Dark Mode" widget (tp-dark-mode) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
            'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
            'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'dm_type' => ['type' => 'string', 'description' => 'Type', 'enum' => ['dm_type_gc', 'dm_type_mb']],
        'dm_style' => ['type' => 'string', 'description' => 'Style', 'enum' => ['columns', 'tp_dm_style1', 'tp_dm_style2']],
        'dm_backgroundcolor_activate' => ['type' => 'string', 'description' => 'Background Color (Color Hex/RGBA)'],
        'dm_mix_blend_mode' => ['type' => 'string', 'description' => 'Mix Blend Mode', 'enum' => ['body .darkmode-layer', 'color-burn', 'color-dodge', 'darken', 'difference', 'dm_style', 'dm_type!', 'exclusion', 'hue', 'lighten', 'multiply', 'overlay', 'saturation', 'screen']],
        'dm_time' => ['type' => 'object', 'description' => 'Animation Time'],
        'dm_right' => ['type' => 'string', 'description' => 'Right Offset', 'enum' => ['yes', 'no']],
        'dm_right_offset' => ['type' => 'object', 'description' => 'Right (Slider/Size Object)'],
        'dm_bottom' => ['type' => 'string', 'description' => 'Bottom Offset', 'enum' => ['yes', 'no']],
        'dm_bottom_offset' => ['type' => 'object', 'description' => 'Bottom (Slider/Size Object)'],
        'loop_label' => ['type' => 'string', 'description' => 'Label'],
        'loop_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'loop_content' => ['type' => 'array', 'items' => ['type' => 'object'], 'description' => 'Global Color'],
        'dm_save_in_cookies' => ['type' => 'string', 'description' => 'Save in Cookies', 'enum' => ['yes', 'no']],
        'dm_auto_match_os_theme' => ['type' => 'string', 'description' => 'Auto Match OS Theme', 'enum' => ['yes', 'no']],
        'dm_ignore_class' => ['type' => 'string', 'description' => 'Ignore Dark Mode ', 'enum' => ['yes', 'no']],
        'dm_ignore' => ['type' => 'string', 'description' => 'Ignore Dark Mode Classes'],
        'dm_ignore_pre_class' => ['type' => 'string', 'description' => 'The Plus Ignore Class Default', 'enum' => ['yes', 'no']],
        'tpae_theme_builder' => ['type' => 'string', 'description' => 'tpae_theme_builder'],
        'st2_size_d' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'st2_bg_size_d' => ['type' => 'object', 'description' => 'Background Size (Slider/Size Object)'],
        'st2_bg' => ['type' => 'string', 'description' => 'Background (Color Hex/RGBA)'],
        'st2_br' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'st2_bg_d' => ['type' => 'string', 'description' => 'Background (Color Hex/RGBA)'],
        'st2_br_d' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'switcher_overall_size' => ['type' => 'object', 'description' => 'Switcher Size (Slider/Size Object)'],
        'switcher_overall_size_height' => ['type' => 'object', 'description' => 'Switcher Height (Slider/Size Object)'],
        'switcher_dot_size' => ['type' => 'object', 'description' => 'Dot Size (Slider/Size Object)'],
        'switcher_dot_offset' => ['type' => 'object', 'description' => 'Dot Offset (Slider/Size Object)'],
        'si_switch_normal_border_color' => ['type' => 'string', 'description' => 'Box Shadow Color (Color Hex/RGBA)'],
        'si_switch_active_border_color_n' => ['type' => 'string', 'description' => 'Box Shadow Color (Color Hex/RGBA)'],
        'switcher_before_text' => ['type' => 'string', 'description' => 'Switcher Before Text'],
        'switcher_before_text_offset' => ['type' => 'object', 'description' => 'Offset (Slider/Size Object)'],
        'switcher_after_text' => ['type' => 'string', 'description' => 'Switcher After Text'],
        'switcher_after_text_offset' => ['type' => 'object', 'description' => 'Offset (Slider/Size Object)'],
        'switcher_b_a_text_typ_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
            'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports system-preference sensing, persistent state storage, and custom CSS selector inverse logic.']
        ],
        'required' => ['post_id', 'parent_id'],
        'additionalProperties' => false,
    ],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_dark_mode_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_dark_mode_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_dark_mode_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_dark_mode_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-dark-mode';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Dark Mode widget is not registered on this site.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['dm_type'])) { $settings['dm_type'] = sanitize_text_field($input['dm_type']); }
    if (isset($input['dm_style'])) { $settings['dm_style'] = sanitize_text_field($input['dm_style']); }
    if (isset($input['dm_backgroundcolor_activate'])) { $settings['dm_backgroundcolor_activate'] = sanitize_text_field($input['dm_backgroundcolor_activate']); }
    if (isset($input['dm_mix_blend_mode'])) { $settings['dm_mix_blend_mode'] = sanitize_text_field($input['dm_mix_blend_mode']); }
    if (isset($input['dm_time'])) { $settings['dm_time'] = $input['dm_time']; }
    if (isset($input['dm_right'])) { $settings['dm_right'] = sanitize_text_field($input['dm_right']); }
    if (isset($input['dm_right_offset'])) { $settings['dm_right_offset'] = $input['dm_right_offset']; }
    if (isset($input['dm_bottom'])) { $settings['dm_bottom'] = sanitize_text_field($input['dm_bottom']); }
    if (isset($input['dm_bottom_offset'])) { $settings['dm_bottom_offset'] = $input['dm_bottom_offset']; }
    if (isset($input['loop_label'])) { $settings['loop_label'] = sanitize_text_field($input['loop_label']); }
    if (isset($input['loop_color'])) { $settings['loop_color'] = sanitize_text_field($input['loop_color']); }
    if (isset($input['loop_content'])) { $settings['loop_content'] = $input['loop_content']; }
    if (isset($input['dm_save_in_cookies'])) { $settings['dm_save_in_cookies'] = sanitize_text_field($input['dm_save_in_cookies']); }
    if (isset($input['dm_auto_match_os_theme'])) { $settings['dm_auto_match_os_theme'] = sanitize_text_field($input['dm_auto_match_os_theme']); }
    if (isset($input['dm_ignore_class'])) { $settings['dm_ignore_class'] = sanitize_text_field($input['dm_ignore_class']); }
    if (isset($input['dm_ignore'])) { $settings['dm_ignore'] = sanitize_text_field($input['dm_ignore']); }
    if (isset($input['dm_ignore_pre_class'])) { $settings['dm_ignore_pre_class'] = sanitize_text_field($input['dm_ignore_pre_class']); }
    if (isset($input['tpae_theme_builder'])) { $settings['tpae_theme_builder'] = sanitize_text_field($input['tpae_theme_builder']); }
    if (isset($input['st2_size_d'])) { $settings['st2_size_d'] = $input['st2_size_d']; }
    if (isset($input['st2_bg_size_d'])) { $settings['st2_bg_size_d'] = $input['st2_bg_size_d']; }
    if (isset($input['st2_bg'])) { $settings['st2_bg'] = sanitize_text_field($input['st2_bg']); }
    if (isset($input['st2_br'])) { $settings['st2_br'] = $input['st2_br']; }
    if (isset($input['st2_bg_d'])) { $settings['st2_bg_d'] = sanitize_text_field($input['st2_bg_d']); }
    if (isset($input['st2_br_d'])) { $settings['st2_br_d'] = $input['st2_br_d']; }
    if (isset($input['switcher_overall_size'])) { $settings['switcher_overall_size'] = $input['switcher_overall_size']; }
    if (isset($input['switcher_overall_size_height'])) { $settings['switcher_overall_size_height'] = $input['switcher_overall_size_height']; }
    if (isset($input['switcher_dot_size'])) { $settings['switcher_dot_size'] = $input['switcher_dot_size']; }
    if (isset($input['switcher_dot_offset'])) { $settings['switcher_dot_offset'] = $input['switcher_dot_offset']; }
    if (isset($input['si_switch_normal_border_color'])) { $settings['si_switch_normal_border_color'] = sanitize_text_field($input['si_switch_normal_border_color']); }
    if (isset($input['si_switch_active_border_color_n'])) { $settings['si_switch_active_border_color_n'] = sanitize_text_field($input['si_switch_active_border_color_n']); }
    if (isset($input['switcher_before_text'])) { $settings['switcher_before_text'] = sanitize_text_field($input['switcher_before_text']); }
    if (isset($input['switcher_before_text_offset'])) { $settings['switcher_before_text_offset'] = $input['switcher_before_text_offset']; }
    if (isset($input['switcher_after_text'])) { $settings['switcher_after_text'] = sanitize_text_field($input['switcher_after_text']); }
    if (isset($input['switcher_after_text_offset'])) { $settings['switcher_after_text_offset'] = $input['switcher_after_text_offset']; }
    if (isset($input['switcher_b_a_text_typ_color'])) { $settings['switcher_b_a_text_typ_color'] = sanitize_text_field($input['switcher_b_a_text_typ_color']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
