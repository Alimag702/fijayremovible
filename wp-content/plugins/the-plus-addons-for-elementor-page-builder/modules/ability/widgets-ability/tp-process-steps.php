<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-process-steps', [
    'label' => __('Process Steps', 'tpebl'),
    'description' => __('Adds the The Plus "Process Steps" widget (tp-process-steps) to an Elementor container.', 'tpebl'),
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
            'ps_style' => [
                'type' => 'string',
                'enum' => ['style_1', 'style_2'],
                'description' => 'Steps layout - vertical (style_1) or horizontal (style_2)',
            ],
            'pro_ste_display_counter' => [
                'type' => 'string',
                'enum' => ['yes', 'no'],
                'description' => 'Show step number counter',
            ],
            'pro_ste_display_counter_style' => [
                'type' => 'string',
                'enum' => ['number-normal', 'decimal-leading-zero', 'upper-alpha', 'lower-alpha', 'lower-roman', 'upper-roman'],
                'description' => 'Counter number format',
            ],
            'steps' => [
                'type' => 'array',
                'description' => 'Process step items',
                'items' => [
                    'type' => 'object',
                    'properties' => [
                        'step_title' => [
                            'type' => 'string',
                            'description' => 'Step heading',
                        ],
                        'step_content' => [
                            'type' => 'string',
                            'description' => 'Step description text',
                        ],
                    ],
                ],
            ],
                    'settings' => ['type' => 'object', 'description' => 'Raw Elementor/The Plus control settings to merge into the widget at creation time. Use control keys from sprout/get-theplus-widget-schema.'],
        ],
        'required' => ['post_id', 'parent_id'],
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
    'execute_callback' => 'tpae_mcp_add_theplus_process_steps_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_process_steps_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

function tpae_mcp_add_theplus_process_steps_permission(?array $input = null): bool
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

function tpae_mcp_add_theplus_process_steps_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-process-steps';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Process Steps widget is not registered.', 'tpebl'));
    }

    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string) ($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);

    if ($post_id <= 0 || $parent_id === '') {
        return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl'));
    }

    $post = get_post($post_id);
    if (!$post instanceof WP_Post) {
        return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    $settings = [];

    if (!empty($input['ps_style'])) { $settings['ps_style'] = sanitize_key((string) $input['ps_style']); }
    if (!empty($input['pro_ste_display_counter'])) { $settings['pro_ste_display_counter'] = sanitize_key((string) $input['pro_ste_display_counter']); }
    if (!empty($input['pro_ste_display_counter_style'])) { $settings['pro_ste_display_counter_style'] = sanitize_key((string) $input['pro_ste_display_counter_style']); }
    if (!empty($input['steps']) && is_array($input['steps'])) {
        $settings['steps'] = array_map(function ($step) {
            return [
                'step_title'   => sanitize_text_field((string) ($step['step_title'] ?? '')),
                'step_content' => wp_kses_post((string) ($step['step_content'] ?? '')),
                '_id'          => substr(bin2hex(random_bytes(4)), 0, 7),
            ];
        }, $input['steps']);
    }

    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);


    $widget = [
        'id'         => tpae_mcp_generate_elementor_element_id(),
        'elType'     => 'widget',
        'widgetType' => $widget_type,
        'isInner'    => false,
        'settings'   => $settings,
        'elements'   => [],
    ];

    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) {
        return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
