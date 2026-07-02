<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-meeting-scheduler', [
    'label' => __('Meeting Scheduler', 'tpebl'),
    'description' => __('Adds the The Plus "Meeting Scheduler" widget (tp-meeting-scheduler) to an Elementor container.', 'tpebl'),
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
            'scheduler_select' => [
                'type' => 'string',
                'enum' => ['calendly', 'freebusy', 'meetingbird', 'vyte'],
                'description' => 'Meeting scheduler service to embed',
            ],
            'calendly_username' => [
                'type' => 'string',
                'description' => 'Calendly username (without @)',
            ],
            'calendly_time' => [
                'type' => 'string',
                'enum' => ['15min', '30min', '60min'],
                'description' => 'Calendly meeting duration',
            ],
            'calendly_height' => [
                'type' => 'integer',
                'description' => 'Widget height in pixels (default 650)',
            ],
                    'settings' => ['type' => 'object', 'description' => 'Raw Elementor/The Plus control settings to merge into the widget at creation time. Use control keys from sprout/get-theplus-widget-schema.'],
        ],
        'required' => ['post_id', 'parent_id', 'scheduler_select'],
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
    'execute_callback' => 'tpae_mcp_add_theplus_meeting_scheduler_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_meeting_scheduler_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

/**
 * Require post edit permission because this ability writes Elementor data.
 */
function tpae_mcp_add_theplus_meeting_scheduler_permission(?array $input = null): bool
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
 * Add a TP Meeting Scheduler widget into an Elementor container.
 *
 * @param array<string, mixed> $input
 * @return array<string, mixed>|WP_Error
 */
function tpae_mcp_add_theplus_meeting_scheduler_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-meeting-scheduler';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Meeting Scheduler widget is not registered on this site.', 'tpebl'));
    }

    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string) ($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    $scheduler_select = sanitize_key((string) ($input['scheduler_select'] ?? ''));

    if ($post_id <= 0 || $parent_id === '' || $scheduler_select === '') {
        return new WP_Error('missing_params', __('post_id, parent_id, and scheduler_select are required.', 'tpebl'));
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
        'scheduler_select' => $scheduler_select,
    ];

    if (!empty($input['calendly_username'])) {
        $settings['calendly_username'] = sanitize_text_field((string) $input['calendly_username']);
    }

    if (!empty($input['calendly_time'])) {
        $settings['calendly_time'] = sanitize_key((string) $input['calendly_time']);
    }

    if (isset($input['calendly_height'])) {
        $settings['calendly_height'] = max(100, intval($input['calendly_height']));
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
