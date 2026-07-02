<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-icon', [
    'label' => __('Icon', 'tpebl'),
    'description' => __('Adds the The Plus "Icon" widget (tp-icon) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'selected_icon' => ['type' => 'string', 'description' => 'Choose Icon'],
        'tp_icon_link' => ['type' => 'object', 'description' => 'Link'],
        'tp_icon_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'tp_icon_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'icon', 'left', 'right', '{{WRAPPER}} .tp-icon-wrapper']],
        'tp_icon_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        'tp_rotate_icon' => ['type' => 'object', 'description' => 'Rotate (Slider/Size Object)'],
        'tp_icon_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'tp_icon_fill_color' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'tp_icon_stroke_color' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'tp_icon_hover_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'tp_icon_fill_color_hover' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'tp_icon_stroke_color_hover' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'tp_fit_to_size' => ['type' => 'string', 'description' => 'Fit to Size (SVG)', 'enum' => ['yes', 'no']],
        'border_popover' => ['type' => 'string', 'description' => 'Border Options', 'enum' => ['yes', 'no']],
        'tp_icon_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'border_hover_popover' => ['type' => 'string', 'description' => 'Border Hover Options', 'enum' => ['yes', 'no']],
        'tp_icon_border_radius_hover' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'tp_hover_animation' => ['type' => 'string', 'description' => 'Hover Animation'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports SVG stroke animation, kinetic hover effects, and industrial gradient mapping.']
        ],
        'required' => ['post_id', 'parent_id'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_icon_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_icon_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_icon_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_icon_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-icon';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Icon widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['selected_icon'])) { $settings['selected_icon'] = sanitize_text_field($input['selected_icon']); }
    if (isset($input['tp_icon_link'])) { $settings['tp_icon_link'] = $input['tp_icon_link']; }
    if (isset($input['tp_icon_padding'])) { $settings['tp_icon_padding'] = $input['tp_icon_padding']; }
    if (isset($input['tp_icon_align'])) { $settings['tp_icon_align'] = $input['tp_icon_align']; }
    if (isset($input['tp_icon_size'])) { $settings['tp_icon_size'] = $input['tp_icon_size']; }
    if (isset($input['tp_rotate_icon'])) { $settings['tp_rotate_icon'] = $input['tp_rotate_icon']; }
    if (isset($input['tp_icon_color'])) { $settings['tp_icon_color'] = sanitize_text_field($input['tp_icon_color']); }
    if (isset($input['tp_icon_fill_color'])) { $settings['tp_icon_fill_color'] = sanitize_text_field($input['tp_icon_fill_color']); }
    if (isset($input['tp_icon_stroke_color'])) { $settings['tp_icon_stroke_color'] = sanitize_text_field($input['tp_icon_stroke_color']); }
    if (isset($input['tp_icon_hover_color'])) { $settings['tp_icon_hover_color'] = sanitize_text_field($input['tp_icon_hover_color']); }
    if (isset($input['tp_icon_fill_color_hover'])) { $settings['tp_icon_fill_color_hover'] = sanitize_text_field($input['tp_icon_fill_color_hover']); }
    if (isset($input['tp_icon_stroke_color_hover'])) { $settings['tp_icon_stroke_color_hover'] = sanitize_text_field($input['tp_icon_stroke_color_hover']); }
    if (isset($input['tp_fit_to_size'])) { $settings['tp_fit_to_size'] = sanitize_text_field($input['tp_fit_to_size']); }
    if (isset($input['border_popover'])) { $settings['border_popover'] = sanitize_text_field($input['border_popover']); }
    if (isset($input['tp_icon_border_radius'])) { $settings['tp_icon_border_radius'] = $input['tp_icon_border_radius']; }
    if (isset($input['border_hover_popover'])) { $settings['border_hover_popover'] = sanitize_text_field($input['border_hover_popover']); }
    if (isset($input['tp_icon_border_radius_hover'])) { $settings['tp_icon_border_radius_hover'] = $input['tp_icon_border_radius_hover']; }
    if (isset($input['tp_hover_animation'])) { $settings['tp_hover_animation'] = sanitize_text_field($input['tp_hover_animation']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
