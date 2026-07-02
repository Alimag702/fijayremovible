<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-number-counter', [
    'label' => __('Number Counter', 'tpebl'),
    'description' => __('Adds the The Plus "Number Counter" widget (tp-number-counter) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'style' => ['type' => 'string', 'enum' => ['style-1', 'style-2'], 'description' => 'Counter display style'],
        'title' => ['type' => 'string', 'description' => 'Label shown above or below the counter number'],
        'max_number' => ['type' => 'integer', 'description' => 'Final/target counter value'],
        'min_number' => ['type' => 'integer', 'description' => 'Starting counter value for animation'],
        'symbol' => ['type' => 'string', 'description' => 'Symbol displayed with the number (e.g. +, %, K)'],
        'symbol_position' => ['type' => 'string', 'enum' => ['after', 'before'], 'description' => 'Display symbol before or after the number'],
        'alignment' => ['type' => 'string', 'enum' => ['left', 'center', 'right'], 'description' => 'Text alignment'],
                'settings' => ['type' => 'object', 'description' => 'Raw Elementor/The Plus control settings to merge into the widget at creation time. Use control keys from sprout/get-theplus-widget-schema.'],
        ],
        'required' => ['post_id', 'parent_id', 'max_number'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_number_counter_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_number_counter_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_number_counter_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_number_counter_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-number-counter';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Number Counter widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (!empty($input['style'])) { $settings['style'] = sanitize_key((string)$input['style']); }
    if (!empty($input['title'])) { $settings['title'] = sanitize_text_field((string)$input['title']); }
    if (isset($input['max_number'])) { $settings['max_number'] = intval($input['max_number']); }
    if (isset($input['min_number'])) { $settings['min_number'] = intval($input['min_number']); }
    if (!empty($input['symbol'])) { $settings['symbol'] = sanitize_text_field((string)$input['symbol']); }
    if (!empty($input['symbol_position'])) { $settings['symbol_position'] = sanitize_key((string)$input['symbol_position']); }
    if (!empty($input['alignment'])) { $settings['alignment'] = sanitize_key((string)$input['alignment']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
