<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-header-extras', [
    'label' => __('Header Extras', 'tpebl'),
    'description' => __('Adds the The Plus "Header Extras" widget (tp-header-extras) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => [
                'type' => 'integer',
                'description' => 'Elementor page/post ID',
            ],
            'parent_id' => [
                'type' => 'string',
                'description' => 'Target Elementor container ID',
            ],
            'position' => [
                'type' => 'integer',
                'description' => 'Insert position. Use -1 to append.',
                'default' => -1,
            ],
            'select_icon_list' => [
                'type' => 'string',
                'enum' => ['search', 'cart'],
                'description' => 'Header element to display (search bar or mini cart)',
            ],
            'responsive_hidden_desktop' => [
                'type' => 'string',
                'enum' => ['yes', 'no'],
                'description' => 'Hide on desktop screens',
            ],
            'responsive_hidden_tablet' => [
                'type' => 'string',
                'enum' => ['yes', 'no'],
                'description' => 'Hide on tablet screens',
            ],
            'responsive_hidden_mobile' => [
                'type' => 'string',
                'enum' => ['yes', 'no'],
                'description' => 'Hide on mobile screens',
            ],
                    'settings' => ['type' => 'object', 'description' => 'Raw Elementor/The Plus control settings to merge into the widget at creation time. Use control keys from sprout/get-theplus-widget-schema.'],
        ],
        'required' => ['post_id', 'parent_id', 'select_icon_list'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'element_id' => ['type' => 'string'],
            'widget_type' => ['type' => 'string'],
            'post_id' => ['type' => 'integer'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_add_theplus_header_extras_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_header_extras_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

/**
 * Require post edit permission because this ability writes Elementor data.
 */
function tpae_mcp_add_theplus_header_extras_permission(?array $input = null): bool
{
    if (!current_user_can('edit_posts')) {
        return false;
    }

    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) {
        return false;
    }

    return true;
}

/**
 * Add a TP Header Extras widget into an Elementor container.
 *
 * @param array<string, mixed> $input
 * @return array<string, mixed>|WP_Error
 */
function tpae_mcp_add_theplus_header_extras_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-header-extras';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Header Extras widget is not registered on this site.', 'tpebl'));
    }

    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string) ($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    $select_icon_list = sanitize_key((string) ($input['select_icon_list'] ?? ''));

    if ($post_id <= 0 || $parent_id === '' || $select_icon_list === '') {
        return new WP_Error('missing_params', __('post_id, parent_id, and select_icon_list are required.', 'tpebl'));
    }

    $post = get_post($post_id);
    if (!$post instanceof WP_Post) {
        return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    $settings = [
        'select_icon_list' => $select_icon_list,
    ];

    if (!empty($input['responsive_hidden_desktop'])) {
        $settings['responsive_hidden_desktop'] = sanitize_key((string) $input['responsive_hidden_desktop']);
    }

    if (!empty($input['responsive_hidden_tablet'])) {
        $settings['responsive_hidden_tablet'] = sanitize_key((string) $input['responsive_hidden_tablet']);
    }

    if (!empty($input['responsive_hidden_mobile'])) {
        $settings['responsive_hidden_mobile'] = sanitize_key((string) $input['responsive_hidden_mobile']);
    }

    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);


    $widget = [
        'id' => tpae_mcp_generate_elementor_element_id(),
        'elType' => 'widget',
        'widgetType' => $widget_type,
        'isInner' => false,
        'settings' => $settings,
        'elements' => [],
    ];

    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) {
        return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return [
        'element_id' => $widget['id'],
        'widget_type' => $widget_type,
        'post_id' => $post_id,
    ];
}
