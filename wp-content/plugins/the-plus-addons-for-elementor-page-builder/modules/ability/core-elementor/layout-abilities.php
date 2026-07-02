<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/add-container', [
    'label' => __('Add Container', 'tpebl'),
    'description' => __('Adds an Elementor container to a page or inside another container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
            'parent_id' => ['type' => 'string', 'description' => 'Parent container ID. Leave empty for top-level.'],
            'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
            'settings' => ['type' => 'object', 'description' => 'Container settings such as content_width, flex_direction, align_items, justify_content, gap, padding, background_color.'],
        ],
        'required' => ['post_id'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'element_id' => ['type' => 'string'],
            'post_id' => ['type' => 'integer'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_add_container_ability',
    'permission_callback' => 'tp_mcp_elementor_post_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

wp_register_ability('tpae/update-container', [
    'label' => __('Update Container', 'tpebl'),
    'description' => __('Updates settings on an existing Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer'],
            'element_id' => ['type' => 'string'],
            'settings' => ['type' => 'object'],
        ],
        'required' => ['post_id', 'element_id', 'settings'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'success' => ['type' => 'boolean'],
            'element_id' => ['type' => 'string'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_update_container_ability',
    'permission_callback' => 'tp_mcp_elementor_post_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

wp_register_ability('tpae/update-element', [
    'label' => __('Update Element', 'tpebl'),
    'description' => __('Updates settings on any existing Elementor element, including widgets and containers.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer'],
            'element_id' => ['type' => 'string'],
            'settings' => ['type' => 'object'],
        ],
        'required' => ['post_id', 'element_id', 'settings'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'success' => ['type' => 'boolean'],
            'element_id' => ['type' => 'string'],
            'element_type' => ['type' => 'string'],
            'widget_type' => ['type' => 'string'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_update_element_ability',
    'permission_callback' => 'tp_mcp_elementor_post_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

wp_register_ability('tpae/move-element', [
    'label' => __('Move Element', 'tpebl'),
    'description' => __('Moves an Elementor element to a new parent container or position.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer'],
            'element_id' => ['type' => 'string'],
            'target_parent_id' => ['type' => 'string'],
            'position' => ['type' => 'integer', 'default' => -1],
        ],
        'required' => ['post_id', 'element_id', 'target_parent_id', 'position'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'success' => ['type' => 'boolean'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_move_element_ability',
    'permission_callback' => 'tp_mcp_elementor_post_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

wp_register_ability('tpae/reorder-elements', [
    'label' => __('Reorder Elements', 'tpebl'),
    'description' => __('Reorders the direct children of an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer'],
            'container_id' => ['type' => 'string'],
            'element_ids' => ['type' => 'array', 'items' => ['type' => 'string']],
        ],
        'required' => ['post_id', 'container_id', 'element_ids'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'success' => ['type' => 'boolean'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_reorder_elements_ability',
    'permission_callback' => 'tp_mcp_elementor_post_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

wp_register_ability('tpae/remove-element', [
    'label' => __('Remove Element', 'tpebl'),
    'description' => __('Removes an Elementor element and all its children.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer'],
            'element_id' => ['type' => 'string'],
        ],
        'required' => ['post_id', 'element_id'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'success' => ['type' => 'boolean'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_remove_element_ability',
    'permission_callback' => 'tp_mcp_elementor_post_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

wp_register_ability('tpae/duplicate-element', [
    'label' => __('Duplicate Element', 'tpebl'),
    'description' => __('Duplicates an Elementor element with fresh IDs and inserts it after the original.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer'],
            'element_id' => ['type' => 'string'],
        ],
        'required' => ['post_id', 'element_id'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'new_element_id' => ['type' => 'string'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_duplicate_element_ability',
    'permission_callback' => 'tp_mcp_elementor_post_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

wp_register_ability('tpae/get-page-structure', [
    'label' => __('Get Page Structure', 'tpebl'),
    'description' => __('Returns the current Elementor element tree for a page in a compact, readable structure.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer'],
        ],
        'required' => ['post_id'],
        'additionalProperties' => false,
    ],
    'output_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer'],
            'element_count' => ['type' => 'integer'],
            'elements' => ['type' => 'array'],
        ],
    ],
    'execute_callback' => 'tpae_mcp_get_page_structure_ability',
    'permission_callback' => 'tp_mcp_elementor_post_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tp_mcp_elementor_post_permission(?array $input = null): bool
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

function tpae_mcp_add_container_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id <= 0) {
        return new WP_Error('missing_post_id', __('The post_id parameter is required.', 'tpebl'));
    }

    $parent_id = sanitize_text_field((string) ($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    $settings = isset($input['settings']) && is_array($input['settings']) ? $input['settings'] : [];

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    $container = [
        'id' => tpae_mcp_generate_elementor_element_id(),
        'elType' => 'container',
        'widgetType' => null,
        'isInner' => $parent_id !== '',
        'settings' => array_merge([
            'container_type' => 'flex',
            'content_width' => 'boxed',
        ], $settings),
        'elements' => [],
    ];

    if ($parent_id === '') {
        tpae_mcp_insert_at_position($page_data, $container, $position);
    } elseif (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $container, $position)) {
        return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return ['element_id' => $container['id'], 'post_id' => $post_id];
}

function tpae_mcp_update_container_ability(array $input)
{
    $post_id = absint($input['post_id'] ?? 0);
    $element_id = sanitize_text_field((string) ($input['element_id'] ?? ''));
    $settings = isset($input['settings']) && is_array($input['settings']) ? $input['settings'] : [];

    if ($post_id <= 0 || $element_id === '' || $settings === []) {
        return new WP_Error('missing_params', __('post_id, element_id, and settings are required.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    $element = tpae_mcp_find_element_by_id($page_data, $element_id);
    if ($element === null) {
        return new WP_Error('element_not_found', __('Element not found.', 'tpebl'));
    }

    if (($element['elType'] ?? '') !== 'container') {
        return new WP_Error('not_container', __('Target element is not a container.', 'tpebl'));
    }

    if (!tpae_mcp_update_element_settings($page_data, $element_id, $settings)) {
        return new WP_Error('update_failed', __('Failed to update container settings.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return ['success' => true, 'element_id' => $element_id];
}

function tpae_mcp_update_element_ability(array $input)
{
    $post_id = absint($input['post_id'] ?? 0);
    $element_id = sanitize_text_field((string) ($input['element_id'] ?? ''));
    $settings = isset($input['settings']) && is_array($input['settings']) ? $input['settings'] : [];

    if ($post_id <= 0 || $element_id === '' || $settings === []) {
        return new WP_Error('missing_params', __('post_id, element_id, and settings are required.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    $element = tpae_mcp_find_element_by_id($page_data, $element_id);
    if ($element === null) {
        return new WP_Error('element_not_found', __('Element not found.', 'tpebl'));
    }

    if (!tpae_mcp_update_element_settings($page_data, $element_id, $settings)) {
        return new WP_Error('update_failed', __('Failed to update element settings.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return [
        'success' => true,
        'element_id' => $element_id,
        'element_type' => (string) ($element['elType'] ?? ''),
        'widget_type' => (string) ($element['widgetType'] ?? ''),
    ];
}

function tpae_mcp_move_element_ability(array $input)
{
    $post_id = absint($input['post_id'] ?? 0);
    $element_id = sanitize_text_field((string) ($input['element_id'] ?? ''));
    $target_parent_id = sanitize_text_field((string) ($input['target_parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);

    if ($post_id <= 0 || $element_id === '') {
        return new WP_Error('missing_params', __('post_id and element_id are required.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    $element = tpae_mcp_find_element_by_id($page_data, $element_id);
    if ($element === null) {
        return new WP_Error('element_not_found', __('Element not found.', 'tpebl'));
    }

    if (!tpae_mcp_remove_elementor_element($page_data, $element_id)) {
        return new WP_Error('remove_failed', __('Failed to remove element from current position.', 'tpebl'));
    }

    if ($target_parent_id === '') {
        tpae_mcp_insert_at_position($page_data, $element, $position);
    } elseif (!tpae_mcp_insert_elementor_element($page_data, $target_parent_id, $element, $position)) {
        return new WP_Error('insert_failed', __('Failed to insert element at target position.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return ['success' => true];
}

function tpae_mcp_reorder_elements_ability(array $input)
{
    $post_id = absint($input['post_id'] ?? 0);
    $container_id = sanitize_text_field((string) ($input['container_id'] ?? ''));
    $element_ids = isset($input['element_ids']) && is_array($input['element_ids']) ? array_values($input['element_ids']) : [];

    if ($post_id <= 0 || $container_id === '' || $element_ids === []) {
        return new WP_Error('missing_params', __('post_id, container_id, and element_ids are required.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    $container = tpae_mcp_find_element_by_id($page_data, $container_id);
    if ($container === null) {
        return new WP_Error('element_not_found', __('Container not found.', 'tpebl'));
    }

    if (($container['elType'] ?? '') !== 'container') {
        return new WP_Error('not_container', __('Element is not a container.', 'tpebl'));
    }

    $children = $container['elements'] ?? [];
    $children_by_id = [];
    foreach ($children as $child) {
        if (!empty($child['id'])) {
            $children_by_id[$child['id']] = $child;
        }
    }

    $reordered = [];
    foreach ($element_ids as $child_id) {
        $child_id = sanitize_text_field((string) $child_id);
        if (!isset($children_by_id[$child_id])) {
            return new WP_Error('invalid_element_id', __('One or more element IDs are not direct children of the container.', 'tpebl'));
        }

        $reordered[] = $children_by_id[$child_id];
        unset($children_by_id[$child_id]);
    }

    foreach ($children_by_id as $remaining) {
        $reordered[] = $remaining;
    }

    if (!tpae_mcp_replace_container_children($page_data, $container_id, $reordered)) {
        return new WP_Error('reorder_failed', __('Failed to reorder elements.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return ['success' => true];
}

function tpae_mcp_remove_element_ability(array $input)
{
    $post_id = absint($input['post_id'] ?? 0);
    $element_id = sanitize_text_field((string) ($input['element_id'] ?? ''));

    if ($post_id <= 0 || $element_id === '') {
        return new WP_Error('missing_params', __('post_id and element_id are required.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    if (!tpae_mcp_remove_elementor_element($page_data, $element_id)) {
        return new WP_Error('element_not_found', __('Element not found.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return ['success' => true];
}

function tpae_mcp_duplicate_element_ability(array $input)
{
    $post_id = absint($input['post_id'] ?? 0);
    $element_id = sanitize_text_field((string) ($input['element_id'] ?? ''));

    if ($post_id <= 0 || $element_id === '') {
        return new WP_Error('missing_params', __('post_id and element_id are required.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    $element = tpae_mcp_find_element_by_id($page_data, $element_id);
    if ($element === null) {
        return new WP_Error('element_not_found', __('Element not found.', 'tpebl'));
    }

    $clone = tpae_mcp_clone_element_tree($element);
    if (!tpae_mcp_insert_after_element($page_data, $element_id, $clone)) {
        return new WP_Error('insert_failed', __('Failed to insert duplicate.', 'tpebl'));
    }

    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) {
        return $save_result;
    }

    return ['new_element_id' => $clone['id']];
}

function tpae_mcp_get_page_structure_ability(array $input)
{
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id <= 0) {
        return new WP_Error('missing_post_id', __('The post_id parameter is required.', 'tpebl'));
    }

    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) {
        return $page_data;
    }

    return [
        'post_id' => $post_id,
        'element_count' => tpae_mcp_count_elements($page_data),
        'elements' => tpae_mcp_format_element_tree($page_data),
    ];
}

function tpae_mcp_insert_at_position(array &$data, array $element, int $position = -1): void
{
    if ($position < 0 || $position >= count($data)) {
        $data[] = $element;
        return;
    }

    array_splice($data, $position, 0, [$element]);
}

function tpae_mcp_find_element_by_id(array $data, string $id): ?array
{
    foreach ($data as $element) {
        if (($element['id'] ?? '') === $id) {
            return $element;
        }

        if (!empty($element['elements']) && is_array($element['elements'])) {
            $found = tpae_mcp_find_element_by_id($element['elements'], $id);
            if ($found !== null) {
                return $found;
            }
        }
    }

    return null;
}

function tpae_mcp_update_element_settings(array &$data, string $element_id, array $settings): bool
{
    foreach ($data as &$item) {
        if (($item['id'] ?? '') === $element_id) {
            $current = isset($item['settings']) && is_array($item['settings']) ? $item['settings'] : [];
            $item['settings'] = array_merge($current, $settings);
            return true;
        }

        if (!empty($item['elements']) && is_array($item['elements'])) {
            if (tpae_mcp_update_element_settings($item['elements'], $element_id, $settings)) {
                return true;
            }
        }
    }

    return false;
}

function tpae_mcp_remove_elementor_element(array &$data, string $element_id): bool
{
    foreach ($data as $index => &$item) {
        if (($item['id'] ?? '') === $element_id) {
            array_splice($data, $index, 1);
            return true;
        }

        if (!empty($item['elements']) && is_array($item['elements'])) {
            if (tpae_mcp_remove_elementor_element($item['elements'], $element_id)) {
                return true;
            }
        }
    }

    return false;
}

function tpae_mcp_replace_container_children(array &$data, string $container_id, array $children): bool
{
    foreach ($data as &$item) {
        if (($item['id'] ?? '') === $container_id) {
            $item['elements'] = $children;
            return true;
        }

        if (!empty($item['elements']) && is_array($item['elements'])) {
            if (tpae_mcp_replace_container_children($item['elements'], $container_id, $children)) {
                return true;
            }
        }
    }

    return false;
}

function tpae_mcp_clone_element_tree(array $element): array
{
    $element['id'] = tpae_mcp_generate_elementor_element_id();
    if (!empty($element['elements']) && is_array($element['elements'])) {
        foreach ($element['elements'] as $index => $child) {
            $element['elements'][$index] = tpae_mcp_clone_element_tree($child);
        }
    }

    return $element;
}

function tpae_mcp_insert_after_element(array &$data, string $target_id, array $element): bool
{
    foreach ($data as $index => &$item) {
        if (($item['id'] ?? '') === $target_id) {
            array_splice($data, $index + 1, 0, [$element]);
            return true;
        }

        if (!empty($item['elements']) && is_array($item['elements'])) {
            if (tpae_mcp_insert_after_element($item['elements'], $target_id, $element)) {
                return true;
            }
        }
    }

    return false;
}

function tpae_mcp_format_element_tree(array $elements): array
{
    $formatted = [];

    foreach ($elements as $element) {
        $settings = isset($element['settings']) && is_array($element['settings']) ? array_keys($element['settings']) : [];

        $formatted[] = [
            'id' => (string) ($element['id'] ?? ''),
            'element_type' => (string) ($element['elType'] ?? ''),
            'widget_type' => (string) ($element['widgetType'] ?? ''),
            'is_inner' => (bool) ($element['isInner'] ?? false),
            'setting_keys' => array_values($settings),
            'children' => !empty($element['elements']) && is_array($element['elements'])
                ? tpae_mcp_format_element_tree($element['elements'])
                : [],
        ];
    }

    return $formatted;
}

function tpae_mcp_count_elements(array $elements): int
{
    $count = 0;

    foreach ($elements as $element) {
        $count++;
        if (!empty($element['elements']) && is_array($element['elements'])) {
            $count += tpae_mcp_count_elements($element['elements']);
        }
    }

    return $count;
}
