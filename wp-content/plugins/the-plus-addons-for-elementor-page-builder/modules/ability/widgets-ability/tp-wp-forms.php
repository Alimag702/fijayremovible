<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-wp-forms', [
    'label' => __('WPForms', 'tpebl'),
    'description' => __('Adds the The Plus "WPForms" widget (tp-wp-forms) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
            'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
            'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
            'wp_forms' => ['type' => 'integer', 'description' => 'WPForms form ID to embed'],
            'form_title' => ['type' => 'string', 'enum' => ['yes', 'no'], 'description' => 'Show form title'],
            'form_description' => ['type' => 'string', 'enum' => ['yes', 'no'], 'description' => 'Show form description'],
                    'settings' => ['type' => 'object', 'description' => 'Raw Elementor/The Plus control settings to merge into the widget at creation time. Use control keys from sprout/get-theplus-widget-schema.'],
        ],
        'required' => ['post_id', 'parent_id', 'wp_forms'],
        'additionalProperties' => false,
    ],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_wp_forms_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_wp_forms_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_wp_forms_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_wp_forms_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-wp-forms';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus WPForms widget is not registered on this site.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (!empty($input['wp_forms'])) { $settings['wp_forms'] = absint($input['wp_forms']); }
    if (!empty($input['form_title'])) { $settings['form_title'] = sanitize_key((string)$input['form_title']); }
    if (!empty($input['form_description'])) { $settings['form_description'] = sanitize_key((string)$input['form_description']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
