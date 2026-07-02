<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-blockquote', [
    'label' => __('Blockquote', 'tpebl'),
    'description' => __('Adds the The Plus "Blockquote" widget (tp-blockquote) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'style' => ['type' => 'string', 'description' => 'Style', 'enum' => ['columns', 'style-1', 'style-2']],
        'content_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'devices', 'icon', 'justify', 'left', 'prefix_class', 'right']],
        'content_description' => ['type' => 'string', 'description' => 'Description'],
        'quote_author' => ['type' => 'string', 'description' => 'Author'],
        'quote_author_desc' => ['type' => 'string', 'description' => 'Author Description'],
        'quote_icon' => ['type' => 'string', 'description' => 'Icon', 'enum' => ['yes', 'no']],
        'quote_icon_select' => ['type' => 'string', 'description' => 'Icon Library'],
        'quote_icon_pos' => ['type' => 'string', 'description' => 'Position', 'enum' => ['qip_both', 'qip_bottm', 'qip_top', 'quote_icon', 'style!']],
        'quote_icon_pos_align' => ['type' => 'string', 'description' => 'Alignment', 'enum' => ['qipa_left', 'qipa_right', 'quote_icon', 'quote_icon_pos', 'style!']],
        'quote_icon_pos_align_both' => ['type' => 'string', 'description' => 'Alignment', 'enum' => ['qipa_center', 'qipa_left', 'qipa_opposite', 'qipa_right', 'quote_icon', 'quote_icon_pos', 'style!']],
        'quote_tweet' => ['type' => 'string', 'description' => 'quote_tweet', 'enum' => ['yes', 'no']],
        'quote_tweet_icon_select' => ['type' => 'string', 'description' => 'Tweet Icon'],
        'quote_tweet_text' => ['type' => 'string', 'description' => 'Text'],
        'quote_tweet_link' => ['type' => 'string', 'description' => 'Tweet Current Page', 'enum' => ['yes', 'no']],
        'quote_iamge_switch' => ['type' => 'string', 'description' => 'Image', 'enum' => ['yes', 'no']],
        'quote_image' => ['type' => 'integer', 'description' => 'Select (Image ID)'],
        'quote_dropcap' => ['type' => 'string', 'description' => 'Drop Cap', 'enum' => ['yes', 'no']],
        'border_layout' => ['type' => 'string', 'description' => 'Border Layout', 'enum' => ['bl_1', 'bl_2', 'bl_3', 'columns', 'none']],
        'quote_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'quote_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'content_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'author_color' => ['type' => 'string', 'description' => 'Author Color (Color Hex/RGBA)'],
        'content_hover_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'author_hover_color' => ['type' => 'string', 'description' => 'Author Color (Color Hex/RGBA)'],
        'quote_color' => ['type' => 'string', 'description' => 'Quote Color (Color Hex/RGBA)'],
        'dropcap_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'dropcap_color_n' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'dropcap_color_h' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'desc_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'desc_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'author_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'flex-end', 'flex-start', 'icon', '{{WRAPPER}} .plus_blockquote.quote-style-2 .quote-text .quote_author']],
        'author_main_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'author_main_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'author_main_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'author_desc_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'author_desc_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'author_desc_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'author_extras_heading' => ['type' => 'string', 'description' => 'Author Extras', 'enum' => ['yes', 'no']],
        'author_extras_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['yes', 'no']],
        'ae_left' => ['type' => 'object', 'description' => 'Left (Slider/Size Object)'],
        'ae_right' => ['type' => 'object', 'description' => 'Top (Slider/Size Object)'],
        'ae_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'ae_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'image_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'image_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'image_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'flex-end', 'flex-start', 'icon', '{{WRAPPER}} .tp-bq-imr-wrap']],
        'image_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        'image_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'icon_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'icon_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        'icon_pos_top1' => ['type' => 'object', 'description' => 'Top Icon Offset (Slider/Size Object)'],
        'icon_pos_top_left1' => ['type' => 'object', 'description' => 'Left Icon Offset (Slider/Size Object)'],
        'icon_pos_top_right1' => ['type' => 'object', 'description' => 'Right Icon Offset (Slider/Size Object)'],
        'icon_pos_bottom_bottom1' => ['type' => 'object', 'description' => 'Bottom Icon Offset (Slider/Size Object)'],
        'icon_pos_bottom_left1' => ['type' => 'object', 'description' => 'Left Icon Offset (Slider/Size Object)'],
        'icon_pos_bottom_right1' => ['type' => 'object', 'description' => 'Right Icon Offset (Slider/Size Object)'],
        'icon_pos_both_top_bottom1' => ['type' => 'object', 'description' => 'Top/Bottom Icon Offset (Slider/Size Object)'],
        'iplt_icon' => ['type' => 'object', 'description' => 'Left Top Icon Offset (Slider/Size Object)'],
        'ipbr_icon' => ['type' => 'object', 'description' => 'Right Bottom Icon Offset (Slider/Size Object)'],
        'ipld_icon' => ['type' => 'object', 'description' => 'Left Icon Offset (Slider/Size Object)'],
        'ipright_icon' => ['type' => 'object', 'description' => 'Right Icon Offset (Slider/Size Object)'],
        'icon_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'icon_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'tweet_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'flex-end', 'flex-start', 'icon', '{{WRAPPER}} .plus_blockquote .tp-bq-tweet-wrapper']],
        'tweet_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'tweet_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'tweet_svg_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'tweet_svg_offset' => ['type' => 'object', 'description' => 'Icon Offset (Slider/Size Object)'],
        'tweet_color_n' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'tweet_br_n' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'tweet_color_h' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'tweet_br_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'tweet_extras_heading' => ['type' => 'string', 'description' => 'Tweet Extras', 'enum' => ['yes', 'no']],
        'tweet_extras_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['yes', 'no']],
        'tw_left' => ['type' => 'object', 'description' => 'Left (Slider/Size Object)'],
        'tw_right' => ['type' => 'object', 'description' => 'Top (Slider/Size Object)'],
        'bl1o_i_height' => ['type' => 'object', 'description' => 'Height (Slider/Size Object)'],
        'bl1o_i__br_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'bl1o_size' => ['type' => 'object', 'description' => 'Border Size (Slider/Size Object)'],
        'bl1o_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'bl1o_br' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'bl2o_width_height' => ['type' => 'object', 'description' => 'Background Size (Slider/Size Object)'],
        'bl2o_bgcolor1' => ['type' => 'string', 'description' => 'Background Color1 (Color Hex/RGBA)'],
        'bl2o_bgcolor2' => ['type' => 'string', 'description' => 'Background Color2 (Color Hex/RGBA)'],
        'bl2o_bgcolor1_h' => ['type' => 'string', 'description' => 'Background Color1 (Color Hex/RGBA)'],
        'bl2o_bgcolor2_h' => ['type' => 'string', 'description' => 'Background Color2 (Color Hex/RGBA)'],
        'bl3_corner_dot_bg_color' => ['type' => 'string', 'description' => 'Corner Background Color (Color Hex/RGBA)'],
        'bl3_corner_dot_color' => ['type' => 'string', 'description' => 'Corner Border Color (Color Hex/RGBA)'],
        'bl3_corner_dot_bs' => ['type' => 'object', 'description' => 'Corner Border Size (Slider/Size Object)'],
        'bl3_corner_dot_bsize' => ['type' => 'object', 'description' => 'Corner Position (Slider/Size Object)'],
        'bl3_corner_dot_bsize_n' => ['type' => 'object', 'description' => 'Corner Size (Slider/Size Object)'],
        'box_padding_n' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'box_margin_n' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'box_border' => ['type' => 'string', 'description' => 'Box Border', 'enum' => ['yes', 'no']],
        'border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['box_border', '{{WRAPPER}} .plus_blockquote']],
        'box_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'box_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'box_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'border_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports multi-state stylistic transitions, dynamic tweet-this logic, and responsive brand geometry.']
        ],
        'required' => ['post_id', 'parent_id', 'content_description'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_blockquote_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_blockquote_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_blockquote_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_blockquote_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-blockquote';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Blockquote widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['style'])) { $settings['style'] = sanitize_text_field($input['style']); }
    if (isset($input['content_align'])) { $settings['content_align'] = $input['content_align']; }
    if (isset($input['content_description'])) { $settings['content_description'] = sanitize_text_field($input['content_description']); }
    if (isset($input['quote_author'])) { $settings['quote_author'] = sanitize_text_field($input['quote_author']); }
    if (isset($input['quote_author_desc'])) { $settings['quote_author_desc'] = sanitize_text_field($input['quote_author_desc']); }
    if (isset($input['quote_icon'])) { $settings['quote_icon'] = sanitize_text_field($input['quote_icon']); }
    if (isset($input['quote_icon_select'])) { $settings['quote_icon_select'] = sanitize_text_field($input['quote_icon_select']); }
    if (isset($input['quote_icon_pos'])) { $settings['quote_icon_pos'] = sanitize_text_field($input['quote_icon_pos']); }
    if (isset($input['quote_icon_pos_align'])) { $settings['quote_icon_pos_align'] = sanitize_text_field($input['quote_icon_pos_align']); }
    if (isset($input['quote_icon_pos_align_both'])) { $settings['quote_icon_pos_align_both'] = sanitize_text_field($input['quote_icon_pos_align_both']); }
    if (isset($input['quote_tweet'])) { $settings['quote_tweet'] = sanitize_text_field($input['quote_tweet']); }
    if (isset($input['quote_tweet_icon_select'])) { $settings['quote_tweet_icon_select'] = sanitize_text_field($input['quote_tweet_icon_select']); }
    if (isset($input['quote_tweet_text'])) { $settings['quote_tweet_text'] = sanitize_text_field($input['quote_tweet_text']); }
    if (isset($input['quote_tweet_link'])) { $settings['quote_tweet_link'] = sanitize_text_field($input['quote_tweet_link']); }
    if (isset($input['quote_iamge_switch'])) { $settings['quote_iamge_switch'] = sanitize_text_field($input['quote_iamge_switch']); }
    if (!empty($input['quote_image'])) { $settings['quote_image'] = ['id' => absint($input['quote_image'])]; }
    if (isset($input['quote_dropcap'])) { $settings['quote_dropcap'] = sanitize_text_field($input['quote_dropcap']); }
    if (isset($input['border_layout'])) { $settings['border_layout'] = sanitize_text_field($input['border_layout']); }
    if (isset($input['quote_padding'])) { $settings['quote_padding'] = $input['quote_padding']; }
    if (isset($input['quote_margin'])) { $settings['quote_margin'] = $input['quote_margin']; }
    if (isset($input['content_color'])) { $settings['content_color'] = sanitize_text_field($input['content_color']); }
    if (isset($input['author_color'])) { $settings['author_color'] = sanitize_text_field($input['author_color']); }
    if (isset($input['content_hover_color'])) { $settings['content_hover_color'] = sanitize_text_field($input['content_hover_color']); }
    if (isset($input['author_hover_color'])) { $settings['author_hover_color'] = sanitize_text_field($input['author_hover_color']); }
    if (isset($input['quote_color'])) { $settings['quote_color'] = sanitize_text_field($input['quote_color']); }
    if (isset($input['dropcap_padding'])) { $settings['dropcap_padding'] = $input['dropcap_padding']; }
    if (isset($input['dropcap_color_n'])) { $settings['dropcap_color_n'] = sanitize_text_field($input['dropcap_color_n']); }
    if (isset($input['dropcap_color_h'])) { $settings['dropcap_color_h'] = sanitize_text_field($input['dropcap_color_h']); }
    if (isset($input['desc_padding'])) { $settings['desc_padding'] = $input['desc_padding']; }
    if (isset($input['desc_margin'])) { $settings['desc_margin'] = $input['desc_margin']; }
    if (isset($input['author_align'])) { $settings['author_align'] = $input['author_align']; }
    if (isset($input['author_main_padding'])) { $settings['author_main_padding'] = $input['author_main_padding']; }
    if (isset($input['author_main_margin'])) { $settings['author_main_margin'] = $input['author_main_margin']; }
    if (isset($input['author_main_color'])) { $settings['author_main_color'] = sanitize_text_field($input['author_main_color']); }
    if (isset($input['author_desc_margin'])) { $settings['author_desc_margin'] = $input['author_desc_margin']; }
    if (isset($input['author_desc_padding'])) { $settings['author_desc_padding'] = $input['author_desc_padding']; }
    if (isset($input['author_desc_color'])) { $settings['author_desc_color'] = sanitize_text_field($input['author_desc_color']); }
    if (isset($input['author_extras_heading'])) { $settings['author_extras_heading'] = sanitize_text_field($input['author_extras_heading']); }
    if (isset($input['author_extras_position'])) { $settings['author_extras_position'] = sanitize_text_field($input['author_extras_position']); }
    if (isset($input['ae_left'])) { $settings['ae_left'] = $input['ae_left']; }
    if (isset($input['ae_right'])) { $settings['ae_right'] = $input['ae_right']; }
    if (isset($input['ae_padding'])) { $settings['ae_padding'] = $input['ae_padding']; }
    if (isset($input['ae_radius'])) { $settings['ae_radius'] = $input['ae_radius']; }
    if (isset($input['image_padding'])) { $settings['image_padding'] = $input['image_padding']; }
    if (isset($input['image_margin'])) { $settings['image_margin'] = $input['image_margin']; }
    if (isset($input['image_align'])) { $settings['image_align'] = $input['image_align']; }
    if (isset($input['image_size'])) { $settings['image_size'] = $input['image_size']; }
    if (isset($input['image_radius'])) { $settings['image_radius'] = $input['image_radius']; }
    if (isset($input['icon_padding'])) { $settings['icon_padding'] = $input['icon_padding']; }
    if (isset($input['icon_size'])) { $settings['icon_size'] = $input['icon_size']; }
    if (isset($input['icon_pos_top1'])) { $settings['icon_pos_top1'] = $input['icon_pos_top1']; }
    if (isset($input['icon_pos_top_left1'])) { $settings['icon_pos_top_left1'] = $input['icon_pos_top_left1']; }
    if (isset($input['icon_pos_top_right1'])) { $settings['icon_pos_top_right1'] = $input['icon_pos_top_right1']; }
    if (isset($input['icon_pos_bottom_bottom1'])) { $settings['icon_pos_bottom_bottom1'] = $input['icon_pos_bottom_bottom1']; }
    if (isset($input['icon_pos_bottom_left1'])) { $settings['icon_pos_bottom_left1'] = $input['icon_pos_bottom_left1']; }
    if (isset($input['icon_pos_bottom_right1'])) { $settings['icon_pos_bottom_right1'] = $input['icon_pos_bottom_right1']; }
    if (isset($input['icon_pos_both_top_bottom1'])) { $settings['icon_pos_both_top_bottom1'] = $input['icon_pos_both_top_bottom1']; }
    if (isset($input['iplt_icon'])) { $settings['iplt_icon'] = $input['iplt_icon']; }
    if (isset($input['ipbr_icon'])) { $settings['ipbr_icon'] = $input['ipbr_icon']; }
    if (isset($input['ipld_icon'])) { $settings['ipld_icon'] = $input['ipld_icon']; }
    if (isset($input['ipright_icon'])) { $settings['ipright_icon'] = $input['ipright_icon']; }
    if (isset($input['icon_color'])) { $settings['icon_color'] = sanitize_text_field($input['icon_color']); }
    if (isset($input['icon_radius'])) { $settings['icon_radius'] = $input['icon_radius']; }
    if (isset($input['tweet_align'])) { $settings['tweet_align'] = $input['tweet_align']; }
    if (isset($input['tweet_padding'])) { $settings['tweet_padding'] = $input['tweet_padding']; }
    if (isset($input['tweet_margin'])) { $settings['tweet_margin'] = $input['tweet_margin']; }
    if (isset($input['tweet_svg_size'])) { $settings['tweet_svg_size'] = $input['tweet_svg_size']; }
    if (isset($input['tweet_svg_offset'])) { $settings['tweet_svg_offset'] = $input['tweet_svg_offset']; }
    if (isset($input['tweet_color_n'])) { $settings['tweet_color_n'] = sanitize_text_field($input['tweet_color_n']); }
    if (isset($input['tweet_br_n'])) { $settings['tweet_br_n'] = $input['tweet_br_n']; }
    if (isset($input['tweet_color_h'])) { $settings['tweet_color_h'] = sanitize_text_field($input['tweet_color_h']); }
    if (isset($input['tweet_br_h'])) { $settings['tweet_br_h'] = $input['tweet_br_h']; }
    if (isset($input['tweet_extras_heading'])) { $settings['tweet_extras_heading'] = sanitize_text_field($input['tweet_extras_heading']); }
    if (isset($input['tweet_extras_position'])) { $settings['tweet_extras_position'] = sanitize_text_field($input['tweet_extras_position']); }
    if (isset($input['tw_left'])) { $settings['tw_left'] = $input['tw_left']; }
    if (isset($input['tw_right'])) { $settings['tw_right'] = $input['tw_right']; }
    if (isset($input['bl1o_i_height'])) { $settings['bl1o_i_height'] = $input['bl1o_i_height']; }
    if (isset($input['bl1o_i__br_h'])) { $settings['bl1o_i__br_h'] = $input['bl1o_i__br_h']; }
    if (isset($input['bl1o_size'])) { $settings['bl1o_size'] = $input['bl1o_size']; }
    if (isset($input['bl1o_color'])) { $settings['bl1o_color'] = sanitize_text_field($input['bl1o_color']); }
    if (isset($input['bl1o_br'])) { $settings['bl1o_br'] = $input['bl1o_br']; }
    if (isset($input['bl2o_width_height'])) { $settings['bl2o_width_height'] = $input['bl2o_width_height']; }
    if (isset($input['bl2o_bgcolor1'])) { $settings['bl2o_bgcolor1'] = sanitize_text_field($input['bl2o_bgcolor1']); }
    if (isset($input['bl2o_bgcolor2'])) { $settings['bl2o_bgcolor2'] = sanitize_text_field($input['bl2o_bgcolor2']); }
    if (isset($input['bl2o_bgcolor1_h'])) { $settings['bl2o_bgcolor1_h'] = sanitize_text_field($input['bl2o_bgcolor1_h']); }
    if (isset($input['bl2o_bgcolor2_h'])) { $settings['bl2o_bgcolor2_h'] = sanitize_text_field($input['bl2o_bgcolor2_h']); }
    if (isset($input['bl3_corner_dot_bg_color'])) { $settings['bl3_corner_dot_bg_color'] = sanitize_text_field($input['bl3_corner_dot_bg_color']); }
    if (isset($input['bl3_corner_dot_color'])) { $settings['bl3_corner_dot_color'] = sanitize_text_field($input['bl3_corner_dot_color']); }
    if (isset($input['bl3_corner_dot_bs'])) { $settings['bl3_corner_dot_bs'] = $input['bl3_corner_dot_bs']; }
    if (isset($input['bl3_corner_dot_bsize'])) { $settings['bl3_corner_dot_bsize'] = $input['bl3_corner_dot_bsize']; }
    if (isset($input['bl3_corner_dot_bsize_n'])) { $settings['bl3_corner_dot_bsize_n'] = $input['bl3_corner_dot_bsize_n']; }
    if (isset($input['box_padding_n'])) { $settings['box_padding_n'] = $input['box_padding_n']; }
    if (isset($input['box_margin_n'])) { $settings['box_margin_n'] = $input['box_margin_n']; }
    if (isset($input['box_border'])) { $settings['box_border'] = sanitize_text_field($input['box_border']); }
    if (isset($input['border_style'])) { $settings['border_style'] = sanitize_text_field($input['border_style']); }
    if (isset($input['box_border_color'])) { $settings['box_border_color'] = sanitize_text_field($input['box_border_color']); }
    if (isset($input['box_border_width'])) { $settings['box_border_width'] = $input['box_border_width']; }
    if (isset($input['border_radius'])) { $settings['border_radius'] = $input['border_radius']; }
    if (isset($input['box_border_hover_color'])) { $settings['box_border_hover_color'] = sanitize_text_field($input['box_border_hover_color']); }
    if (isset($input['border_hover_radius'])) { $settings['border_hover_radius'] = $input['border_hover_radius']; }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
