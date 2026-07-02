<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('tpae_mcp_permission_callback')) {
    /**
     * Default permission callback for read-only TPAE MCP abilities.
     * Requires the user to have `edit_posts` capability.
     */
    function tpae_mcp_permission_callback(?array $input = null): bool {
        return current_user_can('edit_posts');
    }
}

wp_register_ability('tpae/tpae-widget-schema', [
    'label' => __('Widget Schema', 'tpebl'),
    'description' => __('Returns a compact schema for a registered The Plus widget so AI can configure the widget with valid control keys.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'widget_type' => [
                'type' => 'string',
                'description' => 'The Plus Elementor widget slug, for example tp-adv-text-block.',
            ],
        ],
        'required' => ['widget_type'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'widget_type' => ['type' => 'string'],
            'title' => ['type' => 'string'],
            'control_count' => ['type' => 'integer'],
            'controls' => ['type' => 'array'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_get_theplus_widget_schema_ability',
    'permission_callback' => 'tpae_mcp_permission_callback',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

function tpae_mcp_get_theplus_widget_schema_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = sanitize_key((string) ($input['widget_type'] ?? ''));
    if ($widget_type === '') {
        return new WP_Error('missing_widget_type', __('The widget_type parameter is required.', 'tpebl'));
    }

    if (strpos($widget_type, 'tp-') !== 0) {
        return new WP_Error('invalid_widget_type', __('Only The Plus widget types starting with "tp-" are supported.', 'tpebl'));
    }

    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The requested The Plus widget is not registered on this site.', 'tpebl'));
    }

    $widget = \Elementor\Plugin::$instance->widgets_manager->get_widget_types($widget_type);
    if (!$widget) {
        return new WP_Error('widget_not_found', __('Unable to load the widget instance.', 'tpebl'));
    }

    if (method_exists($widget, 'get_stack')) {
        $widget->get_stack(false);
    }

    $controls = method_exists($widget, 'get_controls') ? $widget->get_controls() : [];
    if (!is_array($controls)) {
        $controls = [];
    }

    return [
        'widget_type' => $widget_type,
        'title' => method_exists($widget, 'get_title') ? (string) $widget->get_title() : $widget_type,
        'control_count' => count($controls),
        'controls' => tpae_mcp_format_theplus_controls($controls),
    ];
}

function tpae_mcp_format_theplus_controls(array $controls): array
{
    $formatted = [];

    foreach ($controls as $control_id => $control) {
        if (!is_array($control)) {
            continue;
        }

        $formatted[] = [
            'id' => (string) $control_id,
            'label' => isset($control['label']) ? (string) $control['label'] : (string) $control_id,
            'type' => isset($control['type']) ? (string) $control['type'] : 'unknown',
            'tab' => isset($control['tab']) ? (string) $control['tab'] : '',
            'section' => isset($control['section']) ? (string) $control['section'] : '',
            'default' => $control['default'] ?? null,
            'options' => isset($control['options']) && is_array($control['options']) ? array_keys($control['options']) : [],
            'responsive' => !empty($control['responsive']),
        ];
    }

    return $formatted;
}

/**
 * Merge raw widget control settings into the curated settings array.
 *
 * The add-* abilities keep their simple named params for common use-cases,
 * but this helper lets MCP callers pass any valid Elementor/The Plus control
 * key via a nested `settings` object at creation time.
 *
 * @param array<string, mixed> $settings
 * @param mixed                $raw_settings
 * @return array<string, mixed>
 */
function tpae_mcp_merge_widget_settings(array $settings, $raw_settings): array
{
    if (!is_array($raw_settings) || $raw_settings === []) {
        return $settings;
    }

    return array_replace_recursive($settings, tpae_mcp_sanitize_widget_setting_value($raw_settings));
}

/**
 * Sanitize nested widget settings while preserving Elementor-compatible arrays.
 *
 * @param mixed $value
 * @return mixed
 */
function tpae_mcp_sanitize_widget_setting_value($value)
{
    if (is_array($value)) {
        $sanitized = [];

        foreach ($value as $key => $item) {
            $sanitized_key = is_string($key) ? sanitize_text_field($key) : $key;
            $sanitized[$sanitized_key] = tpae_mcp_sanitize_widget_setting_value($item);
        }

        return $sanitized;
    }

    if (is_string($value)) {
        return wp_check_invalid_utf8($value);
    }

    if (is_bool($value) || is_int($value) || is_float($value) || $value === null) {
        return $value;
    }

    return (string) $value;
}
