<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-gallery-listout', [
    'label' => __('Gallery', 'tpebl'),
    'description' => __('Adds the The Plus "Gallery" widget (tp-gallery-listout) to an Elementor container.', 'tpebl'),
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
        'style' => ['type' => 'string', 'description' => 'Style', 'enum' => ['columns', 'style-1', 'style-2', 'style-3', 'style-4']],
        'style_pro_options' => ['type' => 'string', 'description' => 'style_pro_options'],
        'layout' => ['type' => 'string', 'description' => 'Layout', 'enum' => ['carousel', 'columns', 'grid', 'masonry', 'metro']],
        'layout_pro' => ['type' => 'string', 'description' => 'layout_pro'],
        'popup_style' => ['type' => 'string', 'description' => 'Popup Layout'],
        'gallery_options' => ['type' => 'string', 'description' => 'Select Option', 'enum' => ['acf_gallery', 'normal', 'repeater']],
        'gallery_images' => ['type' => 'string', 'description' => 'Add Images'],
        'loop_gallery_options' => ['type' => 'string', 'description' => 'loop_gallery_options'],
        'desktop_column' => ['type' => 'string', 'description' => 'Desktop Column', 'enum' => ['layout!']],
        'tablet_column' => ['type' => 'string', 'description' => 'Tablet Column', 'enum' => ['layout!']],
        'mobile_column' => ['type' => 'string', 'description' => 'Mobile Column', 'enum' => ['layout!']],
        'metro_column' => ['type' => 'string', 'description' => 'Metro Column', 'enum' => ['3', '4', '5', '6', 'layout']],
        'metro_style_3' => ['type' => 'string', 'description' => 'Metro Style', 'enum' => ['layout', 'metro_column']],
        'columns_gap' => ['type' => 'object', 'description' => 'Columns Gap/Space Between (Dimensions Object)'],
        'display_title' => ['type' => 'string', 'description' => 'Display Title', 'enum' => ['yes', 'no']],
        'post_title_tag' => ['type' => 'string', 'description' => 'Title Tag', 'enum' => ['display_title']],
        'display_excerpt' => ['type' => 'string', 'description' => 'Display Excerpt/Content', 'enum' => ['yes', 'no']],
        'display_box_link' => ['type' => 'string', 'description' => 'display_box_link', 'enum' => ['yes', 'no']],
        'display_box_link_options' => ['type' => 'string', 'description' => 'display_box_link_options'],
        'filter_category' => ['type' => 'string', 'description' => 'filter_category', 'enum' => ['yes', 'no']],
        'filter_category_options' => ['type' => 'string', 'description' => 'filter_category_options'],
        'display_icon_zoom' => ['type' => 'string', 'description' => 'Display Icon', 'enum' => ['yes', 'no']],
        'custom_icon_image' => ['type' => 'integer', 'description' => 'Custom Icon (Image ID)'],
        'icon_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'icon_bottom_space' => ['type' => 'object', 'description' => 'Bottom Space (Slider/Size Object)'],
        'icon_color' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'icon_hover_color' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'section_repeat_icon_style_options' => ['type' => 'string', 'description' => 'section_repeat_icon_style_options'],
        'title_color' => ['type' => 'string', 'description' => 'Title Color (Color Hex/RGBA)'],
        'title_hover_color' => ['type' => 'string', 'description' => 'Title Color (Color Hex/RGBA)'],
        'content_top_space' => ['type' => 'object', 'description' => 'Top Space (Slider/Size Object)'],
        'excerpt_color' => ['type' => 'string', 'description' => 'Content Color (Color Hex/RGBA)'],
        'excerpt_hover_color' => ['type' => 'string', 'description' => 'Content Color (Color Hex/RGBA)'],
        'hover_image_style' => ['type' => 'string', 'description' => 'Image Hover Effect'],
        'image_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'hover_image_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'section_filter_category_styling_options' => ['type' => 'string', 'description' => 'section_filter_category_styling_options'],
        'box_border' => ['type' => 'string', 'description' => 'Box Border', 'enum' => ['yes', 'no']],
        'border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['box_border', '{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content']],
        'box_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'box_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'box_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'border_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'section_carousel_options_styling_options' => ['type' => 'string', 'description' => 'section_carousel_options_styling_options'],
        'plus_tilt_parallax' => ['type' => 'string', 'description' => 'plus_tilt_parallax', 'enum' => ['yes', 'no']],
        'plus_tilt_parallax_options' => ['type' => 'string', 'description' => 'plus_tilt_parallax_options'],
        'plus_mouse_move_parallax' => ['type' => 'string', 'description' => 'plus_mouse_move_parallax', 'enum' => ['yes', 'no']],
        'plus_mouse_move_parallax_options' => ['type' => 'string', 'description' => 'plus_mouse_move_parallax_options'],
        'messy_column' => ['type' => 'string', 'description' => 'messy_column', 'enum' => ['yes', 'no']],
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
            'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports dynamic CPT filtering, mixed-aspect masonry physics, and AJAX infinite-scroll logic.']
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
    'execute_callback' => 'tpae_mcp_add_theplus_gallery_listout_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_gallery_listout_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

function tpae_mcp_add_theplus_gallery_listout_permission(?array $input = null): bool
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

function tpae_mcp_add_theplus_gallery_listout_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-gallery-listout';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Gallery widget is not registered.', 'tpebl'));
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
    if (isset($input['layout_pro'])) { $settings['layout_pro'] = sanitize_text_field($input['layout_pro']); }
    if (isset($input['popup_style'])) { $settings['popup_style'] = sanitize_text_field($input['popup_style']); }
    if (isset($input['gallery_options'])) { $settings['gallery_options'] = sanitize_text_field($input['gallery_options']); }
    if (isset($input['gallery_images'])) { $settings['gallery_images'] = sanitize_text_field($input['gallery_images']); }
    if (isset($input['loop_gallery_options'])) { $settings['loop_gallery_options'] = sanitize_text_field($input['loop_gallery_options']); }
    if (isset($input['desktop_column'])) { $settings['desktop_column'] = sanitize_text_field($input['desktop_column']); }
    if (isset($input['tablet_column'])) { $settings['tablet_column'] = sanitize_text_field($input['tablet_column']); }
    if (isset($input['mobile_column'])) { $settings['mobile_column'] = sanitize_text_field($input['mobile_column']); }
    if (isset($input['metro_column'])) { $settings['metro_column'] = sanitize_text_field($input['metro_column']); }
    if (isset($input['metro_style_3'])) { $settings['metro_style_3'] = sanitize_text_field($input['metro_style_3']); }
    if (isset($input['columns_gap'])) { $settings['columns_gap'] = $input['columns_gap']; }
    if (isset($input['display_title'])) { $settings['display_title'] = sanitize_text_field($input['display_title']); }
    if (isset($input['post_title_tag'])) { $settings['post_title_tag'] = sanitize_text_field($input['post_title_tag']); }
    if (isset($input['display_excerpt'])) { $settings['display_excerpt'] = sanitize_text_field($input['display_excerpt']); }
    if (isset($input['display_box_link'])) { $settings['display_box_link'] = sanitize_text_field($input['display_box_link']); }
    if (isset($input['display_box_link_options'])) { $settings['display_box_link_options'] = sanitize_text_field($input['display_box_link_options']); }
    if (isset($input['filter_category'])) { $settings['filter_category'] = sanitize_text_field($input['filter_category']); }
    if (isset($input['filter_category_options'])) { $settings['filter_category_options'] = sanitize_text_field($input['filter_category_options']); }
    if (isset($input['display_icon_zoom'])) { $settings['display_icon_zoom'] = sanitize_text_field($input['display_icon_zoom']); }
    if (!empty($input['custom_icon_image'])) { $settings['custom_icon_image'] = ['id' => absint($input['custom_icon_image'])]; }
    if (isset($input['icon_size'])) { $settings['icon_size'] = $input['icon_size']; }
    if (isset($input['icon_bottom_space'])) { $settings['icon_bottom_space'] = $input['icon_bottom_space']; }
    if (isset($input['icon_color'])) { $settings['icon_color'] = sanitize_text_field($input['icon_color']); }
    if (isset($input['icon_hover_color'])) { $settings['icon_hover_color'] = sanitize_text_field($input['icon_hover_color']); }
    if (isset($input['section_repeat_icon_style_options'])) { $settings['section_repeat_icon_style_options'] = sanitize_text_field($input['section_repeat_icon_style_options']); }
    if (isset($input['title_color'])) { $settings['title_color'] = sanitize_text_field($input['title_color']); }
    if (isset($input['title_hover_color'])) { $settings['title_hover_color'] = sanitize_text_field($input['title_hover_color']); }
    if (isset($input['content_top_space'])) { $settings['content_top_space'] = $input['content_top_space']; }
    if (isset($input['excerpt_color'])) { $settings['excerpt_color'] = sanitize_text_field($input['excerpt_color']); }
    if (isset($input['excerpt_hover_color'])) { $settings['excerpt_hover_color'] = sanitize_text_field($input['excerpt_hover_color']); }
    if (isset($input['hover_image_style'])) { $settings['hover_image_style'] = sanitize_text_field($input['hover_image_style']); }
    if (isset($input['image_border_radius'])) { $settings['image_border_radius'] = $input['image_border_radius']; }
    if (isset($input['hover_image_border_radius'])) { $settings['hover_image_border_radius'] = $input['hover_image_border_radius']; }
    if (isset($input['section_filter_category_styling_options'])) { $settings['section_filter_category_styling_options'] = sanitize_text_field($input['section_filter_category_styling_options']); }
    if (isset($input['box_border'])) { $settings['box_border'] = sanitize_text_field($input['box_border']); }
    if (isset($input['border_style'])) { $settings['border_style'] = sanitize_text_field($input['border_style']); }
    if (isset($input['box_border_width'])) { $settings['box_border_width'] = $input['box_border_width']; }
    if (isset($input['box_border_color'])) { $settings['box_border_color'] = sanitize_text_field($input['box_border_color']); }
    if (isset($input['border_radius'])) { $settings['border_radius'] = $input['border_radius']; }
    if (isset($input['box_border_hover_color'])) { $settings['box_border_hover_color'] = sanitize_text_field($input['box_border_hover_color']); }
    if (isset($input['border_hover_radius'])) { $settings['border_hover_radius'] = $input['border_hover_radius']; }
    if (isset($input['section_carousel_options_styling_options'])) { $settings['section_carousel_options_styling_options'] = sanitize_text_field($input['section_carousel_options_styling_options']); }
    if (isset($input['plus_tilt_parallax'])) { $settings['plus_tilt_parallax'] = sanitize_text_field($input['plus_tilt_parallax']); }
    if (isset($input['plus_tilt_parallax_options'])) { $settings['plus_tilt_parallax_options'] = sanitize_text_field($input['plus_tilt_parallax_options']); }
    if (isset($input['plus_mouse_move_parallax'])) { $settings['plus_mouse_move_parallax'] = sanitize_text_field($input['plus_mouse_move_parallax']); }
    if (isset($input['plus_mouse_move_parallax_options'])) { $settings['plus_mouse_move_parallax_options'] = sanitize_text_field($input['plus_mouse_move_parallax_options']); }
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
