<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-dynamic-categories', [
    'label' => __('Dynamic Categories', 'tpebl'),
    'description' => __('Adds the The Plus "Dynamic Categories" widget (tp-dynamic-categories) to an Elementor container.', 'tpebl'),
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
        'style' => ['type' => 'string', 'description' => 'Style', 'enum' => ['columns', 'style_1', 'style_2', 'style_3']],
        'layout' => ['type' => 'string', 'description' => 'Layout', 'enum' => ['carousel', 'columns', 'grid', 'masonry', 'metro']],
        'layout_pro_options' => ['type' => 'string', 'description' => 'layout_pro_options'],
        'post_taxonomies' => ['type' => 'string', 'description' => 'Taxonomies', 'enum' => ['layout!']],
        'text_alignment_st1' => ['type' => 'string', 'description' => 'Alignment', 'enum' => ['center', 'flex-end', 'flex-start', 'icon', 'style', 'style!', 'toggle', '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_1 .pt-dynamic-hover-content']],
        'text_alignment_st2' => ['type' => 'string', 'description' => 'Alignment', 'enum' => ['center', 'icon', 'left', 'right', 'style', 'style!', 'toggle', '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_2 .pt-dynamic-hover-content-inner']],
        'align_offset' => ['type' => 'string', 'description' => 'Offset', 'enum' => ['center', 'flex-end', 'flex-start', 'icon', 'style!', 'toggle', '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-content']],
        'hide_empty' => ['type' => 'string', 'description' => 'Hide Empty', 'enum' => ['yes', 'no']],
        'hide_parent_cat' => ['type' => 'string', 'description' => 'Hide Parent Categories', 'enum' => ['yes', 'no']],
        'hide_sub_cat' => ['type' => 'string', 'description' => 'Hide Sub Categories', 'enum' => ['yes', 'no']],
        'post_category' => ['type' => 'string', 'description' => 'Include Terms ID'],
        'post_category_exc' => ['type' => 'string', 'description' => 'Exclude Terms ID'],
        'display_posts' => ['type' => 'string', 'description' => 'Maximum Categories Display'],
        'post_offset' => ['type' => 'string', 'description' => 'Offset Categories'],
        'post_order_by' => ['type' => 'string', 'description' => 'Order By'],
        'post_order' => ['type' => 'string', 'description' => 'Order'],
        'desktop_column' => ['type' => 'string', 'description' => 'Desktop Column', 'enum' => ['layout!']],
        'tablet_column' => ['type' => 'string', 'description' => 'Tablet Column', 'enum' => ['layout!']],
        'mobile_column' => ['type' => 'string', 'description' => 'Mobile Column', 'enum' => ['layout!']],
        'metro_column' => ['type' => 'string', 'description' => 'Metro Column', 'enum' => ['3', '4', '5', '6', 'layout']],
        'metro_style_3' => ['type' => 'string', 'description' => 'Metro Style', 'enum' => ['layout', 'metro_column']],
        'columns_gap' => ['type' => 'object', 'description' => 'Columns Gap/Space Between (Dimensions Object)'],
        'hide_pro_count' => ['type' => 'string', 'description' => 'Display Product Count', 'enum' => ['yes', 'no']],
        'display_description' => ['type' => 'string', 'description' => 'Display Description', 'enum' => ['yes', 'no']],
        'desc_text_limit' => ['type' => 'string', 'description' => 'Display Description Limit', 'enum' => ['yes', 'no']],
        'display_description_by' => ['type' => 'string', 'description' => 'Limit on', 'enum' => ['char', 'desc_text_limit', 'display_description', 'style!', 'word']],
        'display_description_input' => ['type' => 'string', 'description' => 'Description Count'],
        'display_title_3_dots' => ['type' => 'string', 'description' => 'Display Dots', 'enum' => ['yes', 'no']],
        'display_thumbnail' => ['type' => 'string', 'description' => 'Display Image Size', 'enum' => ['yes', 'no']],
        'on_hover_bg_image' => ['type' => 'string', 'description' => 'On Hover Background Image', 'enum' => ['yes', 'no']],
        'tpae_theme_builder' => ['type' => 'string', 'description' => 'tpae_theme_builder'],
        'title_color' => ['type' => 'string', 'description' => 'Title Color (Color Hex/RGBA)'],
        'title_hover_color' => ['type' => 'string', 'description' => 'Title Color (Color Hex/RGBA)'],
        'title_bg' => ['type' => 'string', 'description' => 'Title Background', 'enum' => ['yes', 'no']],
        'title_bg_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'title_bg_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'title_bg_border_radius_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'title_underline' => ['type' => 'string', 'description' => 'Title Underline', 'enum' => ['yes', 'no']],
        't_underline_top_offset' => ['type' => 'object', 'description' => 'Top Offset (Slider/Size Object)'],
        't_underline_height' => ['type' => 'object', 'description' => 'Height (Slider/Size Object)'],
        't_underline_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        't_underline_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        't_underline_size_h' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        't_underline_color_h' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'count_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'count_extra_text' => ['type' => 'string', 'description' => 'Count After Text'],
        'count_width_height_opt' => ['type' => 'object', 'description' => 'Width and Height (Slider/Size Object)'],
        'count_top_bottom' => ['type' => 'object', 'description' => 'Top/Bottom Offset (Slider/Size Object)'],
        'count_left_right' => ['type' => 'object', 'description' => 'Left/Right Offset (Slider/Size Object)'],
        'count_color' => ['type' => 'string', 'description' => 'Count Color (Color Hex/RGBA)'],
        'count_opacity' => ['type' => 'string', 'description' => 'Opacity'],
        'count_transform' => ['type' => 'string', 'description' => 'Transform css'],
        'count_bg_switch' => ['type' => 'string', 'description' => 'Background Option', 'enum' => ['yes', 'no']],
        'count_border_radius_n' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'count_hover_color' => ['type' => 'string', 'description' => 'Count Color (Color Hex/RGBA)'],
        'count_opacity_h' => ['type' => 'string', 'description' => 'Opacity'],
        'count_transform_h' => ['type' => 'string', 'description' => 'Transform css'],
        'count_border_h' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'desc_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'description_alignment_st' => ['type' => 'string', 'description' => 'Text Alignment', 'enum' => ['center', 'icon', 'justify', 'left', 'right', 'toggle', '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper .pt-dynamic-hover-cat-desc']],
        'desc_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'desc_opacity' => ['type' => 'string', 'description' => 'Opacity'],
        'desc_color_h' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'desc_opacity_h' => ['type' => 'string', 'description' => 'Opacity'],
        'desc_bg' => ['type' => 'string', 'description' => 'Description Background', 'enum' => ['yes', 'no']],
        'desc_bg_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'desc_bg_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'desc_bg_border_radius_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'cl_st3_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'cl_st3_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'cl_st3_radius_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'cl_bg_ol_color' => ['type' => 'string', 'description' => 'Whole Overlay Color (Color Hex/RGBA)'],
        'cl_hover_content_swich' => ['type' => 'string', 'description' => 'Hover Content Only', 'enum' => ['yes', 'no']],
        'cl_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'cl_border_radius_hc' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'cl_transform' => ['type' => 'string', 'description' => 'Transform css'],
        'cl_transform_m' => ['type' => 'string', 'description' => 'Transform css'],
        'transition_duration' => ['type' => 'object', 'description' => 'Transition Duration (Slider/Size Object)'],
        'transition_duration_m' => ['type' => 'object', 'description' => 'Transition Duration (Slider/Size Object)'],
        'cl_bg_ol_color_h' => ['type' => 'string', 'description' => 'Whole Overlay Color (Color Hex/RGBA)'],
        'cl_border_radius_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'cl_border_radius_h_hc' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'cl_transform_swich' => ['type' => 'string', 'description' => 'With Content Transform', 'enum' => ['yes', 'no']],
        'cl_transform_h' => ['type' => 'string', 'description' => 'Transform css'],
        'cl_transform_h_m' => ['type' => 'string', 'description' => 'Transform css'],
        'cl_transform_h_all' => ['type' => 'string', 'description' => 'Transform css'],
        'cl_transform_h_all_m' => ['type' => 'string', 'description' => 'Transform css'],
        'cl_transform_h_all_hc' => ['type' => 'string', 'description' => 'Transform css'],
        'cl_inner_switch' => ['type' => 'string', 'description' => 'Inner Content Option', 'enum' => ['yes', 'no']],
        'cl_outer_padding' => ['type' => 'object', 'description' => 'Outer Padding (Dimensions Object)'],
        'cl_inner_padding' => ['type' => 'object', 'description' => 'Inner Padding (Dimensions Object)'],
        'cl_inner_bg_color' => ['type' => 'string', 'description' => 'Background Color (Color Hex/RGBA)'],
        'cl_inner_h_bg_color' => ['type' => 'string', 'description' => 'Hover Background Color (Color Hex/RGBA)'],
        'cl_inner_border_h' => ['type' => 'string', 'description' => 'Hover Border Color (Color Hex/RGBA)'],
        'cl_inner_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'overflow_hidden_opt' => ['type' => 'string', 'description' => 'Overflow', 'enum' => ['cl_hover_content_swich!', 'hidden', 'visible', '{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_1,{{WRAPPER}} .dynamic-cat-list .pt-dynamic-wrapper.style_2']],
        'overflow_pro_options' => ['type' => 'string', 'description' => 'overflow_pro_options'],
        'plus_mouse_move_parallax' => ['type' => 'string', 'description' => 'Mouse Move Parallax', 'enum' => ['yes', 'no']],
        'plus_mouse_pro_options' => ['type' => 'string', 'description' => 'plus_mouse_pro_options'],
        'messy_column' => ['type' => 'string', 'description' => 'Messy Columns', 'enum' => ['yes', 'no']],
        'messy_pro_options' => ['type' => 'string', 'description' => 'messy_pro_options'],
            'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports multi-taxonomy aggregation, dynamic post-count injection, and responsive grid geometry.']
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
    'execute_callback' => 'tpae_mcp_add_theplus_dynamic_categories_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_dynamic_categories_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

/**
 * Require post edit permission because this ability writes Elementor data.
 */
function tpae_mcp_add_theplus_dynamic_categories_permission(?array $input = null): bool
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
 * Add a TP Dynamic Categories widget into an Elementor container.
 *
 * @param array<string, mixed> $input
 * @return array<string, mixed>|WP_Error
 */
function tpae_mcp_add_theplus_dynamic_categories_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-dynamic-categories';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Dynamic Categories widget is not registered on this site.', 'tpebl'));
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

    if (isset($input['style'])) { $settings['style'] = sanitize_text_field($input['style']); }
    if (isset($input['layout'])) { $settings['layout'] = sanitize_text_field($input['layout']); }
    if (isset($input['layout_pro_options'])) { $settings['layout_pro_options'] = sanitize_text_field($input['layout_pro_options']); }
    if (isset($input['post_taxonomies'])) { $settings['post_taxonomies'] = sanitize_text_field($input['post_taxonomies']); }
    if (isset($input['text_alignment_st1'])) { $settings['text_alignment_st1'] = sanitize_text_field($input['text_alignment_st1']); }
    if (isset($input['text_alignment_st2'])) { $settings['text_alignment_st2'] = sanitize_text_field($input['text_alignment_st2']); }
    if (isset($input['align_offset'])) { $settings['align_offset'] = sanitize_text_field($input['align_offset']); }
    if (isset($input['hide_empty'])) { $settings['hide_empty'] = sanitize_text_field($input['hide_empty']); }
    if (isset($input['hide_parent_cat'])) { $settings['hide_parent_cat'] = sanitize_text_field($input['hide_parent_cat']); }
    if (isset($input['hide_sub_cat'])) { $settings['hide_sub_cat'] = sanitize_text_field($input['hide_sub_cat']); }
    if (isset($input['post_category'])) { $settings['post_category'] = sanitize_text_field($input['post_category']); }
    if (isset($input['post_category_exc'])) { $settings['post_category_exc'] = sanitize_text_field($input['post_category_exc']); }
    if (isset($input['display_posts'])) { $settings['display_posts'] = sanitize_text_field($input['display_posts']); }
    if (isset($input['post_offset'])) { $settings['post_offset'] = sanitize_text_field($input['post_offset']); }
    if (isset($input['post_order_by'])) { $settings['post_order_by'] = sanitize_text_field($input['post_order_by']); }
    if (isset($input['post_order'])) { $settings['post_order'] = sanitize_text_field($input['post_order']); }
    if (isset($input['desktop_column'])) { $settings['desktop_column'] = sanitize_text_field($input['desktop_column']); }
    if (isset($input['tablet_column'])) { $settings['tablet_column'] = sanitize_text_field($input['tablet_column']); }
    if (isset($input['mobile_column'])) { $settings['mobile_column'] = sanitize_text_field($input['mobile_column']); }
    if (isset($input['metro_column'])) { $settings['metro_column'] = sanitize_text_field($input['metro_column']); }
    if (isset($input['metro_style_3'])) { $settings['metro_style_3'] = sanitize_text_field($input['metro_style_3']); }
    if (isset($input['columns_gap'])) { $settings['columns_gap'] = $input['columns_gap']; }
    if (isset($input['hide_pro_count'])) { $settings['hide_pro_count'] = sanitize_text_field($input['hide_pro_count']); }
    if (isset($input['display_description'])) { $settings['display_description'] = sanitize_text_field($input['display_description']); }
    if (isset($input['desc_text_limit'])) { $settings['desc_text_limit'] = sanitize_text_field($input['desc_text_limit']); }
    if (isset($input['display_description_by'])) { $settings['display_description_by'] = sanitize_text_field($input['display_description_by']); }
    if (isset($input['display_description_input'])) { $settings['display_description_input'] = sanitize_text_field($input['display_description_input']); }
    if (isset($input['display_title_3_dots'])) { $settings['display_title_3_dots'] = sanitize_text_field($input['display_title_3_dots']); }
    if (isset($input['display_thumbnail'])) { $settings['display_thumbnail'] = sanitize_text_field($input['display_thumbnail']); }
    if (isset($input['on_hover_bg_image'])) { $settings['on_hover_bg_image'] = sanitize_text_field($input['on_hover_bg_image']); }
    if (isset($input['tpae_theme_builder'])) { $settings['tpae_theme_builder'] = sanitize_text_field($input['tpae_theme_builder']); }
    if (isset($input['title_color'])) { $settings['title_color'] = sanitize_text_field($input['title_color']); }
    if (isset($input['title_hover_color'])) { $settings['title_hover_color'] = sanitize_text_field($input['title_hover_color']); }
    if (isset($input['title_bg'])) { $settings['title_bg'] = sanitize_text_field($input['title_bg']); }
    if (isset($input['title_bg_padding'])) { $settings['title_bg_padding'] = $input['title_bg_padding']; }
    if (isset($input['title_bg_border_radius'])) { $settings['title_bg_border_radius'] = $input['title_bg_border_radius']; }
    if (isset($input['title_bg_border_radius_h'])) { $settings['title_bg_border_radius_h'] = $input['title_bg_border_radius_h']; }
    if (isset($input['title_underline'])) { $settings['title_underline'] = sanitize_text_field($input['title_underline']); }
    if (isset($input['t_underline_top_offset'])) { $settings['t_underline_top_offset'] = $input['t_underline_top_offset']; }
    if (isset($input['t_underline_height'])) { $settings['t_underline_height'] = $input['t_underline_height']; }
    if (isset($input['t_underline_size'])) { $settings['t_underline_size'] = $input['t_underline_size']; }
    if (isset($input['t_underline_color'])) { $settings['t_underline_color'] = sanitize_text_field($input['t_underline_color']); }
    if (isset($input['t_underline_size_h'])) { $settings['t_underline_size_h'] = $input['t_underline_size_h']; }
    if (isset($input['t_underline_color_h'])) { $settings['t_underline_color_h'] = sanitize_text_field($input['t_underline_color_h']); }
    if (isset($input['count_padding'])) { $settings['count_padding'] = $input['count_padding']; }
    if (isset($input['count_extra_text'])) { $settings['count_extra_text'] = sanitize_text_field($input['count_extra_text']); }
    if (isset($input['count_width_height_opt'])) { $settings['count_width_height_opt'] = $input['count_width_height_opt']; }
    if (isset($input['count_top_bottom'])) { $settings['count_top_bottom'] = $input['count_top_bottom']; }
    if (isset($input['count_left_right'])) { $settings['count_left_right'] = $input['count_left_right']; }
    if (isset($input['count_color'])) { $settings['count_color'] = sanitize_text_field($input['count_color']); }
    if (isset($input['count_opacity'])) { $settings['count_opacity'] = sanitize_text_field($input['count_opacity']); }
    if (isset($input['count_transform'])) { $settings['count_transform'] = sanitize_text_field($input['count_transform']); }
    if (isset($input['count_bg_switch'])) { $settings['count_bg_switch'] = sanitize_text_field($input['count_bg_switch']); }
    if (isset($input['count_border_radius_n'])) { $settings['count_border_radius_n'] = $input['count_border_radius_n']; }
    if (isset($input['count_hover_color'])) { $settings['count_hover_color'] = sanitize_text_field($input['count_hover_color']); }
    if (isset($input['count_opacity_h'])) { $settings['count_opacity_h'] = sanitize_text_field($input['count_opacity_h']); }
    if (isset($input['count_transform_h'])) { $settings['count_transform_h'] = sanitize_text_field($input['count_transform_h']); }
    if (isset($input['count_border_h'])) { $settings['count_border_h'] = sanitize_text_field($input['count_border_h']); }
    if (isset($input['desc_margin'])) { $settings['desc_margin'] = $input['desc_margin']; }
    if (isset($input['description_alignment_st'])) { $settings['description_alignment_st'] = sanitize_text_field($input['description_alignment_st']); }
    if (isset($input['desc_color'])) { $settings['desc_color'] = sanitize_text_field($input['desc_color']); }
    if (isset($input['desc_opacity'])) { $settings['desc_opacity'] = sanitize_text_field($input['desc_opacity']); }
    if (isset($input['desc_color_h'])) { $settings['desc_color_h'] = sanitize_text_field($input['desc_color_h']); }
    if (isset($input['desc_opacity_h'])) { $settings['desc_opacity_h'] = sanitize_text_field($input['desc_opacity_h']); }
    if (isset($input['desc_bg'])) { $settings['desc_bg'] = sanitize_text_field($input['desc_bg']); }
    if (isset($input['desc_bg_padding'])) { $settings['desc_bg_padding'] = $input['desc_bg_padding']; }
    if (isset($input['desc_bg_border_radius'])) { $settings['desc_bg_border_radius'] = $input['desc_bg_border_radius']; }
    if (isset($input['desc_bg_border_radius_h'])) { $settings['desc_bg_border_radius_h'] = $input['desc_bg_border_radius_h']; }
    if (isset($input['cl_st3_padding'])) { $settings['cl_st3_padding'] = $input['cl_st3_padding']; }
    if (isset($input['cl_st3_radius'])) { $settings['cl_st3_radius'] = $input['cl_st3_radius']; }
    if (isset($input['cl_st3_radius_h'])) { $settings['cl_st3_radius_h'] = $input['cl_st3_radius_h']; }
    if (isset($input['cl_bg_ol_color'])) { $settings['cl_bg_ol_color'] = sanitize_text_field($input['cl_bg_ol_color']); }
    if (isset($input['cl_hover_content_swich'])) { $settings['cl_hover_content_swich'] = sanitize_text_field($input['cl_hover_content_swich']); }
    if (isset($input['cl_border_radius'])) { $settings['cl_border_radius'] = $input['cl_border_radius']; }
    if (isset($input['cl_border_radius_hc'])) { $settings['cl_border_radius_hc'] = $input['cl_border_radius_hc']; }
    if (isset($input['cl_transform'])) { $settings['cl_transform'] = sanitize_text_field($input['cl_transform']); }
    if (isset($input['cl_transform_m'])) { $settings['cl_transform_m'] = sanitize_text_field($input['cl_transform_m']); }
    if (isset($input['transition_duration'])) { $settings['transition_duration'] = $input['transition_duration']; }
    if (isset($input['transition_duration_m'])) { $settings['transition_duration_m'] = $input['transition_duration_m']; }
    if (isset($input['cl_bg_ol_color_h'])) { $settings['cl_bg_ol_color_h'] = sanitize_text_field($input['cl_bg_ol_color_h']); }
    if (isset($input['cl_border_radius_h'])) { $settings['cl_border_radius_h'] = $input['cl_border_radius_h']; }
    if (isset($input['cl_border_radius_h_hc'])) { $settings['cl_border_radius_h_hc'] = $input['cl_border_radius_h_hc']; }
    if (isset($input['cl_transform_swich'])) { $settings['cl_transform_swich'] = sanitize_text_field($input['cl_transform_swich']); }
    if (isset($input['cl_transform_h'])) { $settings['cl_transform_h'] = sanitize_text_field($input['cl_transform_h']); }
    if (isset($input['cl_transform_h_m'])) { $settings['cl_transform_h_m'] = sanitize_text_field($input['cl_transform_h_m']); }
    if (isset($input['cl_transform_h_all'])) { $settings['cl_transform_h_all'] = sanitize_text_field($input['cl_transform_h_all']); }
    if (isset($input['cl_transform_h_all_m'])) { $settings['cl_transform_h_all_m'] = sanitize_text_field($input['cl_transform_h_all_m']); }
    if (isset($input['cl_transform_h_all_hc'])) { $settings['cl_transform_h_all_hc'] = sanitize_text_field($input['cl_transform_h_all_hc']); }
    if (isset($input['cl_inner_switch'])) { $settings['cl_inner_switch'] = sanitize_text_field($input['cl_inner_switch']); }
    if (isset($input['cl_outer_padding'])) { $settings['cl_outer_padding'] = $input['cl_outer_padding']; }
    if (isset($input['cl_inner_padding'])) { $settings['cl_inner_padding'] = $input['cl_inner_padding']; }
    if (isset($input['cl_inner_bg_color'])) { $settings['cl_inner_bg_color'] = sanitize_text_field($input['cl_inner_bg_color']); }
    if (isset($input['cl_inner_h_bg_color'])) { $settings['cl_inner_h_bg_color'] = sanitize_text_field($input['cl_inner_h_bg_color']); }
    if (isset($input['cl_inner_border_h'])) { $settings['cl_inner_border_h'] = sanitize_text_field($input['cl_inner_border_h']); }
    if (isset($input['cl_inner_border_radius'])) { $settings['cl_inner_border_radius'] = $input['cl_inner_border_radius']; }
    if (isset($input['overflow_hidden_opt'])) { $settings['overflow_hidden_opt'] = sanitize_text_field($input['overflow_hidden_opt']); }
    if (isset($input['overflow_pro_options'])) { $settings['overflow_pro_options'] = sanitize_text_field($input['overflow_pro_options']); }
    if (isset($input['plus_mouse_move_parallax'])) { $settings['plus_mouse_move_parallax'] = sanitize_text_field($input['plus_mouse_move_parallax']); }
    if (isset($input['plus_mouse_pro_options'])) { $settings['plus_mouse_pro_options'] = sanitize_text_field($input['plus_mouse_pro_options']); }
    if (isset($input['messy_column'])) { $settings['messy_column'] = sanitize_text_field($input['messy_column']); }
    if (isset($input['messy_pro_options'])) { $settings['messy_pro_options'] = sanitize_text_field($input['messy_pro_options']); }

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
