<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-heading-animation', [
    'label' => __('Heading Animation', 'tpebl'),
    'description' => __('Adds the The Plus "Heading Animation" widget (tp-heading-animation) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'anim_styles' => ['type' => 'string', 'description' => 'Animation Style', 'enum' => ['columns', 'style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6']],
        'prefix' => ['type' => 'string', 'description' => 'Prefix Text'],
        'ani_title' => ['type' => 'string', 'description' => 'Animated Text'],
        'ani_title_tag' => ['type' => 'string', 'description' => 'Animated Text Tag'],
        'postfix' => ['type' => 'string', 'description' => 'Postfix Text'],
        'heading_text_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'icon', 'left', 'right', '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline,{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline span']],
        'heading_anim_color' => ['type' => 'string', 'description' => 'Font Color (Color Hex/RGBA)'],
        'ani_color' => ['type' => 'string', 'description' => 'Font Color (Color Hex/RGBA)'],
        'ani_bg_color' => ['type' => 'string', 'description' => 'Animation Background Color (Color Hex/RGBA)'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports multi-line kinetic sequences, SVG stroke typography, and hardware-accelerated entry physics.']
        ],
        'required' => ['post_id', 'parent_id', 'ani_title'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_heading_animation_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_heading_animation_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_heading_animation_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_heading_animation_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-heading-animation';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Heading Animation widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['anim_styles'])) { $settings['anim_styles'] = sanitize_text_field($input['anim_styles']); }
    if (isset($input['prefix'])) { $settings['prefix'] = sanitize_text_field($input['prefix']); }
    if (isset($input['ani_title'])) { $settings['ani_title'] = sanitize_text_field($input['ani_title']); }
    if (isset($input['ani_title_tag'])) { $settings['ani_title_tag'] = sanitize_text_field($input['ani_title_tag']); }
    if (isset($input['postfix'])) { $settings['postfix'] = sanitize_text_field($input['postfix']); }
    if (isset($input['heading_text_align'])) { $settings['heading_text_align'] = $input['heading_text_align']; }
    if (isset($input['heading_anim_color'])) { $settings['heading_anim_color'] = sanitize_text_field($input['heading_anim_color']); }
    if (isset($input['ani_color'])) { $settings['ani_color'] = sanitize_text_field($input['ani_color']); }
    if (isset($input['ani_bg_color'])) { $settings['ani_bg_color'] = sanitize_text_field($input['ani_bg_color']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
