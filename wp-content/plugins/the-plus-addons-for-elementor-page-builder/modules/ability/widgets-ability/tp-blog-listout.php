<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-blog-listout', [
    'label' => __('Blog Listing', 'tpebl'),
    'description' => __('Adds the The Plus "Blog Listing" widget (tp-blog-listout) to an Elementor container.', 'tpebl'),
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
        'style' => ['type' => 'string', 'description' => 'Style'],
        'style_pro_options' => ['type' => 'string', 'description' => 'style_pro_options'],
        'layout' => ['type' => 'string', 'description' => 'Layout'],
        'layout_pro_options' => ['type' => 'string', 'description' => 'layout_pro_options'],
        'content_html' => ['type' => 'string', 'description' => 'HTML'],
        'content_css' => ['type' => 'string', 'description' => 'CSS'],
        'display_posts' => ['type' => 'string', 'description' => 'Maximum Posts Display'],
        'post_offset' => ['type' => 'string', 'description' => 'Offset Posts'],
        'post_category' => ['type' => 'string', 'description' => 'Select Category', 'enum' => ['multiple']],
        'post_tags' => ['type' => 'string', 'description' => 'Select Tags', 'enum' => ['multiple']],
        'post_order_by' => ['type' => 'string', 'description' => 'post_order_by'],
        'post_order' => ['type' => 'string', 'description' => 'Order'],
        'desktop_column' => ['type' => 'string', 'description' => 'Desktop Column', 'enum' => ['layout!']],
        'tablet_column' => ['type' => 'string', 'description' => 'Tablet Column', 'enum' => ['layout!']],
        'mobile_column' => ['type' => 'string', 'description' => 'Mobile Column', 'enum' => ['layout!']],
        'metro_column' => ['type' => 'string', 'description' => 'Metro Column', 'enum' => ['3', '4', '5', '6', 'layout']],
        'metro_style_3' => ['type' => 'string', 'description' => 'Metro Style', 'enum' => ['layout', 'metro_column']],
        'plus_pro_metro_column_options' => ['type' => 'string', 'description' => 'plus_pro_metro_column_options'],
        'columns_gap' => ['type' => 'object', 'description' => 'Columns Gap/Space Between (Dimensions Object)'],
        'post_extra_option' => ['type' => 'string', 'description' => 'Post Loading Options'],
        'post_extra_pro_options' => ['type' => 'string', 'description' => 'post_extra_pro_options'],
        'load_more_btn_text' => ['type' => 'string', 'description' => 'Button Text'],
        'tp_loading_text' => ['type' => 'string', 'description' => 'Loading Text'],
        'loaded_posts_text' => ['type' => 'string', 'description' => 'All Posts Loaded Text'],
        'load_more_post' => ['type' => 'string', 'description' => 'More posts on click/scroll'],
        'load_more_border' => ['type' => 'string', 'description' => 'Load More Border', 'enum' => ['yes', 'no']],
        'load_more_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['layout!', 'load_more_border', 'post_extra_option', '{{WRAPPER}} .ajax_load_more .post-load-more']],
        'load_more_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'load_more_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'load_more_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'load_more_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'load_more_border_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'load_more_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'loaded_posts_color' => ['type' => 'string', 'description' => 'Loaded Posts Text Color (Color Hex/RGBA)'],
        'load_more_color_hover' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'post_title_tag' => ['type' => 'string', 'description' => 'Title Tag'],
        'display_title_limit' => ['type' => 'string', 'description' => 'Title Limit', 'enum' => ['yes', 'no']],
        'display_title_by' => ['type' => 'string', 'description' => 'Limit on', 'enum' => ['char', 'display_title_limit', 'word']],
        'display_title_input' => ['type' => 'string', 'description' => 'Title Count'],
        'display_title_3_dots' => ['type' => 'string', 'description' => 'Display Dots', 'enum' => ['yes', 'no']],
        'display_post_category' => ['type' => 'string', 'description' => 'Display Category Post', 'enum' => ['yes', 'no']],
        'post_category_style' => ['type' => 'string', 'description' => 'Style', 'enum' => ['display_post_category', 'style!']],
        'display_post_category_all' => ['type' => 'string', 'description' => 'Display All Category', 'enum' => ['yes', 'no']],
        'display_excerpt' => ['type' => 'string', 'description' => 'Display Excerpt/Content', 'enum' => ['yes', 'no']],
        'post_excerpt_count' => ['type' => 'string', 'description' => 'post_excerpt_count'],
        'show_post_date' => ['type' => 'string', 'description' => 'Date & Time', 'enum' => ['yes', 'no']],
        'show_post_author' => ['type' => 'string', 'description' => 'Author Name', 'enum' => ['yes', 'no']],
        'show_read_time' => ['type' => 'string', 'description' => 'Read Time', 'enum' => ['yes', 'no']],
        'display_button' => ['type' => 'string', 'description' => 'Button', 'enum' => ['yes', 'no']],
        'button_style' => ['type' => 'string', 'description' => 'Button Style', 'enum' => ['display_button', 'style', 'style-7', 'style-8', 'style-9']],
        'button_text' => ['type' => 'string', 'description' => 'Text'],
        'button_icon_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['button_style!', 'display_button', 'font_awesome', 'style']],
        'button_icon' => ['type' => 'string', 'description' => 'Icon'],
        'before_after' => ['type' => 'string', 'description' => 'Icon Position', 'enum' => ['after', 'before', 'button_icon_style!', 'button_style!', 'display_button', 'style']],
        'icon_spacing' => ['type' => 'object', 'description' => 'Icon Spacing (Slider/Size Object)'],
        'display_thumbnail' => ['type' => 'string', 'description' => 'display_thumbnail', 'enum' => ['yes', 'no']],
        'display_thumbnail_options' => ['type' => 'string', 'description' => 'display_thumbnail_options'],
        'display_post_meta' => ['type' => 'string', 'description' => 'Display Post Meta', 'enum' => ['yes', 'no']],
        'post_meta_tag_style' => ['type' => 'string', 'description' => 'Post Meta Tag', 'enum' => ['display_post_meta']],
        'author_prefix' => ['type' => 'string', 'description' => 'Author Prefix'],
        'filter_category' => ['type' => 'string', 'description' => 'filter_category', 'enum' => ['yes', 'no']],
        'filter_category_options' => ['type' => 'string', 'description' => 'filter_category_options'],
        'tpae_theme_builder' => ['type' => 'string', 'description' => 'tpae_theme_builder'],
        'post_meta_color' => ['type' => 'string', 'description' => 'Post Meta Color (Color Hex/RGBA)'],
        'post_meta_color_hover' => ['type' => 'string', 'description' => 'Post Meta Color (Color Hex/RGBA)'],
        'blog_card_layout' => ['type' => 'string', 'description' => 'blog_card_layout', 'enum' => ['yes', 'no']],
        'wrap_flex_direction' => ['type' => 'object', 'description' => 'Layout Direction', 'enum' => ['column', 'column-reverse', 'icon', 'row', 'row-reverse', 'toggle', '{{WRAPPER}} .tpae-compect-blog-wrap']],
        'tp_row_one_width' => ['type' => 'object', 'description' => 'Image Box (Slider/Size Object)'],
        'tp_row_two_width' => ['type' => 'object', 'description' => 'Content Box (Slider/Size Object)'],
        'tp_content_alignment' => ['type' => 'object', 'description' => 'Text Alignment', 'enum' => ['center', 'icon', 'left', 'right', 'toggle', '{{WRAPPER}} .tpae-blog-content']],
        'tp_item_content_alignment' => ['type' => 'object', 'description' => 'Layout Alignment', 'enum' => ['center', 'flex-end', 'flex-start', 'icon', 'toggle', '{{WRAPPER}} .tpae-blog-content']],
        'wrap_gap' => ['type' => 'object', 'description' => 'Item Gap (Slider/Size Object)'],
        'tp_absolute_layout' => ['type' => 'string', 'description' => 'Layout Position', 'enum' => ['yes', 'no']],
        'tp_top_card' => ['type' => 'object', 'description' => 'Left (Slider/Size Object)'],
        'tp_bottom_card' => ['type' => 'object', 'description' => 'bottom (Slider/Size Object)'],
        'tp_width_card' => ['type' => 'object', 'description' => 'Width (Slider/Size Object)'],
        'content_direction' => ['type' => 'object', 'description' => 'Content Direction', 'enum' => ['column', 'column-reverse', 'icon', 'row', 'row-reverse', 'toggle', '{{WRAPPER}} .tpae-blog-content']],
        'content_vertical_justify' => ['type' => 'object', 'description' => 'Vertical Alignment', 'enum' => ['center', 'content_direction', 'flex-end', 'flex-start', 'icon', 'space-around', 'space-between', '{{WRAPPER}} .tpae-blog-content']],
        'blog_content_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'blog_content_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'blog_border_post' => ['type' => 'string', 'description' => 'blog_border_post', 'enum' => ['yes', 'no']],
        'blog_content_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'blog_meta_layout_post' => ['type' => 'string', 'description' => 'blog_meta_layout_post', 'enum' => ['yes', 'no']],
        'meta_flex_direction' => ['type' => 'string', 'description' => 'Meta Direction', 'enum' => ['column', 'column-reverse', 'icon', 'row', 'row-reverse', 'toggle', '{{WRAPPER}} .tpae-blog-meta,{{WRAPPER}} .tpae-blog-meta-overflow']],
        'meta_align_items' => ['type' => 'object', 'description' => 'Meta Align', 'enum' => ['center', 'content_direction', 'flex-end', 'flex-start', 'icon', 'toggle', '{{WRAPPER}} .tpae-blog-meta']],
        'meta_gap' => ['type' => 'object', 'description' => 'Item Gap (Slider/Size Object)'],
        'tp_meta_inner_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'tp_meta_border_r' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'date_overflow' => ['type' => 'string', 'description' => 'Date Position', 'enum' => ['yes', 'no']],
        'category_date_inner_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'date_style_margin_tb' => ['type' => 'object', 'description' => 'Top/Bottom Spacing (Slider/Size Object)'],
        'date_style_margin_lr' => ['type' => 'object', 'description' => 'Left/Right Spacing (Slider/Size Object)'],
        'overflow_date_br' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'meta_overflow' => ['type' => 'string', 'description' => 'Author Position', 'enum' => ['yes', 'no']],
        'category_meta_inner_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'meta_style_margin_tb' => ['type' => 'object', 'description' => 'Top/Bottom Spacing (Slider/Size Object)'],
        'meta_style_margin_lr' => ['type' => 'object', 'description' => 'Left/Right Spacing (Slider/Size Object)'],
        'overflow_meta_br' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'post_tima_overflow' => ['type' => 'string', 'description' => 'Post Time Position', 'enum' => ['yes', 'no']],
        'category_post_time_inner_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'post_style_margin_tb' => ['type' => 'object', 'description' => 'Top/Bottom Spacing (Slider/Size Object)'],
        'post_style_margin_lr' => ['type' => 'object', 'description' => 'Left/Right Spacing (Slider/Size Object)'],
        'overflow_post_time_br' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'button_overflow' => ['type' => 'string', 'description' => 'Button Absolute', 'enum' => ['yes', 'no']],
        'button_style_margin_tb' => ['type' => 'object', 'description' => 'Top/Bottom Spacing (Slider/Size Object)'],
        'button_style_margin_lr' => ['type' => 'object', 'description' => 'Left/Right Spacing (Slider/Size Object)'],
        'blog_category_post' => ['type' => 'string', 'description' => 'Category Post'],
        'category_style_margin_tb' => ['type' => 'object', 'description' => 'Top/Bottom Spacing'],
        'category_style_margin_lr' => ['type' => 'object', 'description' => 'Left/Right Spacing'],
        'category_inner_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'category_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'category_hover_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'category_2_border_hover_color' => ['type' => 'string', 'description' => 'Hover Border Color (Color Hex/RGBA)'],
        'category_border' => ['type' => 'string', 'description' => 'Border', 'enum' => ['yes', 'no']],
        'category_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['category_border', 'display_post_category', 'post_category_style', '{{WRAPPER}} .blog-list .post-inner-loop .post-category-list span a']],
        'box_category_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'category_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'category_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'category_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'category_border_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        's_title_pg' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'title_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'title_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'title_hover_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'title_boxhover_color' => ['type' => 'string', 'description' => 'Title Color (Color Hex/RGBA)'],
        's_excerpt_content_pg' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'excerpt_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'excerpt_color' => ['type' => 'string', 'description' => 'Content Color (Color Hex/RGBA)'],
        'excerpt_hover_color' => ['type' => 'string', 'description' => 'Content Color (Color Hex/RGBA)'],
        'blog_featured_image_width' => ['type' => 'object', 'description' => 'Image width (Slider/Size Object)'],
        'blog_featured_image_height' => ['type' => 'object', 'description' => 'Image Height'],
        'hover_image_style' => ['type' => 'string', 'description' => 'Image Hover Effect'],
        'featured_image_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'tpae_enable_overlay' => ['type' => 'string', 'description' => 'Enable Overlay', 'enum' => ['yes', 'no']],
        'tpae_overlay_color' => ['type' => 'string', 'description' => 'Overlay Color (Color Hex/RGBA)'],
        'section_filter_category_styling_options' => ['type' => 'string', 'description' => 'section_filter_category_styling_options'],
        'button_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'btn_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'icon_fill_color' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'button_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['button_style', 'dashed', 'dotted', 'groove', 'none', 'solid', '{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap']],
        'button_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'button_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'button_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'btn_text_hover_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'icon_fill_color_hover' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color_hover' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'button_border_hover_color' => ['type' => 'string', 'description' => 'Hover Border Color (Color Hex/RGBA)'],
        'button_hover_radius' => ['type' => 'object', 'description' => 'Hover Border Radius (Dimensions Object)'],
        'content_inner_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'box_border' => ['type' => 'string', 'description' => 'Box Border', 'enum' => ['yes', 'no']],
        'border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['box_border', '{{WRAPPER}} .blog-list .post-inner-loop .grid-item .blog-list-content,
					{{WRAPPER}} .blog-list .post-inner-loop .grid-item .tpae-compect-blog-wrap,
					{{WRAPPER}} .blog-list .post-inner-loop .grid-item .tpae-preset-blog']],
        'box_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'box_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'box_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'border_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'section_carousel_options_styling_options' => ['type' => 'string', 'description' => 'section_carousel_options_styling_options'],
        'messy_column' => ['type' => 'string', 'description' => 'Messy Columns', 'enum' => ['yes', 'no']],
        'messy_column_options' => ['type' => 'string', 'description' => 'messy_column_options'],
        'animation_effects' => ['type' => 'string', 'description' => 'Choose Animation Effect'],
        'animation_delay' => ['type' => 'object', 'description' => 'Animation Delay (Slider/Size Object)'],
        'animated_column_list' => ['type' => 'string', 'description' => 'List Load Animation', 'enum' => ['animation_effects!', 'columns', 'stagger']],
        'animation_stagger' => ['type' => 'object', 'description' => 'Animation Stagger (Slider/Size Object)'],
        'animation_duration_default' => ['type' => 'string', 'description' => 'Animation Duration', 'enum' => ['yes', 'no']],
        'animate_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'animation_out_effects' => ['type' => 'string', 'description' => 'Out Animation Effect', 'enum' => ['animation_effects!']],
        'animation_out_delay' => ['type' => 'object', 'description' => 'Out Animation Delay (Slider/Size Object)'],
        'animation_out_duration_default' => ['type' => 'string', 'description' => 'Out Animation Duration', 'enum' => ['yes', 'no']],
        'animation_out_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
            'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports multi-layout carousel physics, dynamic post-meta injection, and responsive grid geometry.']
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
    'execute_callback' => 'tpae_mcp_add_theplus_blog_listout_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_blog_listout_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

function tpae_mcp_add_theplus_blog_listout_permission(?array $input = null): bool
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

function tpae_mcp_add_theplus_blog_listout_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-blog-listout';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Blog Listing widget is not registered.', 'tpebl'));
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
    if (isset($input['style_pro_options'])) { $settings['style_pro_options'] = sanitize_text_field($input['style_pro_options']); }
    if (isset($input['layout'])) { $settings['layout'] = sanitize_text_field($input['layout']); }
    if (isset($input['layout_pro_options'])) { $settings['layout_pro_options'] = sanitize_text_field($input['layout_pro_options']); }
    if (isset($input['content_html'])) { $settings['content_html'] = sanitize_text_field($input['content_html']); }
    if (isset($input['content_css'])) { $settings['content_css'] = sanitize_text_field($input['content_css']); }
    if (isset($input['display_posts'])) { $settings['display_posts'] = sanitize_text_field($input['display_posts']); }
    if (isset($input['post_offset'])) { $settings['post_offset'] = sanitize_text_field($input['post_offset']); }
    if (isset($input['post_category'])) { $settings['post_category'] = sanitize_text_field($input['post_category']); }
    if (isset($input['post_tags'])) { $settings['post_tags'] = sanitize_text_field($input['post_tags']); }
    if (isset($input['post_order_by'])) { $settings['post_order_by'] = sanitize_text_field($input['post_order_by']); }
    if (isset($input['post_order'])) { $settings['post_order'] = sanitize_text_field($input['post_order']); }
    if (isset($input['desktop_column'])) { $settings['desktop_column'] = sanitize_text_field($input['desktop_column']); }
    if (isset($input['tablet_column'])) { $settings['tablet_column'] = sanitize_text_field($input['tablet_column']); }
    if (isset($input['mobile_column'])) { $settings['mobile_column'] = sanitize_text_field($input['mobile_column']); }
    if (isset($input['metro_column'])) { $settings['metro_column'] = sanitize_text_field($input['metro_column']); }
    if (isset($input['metro_style_3'])) { $settings['metro_style_3'] = sanitize_text_field($input['metro_style_3']); }
    if (isset($input['plus_pro_metro_column_options'])) { $settings['plus_pro_metro_column_options'] = sanitize_text_field($input['plus_pro_metro_column_options']); }
    if (isset($input['columns_gap'])) { $settings['columns_gap'] = $input['columns_gap']; }
    if (isset($input['post_extra_option'])) { $settings['post_extra_option'] = sanitize_text_field($input['post_extra_option']); }
    if (isset($input['post_extra_pro_options'])) { $settings['post_extra_pro_options'] = sanitize_text_field($input['post_extra_pro_options']); }
    if (isset($input['load_more_btn_text'])) { $settings['load_more_btn_text'] = sanitize_text_field($input['load_more_btn_text']); }
    if (isset($input['tp_loading_text'])) { $settings['tp_loading_text'] = sanitize_text_field($input['tp_loading_text']); }
    if (isset($input['loaded_posts_text'])) { $settings['loaded_posts_text'] = sanitize_text_field($input['loaded_posts_text']); }
    if (isset($input['load_more_post'])) { $settings['load_more_post'] = sanitize_text_field($input['load_more_post']); }
    if (isset($input['load_more_border'])) { $settings['load_more_border'] = sanitize_text_field($input['load_more_border']); }
    if (isset($input['load_more_border_style'])) { $settings['load_more_border_style'] = sanitize_text_field($input['load_more_border_style']); }
    if (isset($input['load_more_border_width'])) { $settings['load_more_border_width'] = $input['load_more_border_width']; }
    if (isset($input['load_more_border_color'])) { $settings['load_more_border_color'] = sanitize_text_field($input['load_more_border_color']); }
    if (isset($input['load_more_border_radius'])) { $settings['load_more_border_radius'] = $input['load_more_border_radius']; }
    if (isset($input['load_more_border_hover_color'])) { $settings['load_more_border_hover_color'] = sanitize_text_field($input['load_more_border_hover_color']); }
    if (isset($input['load_more_border_hover_radius'])) { $settings['load_more_border_hover_radius'] = $input['load_more_border_hover_radius']; }
    if (isset($input['load_more_color'])) { $settings['load_more_color'] = sanitize_text_field($input['load_more_color']); }
    if (isset($input['loaded_posts_color'])) { $settings['loaded_posts_color'] = sanitize_text_field($input['loaded_posts_color']); }
    if (isset($input['load_more_color_hover'])) { $settings['load_more_color_hover'] = sanitize_text_field($input['load_more_color_hover']); }
    if (isset($input['post_title_tag'])) { $settings['post_title_tag'] = sanitize_text_field($input['post_title_tag']); }
    if (isset($input['display_title_limit'])) { $settings['display_title_limit'] = sanitize_text_field($input['display_title_limit']); }
    if (isset($input['display_title_by'])) { $settings['display_title_by'] = sanitize_text_field($input['display_title_by']); }
    if (isset($input['display_title_input'])) { $settings['display_title_input'] = sanitize_text_field($input['display_title_input']); }
    if (isset($input['display_title_3_dots'])) { $settings['display_title_3_dots'] = sanitize_text_field($input['display_title_3_dots']); }
    if (isset($input['display_post_category'])) { $settings['display_post_category'] = sanitize_text_field($input['display_post_category']); }
    if (isset($input['post_category_style'])) { $settings['post_category_style'] = sanitize_text_field($input['post_category_style']); }
    if (isset($input['display_post_category_all'])) { $settings['display_post_category_all'] = sanitize_text_field($input['display_post_category_all']); }
    if (isset($input['display_excerpt'])) { $settings['display_excerpt'] = sanitize_text_field($input['display_excerpt']); }
    if (isset($input['post_excerpt_count'])) { $settings['post_excerpt_count'] = sanitize_text_field($input['post_excerpt_count']); }
    if (isset($input['show_post_date'])) { $settings['show_post_date'] = sanitize_text_field($input['show_post_date']); }
    if (isset($input['show_post_author'])) { $settings['show_post_author'] = sanitize_text_field($input['show_post_author']); }
    if (isset($input['show_read_time'])) { $settings['show_read_time'] = sanitize_text_field($input['show_read_time']); }
    if (isset($input['display_button'])) { $settings['display_button'] = sanitize_text_field($input['display_button']); }
    if (isset($input['button_style'])) { $settings['button_style'] = sanitize_text_field($input['button_style']); }
    if (isset($input['button_text'])) { $settings['button_text'] = sanitize_text_field($input['button_text']); }
    if (isset($input['button_icon_style'])) { $settings['button_icon_style'] = sanitize_text_field($input['button_icon_style']); }
    if (isset($input['button_icon'])) { $settings['button_icon'] = sanitize_text_field($input['button_icon']); }
    if (isset($input['before_after'])) { $settings['before_after'] = sanitize_text_field($input['before_after']); }
    if (isset($input['icon_spacing'])) { $settings['icon_spacing'] = $input['icon_spacing']; }
    if (isset($input['display_thumbnail'])) { $settings['display_thumbnail'] = sanitize_text_field($input['display_thumbnail']); }
    if (isset($input['display_thumbnail_options'])) { $settings['display_thumbnail_options'] = sanitize_text_field($input['display_thumbnail_options']); }
    if (isset($input['display_post_meta'])) { $settings['display_post_meta'] = sanitize_text_field($input['display_post_meta']); }
    if (isset($input['post_meta_tag_style'])) { $settings['post_meta_tag_style'] = sanitize_text_field($input['post_meta_tag_style']); }
    if (isset($input['author_prefix'])) { $settings['author_prefix'] = sanitize_text_field($input['author_prefix']); }
    if (isset($input['filter_category'])) { $settings['filter_category'] = sanitize_text_field($input['filter_category']); }
    if (isset($input['filter_category_options'])) { $settings['filter_category_options'] = sanitize_text_field($input['filter_category_options']); }
    if (isset($input['tpae_theme_builder'])) { $settings['tpae_theme_builder'] = sanitize_text_field($input['tpae_theme_builder']); }
    if (isset($input['post_meta_color'])) { $settings['post_meta_color'] = sanitize_text_field($input['post_meta_color']); }
    if (isset($input['post_meta_color_hover'])) { $settings['post_meta_color_hover'] = sanitize_text_field($input['post_meta_color_hover']); }
    if (isset($input['blog_card_layout'])) { $settings['blog_card_layout'] = sanitize_text_field($input['blog_card_layout']); }
    if (isset($input['wrap_flex_direction'])) { $settings['wrap_flex_direction'] = $input['wrap_flex_direction']; }
    if (isset($input['tp_row_one_width'])) { $settings['tp_row_one_width'] = $input['tp_row_one_width']; }
    if (isset($input['tp_row_two_width'])) { $settings['tp_row_two_width'] = $input['tp_row_two_width']; }
    if (isset($input['tp_content_alignment'])) { $settings['tp_content_alignment'] = $input['tp_content_alignment']; }
    if (isset($input['tp_item_content_alignment'])) { $settings['tp_item_content_alignment'] = $input['tp_item_content_alignment']; }
    if (isset($input['wrap_gap'])) { $settings['wrap_gap'] = $input['wrap_gap']; }
    if (isset($input['tp_absolute_layout'])) { $settings['tp_absolute_layout'] = sanitize_text_field($input['tp_absolute_layout']); }
    if (isset($input['tp_top_card'])) { $settings['tp_top_card'] = $input['tp_top_card']; }
    if (isset($input['tp_bottom_card'])) { $settings['tp_bottom_card'] = $input['tp_bottom_card']; }
    if (isset($input['tp_width_card'])) { $settings['tp_width_card'] = $input['tp_width_card']; }
    if (isset($input['content_direction'])) { $settings['content_direction'] = $input['content_direction']; }
    if (isset($input['content_vertical_justify'])) { $settings['content_vertical_justify'] = $input['content_vertical_justify']; }
    if (isset($input['blog_content_padding'])) { $settings['blog_content_padding'] = $input['blog_content_padding']; }
    if (isset($input['blog_content_margin'])) { $settings['blog_content_margin'] = $input['blog_content_margin']; }
    if (isset($input['blog_border_post'])) { $settings['blog_border_post'] = sanitize_text_field($input['blog_border_post']); }
    if (isset($input['blog_content_border_radius'])) { $settings['blog_content_border_radius'] = $input['blog_content_border_radius']; }
    if (isset($input['blog_meta_layout_post'])) { $settings['blog_meta_layout_post'] = sanitize_text_field($input['blog_meta_layout_post']); }
    if (isset($input['meta_flex_direction'])) { $settings['meta_flex_direction'] = sanitize_text_field($input['meta_flex_direction']); }
    if (isset($input['meta_align_items'])) { $settings['meta_align_items'] = $input['meta_align_items']; }
    if (isset($input['meta_gap'])) { $settings['meta_gap'] = $input['meta_gap']; }
    if (isset($input['tp_meta_inner_padding'])) { $settings['tp_meta_inner_padding'] = $input['tp_meta_inner_padding']; }
    if (isset($input['tp_meta_border_r'])) { $settings['tp_meta_border_r'] = $input['tp_meta_border_r']; }
    if (isset($input['date_overflow'])) { $settings['date_overflow'] = sanitize_text_field($input['date_overflow']); }
    if (isset($input['category_date_inner_padding'])) { $settings['category_date_inner_padding'] = $input['category_date_inner_padding']; }
    if (isset($input['date_style_margin_tb'])) { $settings['date_style_margin_tb'] = $input['date_style_margin_tb']; }
    if (isset($input['date_style_margin_lr'])) { $settings['date_style_margin_lr'] = $input['date_style_margin_lr']; }
    if (isset($input['overflow_date_br'])) { $settings['overflow_date_br'] = $input['overflow_date_br']; }
    if (isset($input['meta_overflow'])) { $settings['meta_overflow'] = sanitize_text_field($input['meta_overflow']); }
    if (isset($input['category_meta_inner_padding'])) { $settings['category_meta_inner_padding'] = $input['category_meta_inner_padding']; }
    if (isset($input['meta_style_margin_tb'])) { $settings['meta_style_margin_tb'] = $input['meta_style_margin_tb']; }
    if (isset($input['meta_style_margin_lr'])) { $settings['meta_style_margin_lr'] = $input['meta_style_margin_lr']; }
    if (isset($input['overflow_meta_br'])) { $settings['overflow_meta_br'] = $input['overflow_meta_br']; }
    if (isset($input['post_tima_overflow'])) { $settings['post_tima_overflow'] = sanitize_text_field($input['post_tima_overflow']); }
    if (isset($input['category_post_time_inner_padding'])) { $settings['category_post_time_inner_padding'] = $input['category_post_time_inner_padding']; }
    if (isset($input['post_style_margin_tb'])) { $settings['post_style_margin_tb'] = $input['post_style_margin_tb']; }
    if (isset($input['post_style_margin_lr'])) { $settings['post_style_margin_lr'] = $input['post_style_margin_lr']; }
    if (isset($input['overflow_post_time_br'])) { $settings['overflow_post_time_br'] = $input['overflow_post_time_br']; }
    if (isset($input['button_overflow'])) { $settings['button_overflow'] = sanitize_text_field($input['button_overflow']); }
    if (isset($input['button_style_margin_tb'])) { $settings['button_style_margin_tb'] = $input['button_style_margin_tb']; }
    if (isset($input['button_style_margin_lr'])) { $settings['button_style_margin_lr'] = $input['button_style_margin_lr']; }
    if (isset($input['blog_category_post'])) { $settings['blog_category_post'] = sanitize_text_field($input['blog_category_post']); }
    if (isset($input['category_style_margin_tb'])) { $settings['category_style_margin_tb'] = $input['category_style_margin_tb']; }
    if (isset($input['category_style_margin_lr'])) { $settings['category_style_margin_lr'] = $input['category_style_margin_lr']; }
    if (isset($input['category_inner_padding'])) { $settings['category_inner_padding'] = $input['category_inner_padding']; }
    if (isset($input['category_color'])) { $settings['category_color'] = sanitize_text_field($input['category_color']); }
    if (isset($input['category_hover_color'])) { $settings['category_hover_color'] = sanitize_text_field($input['category_hover_color']); }
    if (isset($input['category_2_border_hover_color'])) { $settings['category_2_border_hover_color'] = sanitize_text_field($input['category_2_border_hover_color']); }
    if (isset($input['category_border'])) { $settings['category_border'] = sanitize_text_field($input['category_border']); }
    if (isset($input['category_border_style'])) { $settings['category_border_style'] = sanitize_text_field($input['category_border_style']); }
    if (isset($input['box_category_border_width'])) { $settings['box_category_border_width'] = $input['box_category_border_width']; }
    if (isset($input['category_border_color'])) { $settings['category_border_color'] = sanitize_text_field($input['category_border_color']); }
    if (isset($input['category_border_radius'])) { $settings['category_border_radius'] = $input['category_border_radius']; }
    if (isset($input['category_border_hover_color'])) { $settings['category_border_hover_color'] = sanitize_text_field($input['category_border_hover_color']); }
    if (isset($input['category_border_hover_radius'])) { $settings['category_border_hover_radius'] = $input['category_border_hover_radius']; }
    if (isset($input['s_title_pg'])) { $settings['s_title_pg'] = $input['s_title_pg']; }
    if (isset($input['title_margin'])) { $settings['title_margin'] = $input['title_margin']; }
    if (isset($input['title_color'])) { $settings['title_color'] = sanitize_text_field($input['title_color']); }
    if (isset($input['title_hover_color'])) { $settings['title_hover_color'] = sanitize_text_field($input['title_hover_color']); }
    if (isset($input['title_boxhover_color'])) { $settings['title_boxhover_color'] = sanitize_text_field($input['title_boxhover_color']); }
    if (isset($input['s_excerpt_content_pg'])) { $settings['s_excerpt_content_pg'] = $input['s_excerpt_content_pg']; }
    if (isset($input['excerpt_margin'])) { $settings['excerpt_margin'] = $input['excerpt_margin']; }
    if (isset($input['excerpt_color'])) { $settings['excerpt_color'] = sanitize_text_field($input['excerpt_color']); }
    if (isset($input['excerpt_hover_color'])) { $settings['excerpt_hover_color'] = sanitize_text_field($input['excerpt_hover_color']); }
    if (isset($input['blog_featured_image_width'])) { $settings['blog_featured_image_width'] = $input['blog_featured_image_width']; }
    if (isset($input['blog_featured_image_height'])) { $settings['blog_featured_image_height'] = $input['blog_featured_image_height']; }
    if (isset($input['hover_image_style'])) { $settings['hover_image_style'] = sanitize_text_field($input['hover_image_style']); }
    if (isset($input['featured_image_radius'])) { $settings['featured_image_radius'] = $input['featured_image_radius']; }
    if (isset($input['tpae_enable_overlay'])) { $settings['tpae_enable_overlay'] = sanitize_text_field($input['tpae_enable_overlay']); }
    if (isset($input['tpae_overlay_color'])) { $settings['tpae_overlay_color'] = sanitize_text_field($input['tpae_overlay_color']); }
    if (isset($input['section_filter_category_styling_options'])) { $settings['section_filter_category_styling_options'] = sanitize_text_field($input['section_filter_category_styling_options']); }
    if (isset($input['button_padding'])) { $settings['button_padding'] = $input['button_padding']; }
    if (isset($input['btn_text_color'])) { $settings['btn_text_color'] = sanitize_text_field($input['btn_text_color']); }
    if (isset($input['icon_fill_color'])) { $settings['icon_fill_color'] = sanitize_text_field($input['icon_fill_color']); }
    if (isset($input['icon_stroke_color'])) { $settings['icon_stroke_color'] = sanitize_text_field($input['icon_stroke_color']); }
    if (isset($input['button_border_style'])) { $settings['button_border_style'] = sanitize_text_field($input['button_border_style']); }
    if (isset($input['button_border_width'])) { $settings['button_border_width'] = $input['button_border_width']; }
    if (isset($input['button_border_color'])) { $settings['button_border_color'] = sanitize_text_field($input['button_border_color']); }
    if (isset($input['button_radius'])) { $settings['button_radius'] = $input['button_radius']; }
    if (isset($input['btn_text_hover_color'])) { $settings['btn_text_hover_color'] = sanitize_text_field($input['btn_text_hover_color']); }
    if (isset($input['icon_fill_color_hover'])) { $settings['icon_fill_color_hover'] = sanitize_text_field($input['icon_fill_color_hover']); }
    if (isset($input['icon_stroke_color_hover'])) { $settings['icon_stroke_color_hover'] = sanitize_text_field($input['icon_stroke_color_hover']); }
    if (isset($input['button_border_hover_color'])) { $settings['button_border_hover_color'] = sanitize_text_field($input['button_border_hover_color']); }
    if (isset($input['button_hover_radius'])) { $settings['button_hover_radius'] = $input['button_hover_radius']; }
    if (isset($input['content_inner_padding'])) { $settings['content_inner_padding'] = $input['content_inner_padding']; }
    if (isset($input['box_border'])) { $settings['box_border'] = sanitize_text_field($input['box_border']); }
    if (isset($input['border_style'])) { $settings['border_style'] = sanitize_text_field($input['border_style']); }
    if (isset($input['box_border_width'])) { $settings['box_border_width'] = $input['box_border_width']; }
    if (isset($input['box_border_color'])) { $settings['box_border_color'] = sanitize_text_field($input['box_border_color']); }
    if (isset($input['border_radius'])) { $settings['border_radius'] = $input['border_radius']; }
    if (isset($input['box_border_hover_color'])) { $settings['box_border_hover_color'] = sanitize_text_field($input['box_border_hover_color']); }
    if (isset($input['border_hover_radius'])) { $settings['border_hover_radius'] = $input['border_hover_radius']; }
    if (isset($input['section_carousel_options_styling_options'])) { $settings['section_carousel_options_styling_options'] = sanitize_text_field($input['section_carousel_options_styling_options']); }
    if (isset($input['messy_column'])) { $settings['messy_column'] = sanitize_text_field($input['messy_column']); }
    if (isset($input['messy_column_options'])) { $settings['messy_column_options'] = sanitize_text_field($input['messy_column_options']); }
    if (isset($input['animation_effects'])) { $settings['animation_effects'] = sanitize_text_field($input['animation_effects']); }
    if (isset($input['animation_delay'])) { $settings['animation_delay'] = $input['animation_delay']; }
    if (isset($input['animated_column_list'])) { $settings['animated_column_list'] = sanitize_text_field($input['animated_column_list']); }
    if (isset($input['animation_stagger'])) { $settings['animation_stagger'] = $input['animation_stagger']; }
    if (isset($input['animation_duration_default'])) { $settings['animation_duration_default'] = sanitize_text_field($input['animation_duration_default']); }
    if (isset($input['animate_duration'])) { $settings['animate_duration'] = $input['animate_duration']; }
    if (isset($input['animation_out_effects'])) { $settings['animation_out_effects'] = sanitize_text_field($input['animation_out_effects']); }
    if (isset($input['animation_out_delay'])) { $settings['animation_out_delay'] = $input['animation_out_delay']; }
    if (isset($input['animation_out_duration_default'])) { $settings['animation_out_duration_default'] = sanitize_text_field($input['animation_out_duration_default']); }
    if (isset($input['animation_out_duration'])) { $settings['animation_out_duration'] = $input['animation_out_duration']; }

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
