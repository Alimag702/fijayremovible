<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-social-embed', [
    'label' => __('Social Embed', 'tpebl'),
    'description' => __('Adds the The Plus "Social Embed" widget (tp-social-embed) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'EmbedType' => ['type' => 'string', 'enum' => ['facebook', 'twitter', 'vimeo', 'instagram', 'youtube', 'googlemap'], 'description' => 'Social platform to embed'],
        'CommentURL' => ['type' => 'string', 'description' => 'URL of the post/content to embed'],
        'AppID' => ['type' => 'string', 'description' => 'Facebook App ID (required for Facebook embeds)'],
                'settings' => ['type' => 'object', 'description' => 'Raw Elementor/The Plus control settings to merge into the widget at creation time. Use control keys from sprout/get-theplus-widget-schema.'],
        ],
        'required' => ['post_id', 'parent_id', 'EmbedType'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_social_embed_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_social_embed_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_social_embed_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_social_embed_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-social-embed';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Social Embed widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (!empty($input['EmbedType'])) { $settings['EmbedType'] = sanitize_key((string)$input['EmbedType']); }
    if (!empty($input['CommentURL'])) { $settings['CommentURL'] = esc_url_raw((string)$input['CommentURL']); }
    if (!empty($input['AppID'])) { $settings['AppID'] = sanitize_text_field((string)$input['AppID']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
