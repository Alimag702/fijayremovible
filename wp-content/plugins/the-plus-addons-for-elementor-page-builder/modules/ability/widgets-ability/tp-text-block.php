<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-text-block', [
    'label' => __('Text Block', 'tpebl'),
    'description' => __('Adds the The Plus "Text Block" widget (tp-adv-text-block) to an Elementor container.', 'tpebl'),
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
            'content_description' => [
                'type' => 'string',
                'description' => 'Main text content for the widget',
                'minLength' => 1,
            ],
            'content_align' => [
                'type' => 'string',
                'enum' => ['left', 'center', 'right', 'justify'],
                'description' => 'Desktop text alignment',
            ],
            'display_count' => [
                'type' => 'string',
                'enum' => ['yes', 'no'],
                'description' => 'Enable text limit',
            ],
            'display_count_by' => [
                'type' => 'string',
                'enum' => ['char', 'word'],
                'description' => 'Limit text by character or word count',
            ],
            'display_count_input' => [
                'type' => 'integer',
                'description' => 'Character/word limit count',
            ],
                    'settings' => ['type' => 'object', 'description' => 'Raw Elementor/The Plus control settings to merge into the widget at creation time. Use control keys from sprout/get-theplus-widget-schema.'],
        ],
        'required' => ['post_id', 'parent_id', 'content_description'],
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
    'execute_callback' => 'tpae_mcp_add_theplus_text_block_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_text_block_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

/**
 * Require post edit permission because this ability writes Elementor data.
 */
function tpae_mcp_add_theplus_text_block_permission(?array $input = null): bool
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
 * Add a TP Text Block widget into an Elementor container.
 *
 * This is a dedicated learning example for a single widget:
 * 1. validate input
 * 2. map input to widget settings
 * 3. load Elementor data
 * 4. create widget element
 * 5. insert + save
 *
 * @param array<string, mixed> $input
 * @return array<string, mixed>|WP_Error
 */
function tpae_mcp_add_theplus_text_block_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-adv-text-block';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Text Block widget is not registered on this site.', 'tpebl'));
    }

    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string) ($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    $content = (string) ($input['content_description'] ?? '');

    if ($post_id <= 0 || $parent_id === '' || trim(wp_strip_all_tags($content)) === '') {
        return new WP_Error('missing_params', __('post_id, parent_id, and content_description are required.', 'tpebl'));
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
        'content_description' => wp_kses_post($content),
    ];

    if (!empty($input['content_align'])) {
        $settings['content_align'] = sanitize_key((string) $input['content_align']);
    }

    if (!empty($input['display_count'])) {
        $settings['display_count'] = sanitize_key((string) $input['display_count']);
    }

    if (!empty($input['display_count_by'])) {
        $settings['display_count_by'] = sanitize_key((string) $input['display_count_by']);
    }

    if (isset($input['display_count_input'])) {
        $settings['display_count_input'] = max(1, intval($input['display_count_input']));
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

/**
 * Whether Elementor is active and loaded.
 */
if (!function_exists('tpae_mcp_has_elementor')) {
    function tpae_mcp_has_elementor(): bool
    {
        return class_exists('\Elementor\Plugin') && isset(\Elementor\Plugin::$instance);
    }
}

/**
 * Check whether a widget type exists in Elementor.
 */
if (!function_exists('tpae_mcp_has_registered_widget')) {
    function tpae_mcp_has_registered_widget(string $widget_type): bool
    {
        if (!class_exists('\Elementor\Plugin')) {
            return false;
        }

        return (bool) \Elementor\Plugin::$instance->widgets_manager->get_widget_types($widget_type);
    }
}

/**
 * Load the current Elementor element tree for a post.
 *
 * @return array<int, array<string, mixed>>|WP_Error
 */
if (!function_exists('tpae_mcp_get_elementor_page_data')) {
    function tpae_mcp_get_elementor_page_data(int $post_id)
    {
        $document = \Elementor\Plugin::$instance->documents->get($post_id);
        if (!$document) {
            return new WP_Error('document_not_found', __('Elementor document not found for this post.', 'tpebl'));
        }

        $data = $document->get_elements_data();
        if (is_array($data) && !empty($data)) {
            return $data;
        }

        $raw = get_post_meta($post_id, '_elementor_data', true);
        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }
}

/**
 * Save Elementor data with native save first, then meta fallback.
 *
 * @param array<int, array<string, mixed>> $data
 * @return true|WP_Error
 */
if (!function_exists('tpae_mcp_save_elementor_page_data')) {
    function tpae_mcp_save_elementor_page_data(int $post_id, array $data)
    {
        $document = \Elementor\Plugin::$instance->documents->get($post_id);
        if (!$document) {
            return new WP_Error('document_not_found', __('Elementor document not found for save.', 'tpebl'));
        }

        $result = $document->save(['elements' => $data]);
        if ($result === false) {
            $json = wp_json_encode($data);
            if ($json === false) {
                return new WP_Error('json_encode_failed', __('Failed to encode Elementor data.', 'tpebl'));
            }

            update_post_meta($post_id, '_elementor_data', wp_slash($json));
            update_post_meta($post_id, '_elementor_edit_mode', 'builder');

            if (defined('ELEMENTOR_VERSION')) {
                update_post_meta($post_id, '_elementor_version', ELEMENTOR_VERSION);
            }

            delete_post_meta($post_id, '_elementor_css');
        }

        return true;
    }
}

/**
 * Insert an element into the Elementor tree under a parent container.
 *
 * @param array<int, array<string, mixed>> $data
 * @param array<string, mixed> $element
 */
if (!function_exists('tpae_mcp_insert_elementor_element')) {
    function tpae_mcp_insert_elementor_element(array &$data, string $parent_id, array $element, int $position = -1): bool
    {
        foreach ($data as &$item) {
            if (($item['id'] ?? '') === $parent_id) {
                if (!isset($item['elements']) || !is_array($item['elements'])) {
                    $item['elements'] = [];
                }

                if ($position < 0 || $position >= count($item['elements'])) {
                    $item['elements'][] = $element;
                } else {
                    array_splice($item['elements'], $position, 0, [$element]);
                }

                return true;
            }

            if (!empty($item['elements']) && is_array($item['elements'])) {
                if (tpae_mcp_insert_elementor_element($item['elements'], $parent_id, $element, $position)) {
                    return true;
                }
            }
        }

        return false;
    }
}

/**
 * Generate Elementor-style 7-char hex IDs.
 */
if (!function_exists('tpae_mcp_generate_elementor_element_id')) {
    function tpae_mcp_generate_elementor_element_id(): string
    {
        return substr(bin2hex(random_bytes(4)), 0, 7);
    }
}
