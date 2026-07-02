<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-clients-listout', [
    'label' => __('Clients', 'tpebl'),
    'description' => __('Adds the The Plus "Clients" widget (tp-clients-listout) to an Elementor container.', 'tpebl'),
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
        'layout' => ['type' => 'string', 'description' => 'Layout', 'enum' => ['carousel', 'columns', 'grid', 'masonry']],
        'plus_pro_layout_options' => ['type' => 'string', 'description' => 'plus_pro_layout_options'],
        'grid_minmum_height' => ['type' => 'object', 'description' => 'Minimum Height (Slider/Size Object)'],
        'clientContentFrom' => ['type' => 'string', 'description' => 'Select Source', 'enum' => ['clcontent', 'clrepeater']],
        'clientLinkMaskLabel' => ['type' => 'string', 'description' => 'Client Name'],
        'clientlink' => ['type' => 'object', 'description' => 'Client URL'],
        'clientImage' => ['type' => 'integer', 'description' => 'Client Logo (Image ID)'],
        'clientLinkMaskList' => ['type' => 'array', 'items' => ['type' => 'object'], 'description' => 'Manage Clients'],
        'post_category' => ['type' => 'string', 'description' => 'Select Category', 'enum' => ['multiple']],
        'display_posts' => ['type' => 'string', 'description' => 'Maximum Posts Display'],
        'post_offset' => ['type' => 'string', 'description' => 'Offset Posts'],
        'post_order_by' => ['type' => 'string', 'description' => 'Order By'],
        'post_order' => ['type' => 'string', 'description' => 'Order'],
        'desktop_column' => ['type' => 'string', 'description' => 'Desktop Column', 'enum' => ['layout!']],
        'tablet_column' => ['type' => 'string', 'description' => 'Tablet Column', 'enum' => ['layout!']],
        'mobile_column' => ['type' => 'string', 'description' => 'Mobile Column', 'enum' => ['layout!']],
        'columns_gap' => ['type' => 'object', 'description' => 'Columns Gap/Space Between (Dimensions Object)'],
        'post_title_tag' => ['type' => 'string', 'description' => 'Title Tag'],
        'display_post_title' => ['type' => 'string', 'description' => 'Display Client Title', 'enum' => ['yes', 'no']],
        'disable_link' => ['type' => 'string', 'description' => 'disable_link', 'enum' => ['yes', 'no']],
        'disable_link_options' => ['type' => 'string', 'description' => 'disable_link_options'],
        'display_thumbnail' => ['type' => 'string', 'description' => 'display_thumbnail', 'enum' => ['yes', 'no']],
        'display_thumbnail_options' => ['type' => 'string', 'description' => 'display_thumbnail_options'],
        'filter_category' => ['type' => 'string', 'description' => 'filter_category', 'enum' => ['yes', 'no']],
        'filter_category_options' => ['type' => 'string', 'description' => 'filter_category_options'],
        'post_extra_option' => ['type' => 'string', 'description' => 'post_extra_option', 'enum' => ['clientContentFrom!', 'layout!', 'lazy_load', 'load_more', 'none', 'pagination']],
        'post_extra_option_options' => ['type' => 'string', 'description' => 'post_extra_option_options'],
        'title_color' => ['type' => 'string', 'description' => 'Title Color (Color Hex/RGBA)'],
        'title_hover_color' => ['type' => 'string', 'description' => 'Title Color (Color Hex/RGBA)'],
        'section_filter_category_styling_options' => ['type' => 'string', 'description' => 'section_filter_category_styling_options'],
        'layout_style' => ['type' => 'string', 'description' => 'Layout Style', 'enum' => ['layout-style-1', 'none', 'style!']],
        'plus_pro_layout_style_options' => ['type' => 'string', 'description' => 'plus_pro_layout_style_options'],
        'content_inner_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'box_border' => ['type' => 'string', 'description' => 'Box Border', 'enum' => ['yes', 'no']],
        'border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['box_border', '{{WRAPPER}} .clients-list .post-inner-loop .grid-item .client-post-content']],
        'box_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'box_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'box_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'border_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'section_carousel_options_styling_options' => ['type' => 'string', 'description' => 'section_carousel_options_styling_options'],
        'messy_column' => ['type' => 'string', 'description' => 'messy_column', 'enum' => ['yes', 'no']],
        'messy_column_options' => ['type' => 'string', 'description' => 'messy_column_options'],
        'animation_effects' => ['type' => 'string', 'description' => 'Choose Animation Effect'],
        'animation_delay' => ['type' => 'object', 'description' => 'Animation Delay (Slider/Size Object)'],
        'animated_column_list' => ['type' => 'string', 'description' => 'List Load Animation', 'enum' => ['animation_effects!', 'stagger']],
        'animation_stagger' => ['type' => 'object', 'description' => 'Animation Stagger (Slider/Size Object)'],
        'animation_duration_default' => ['type' => 'string', 'description' => 'Animation Duration', 'enum' => ['yes', 'no']],
        'animate_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'animation_out_effects' => ['type' => 'string', 'description' => 'Out Animation Effect', 'enum' => ['animation_effects!']],
        'animation_out_delay' => ['type' => 'object', 'description' => 'Out Animation Delay (Slider/Size Object)'],
        'animation_out_duration_default' => ['type' => 'string', 'description' => 'Out Animation Duration', 'enum' => ['yes', 'no']],
        'animation_out_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
            'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports CPT integration, kinetic carousel physics, and grayscale-to-color interactive transitions.']
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
    'execute_callback' => 'tpae_mcp_add_theplus_clients_listout_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_clients_listout_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

function tpae_mcp_add_theplus_clients_listout_permission(?array $input = null): bool
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

function tpae_mcp_add_theplus_clients_listout_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-clients-listout';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Clients widget is not registered.', 'tpebl'));
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
    if (isset($input['plus_pro_layout_options'])) { $settings['plus_pro_layout_options'] = sanitize_text_field($input['plus_pro_layout_options']); }
    if (isset($input['grid_minmum_height'])) { $settings['grid_minmum_height'] = $input['grid_minmum_height']; }
    if (isset($input['clientContentFrom'])) { $settings['clientContentFrom'] = sanitize_text_field($input['clientContentFrom']); }
    if (isset($input['clientLinkMaskLabel'])) { $settings['clientLinkMaskLabel'] = sanitize_text_field($input['clientLinkMaskLabel']); }
    if (isset($input['clientlink'])) { $settings['clientlink'] = $input['clientlink']; }
    if (!empty($input['clientImage'])) { $settings['clientImage'] = ['id' => absint($input['clientImage'])]; }
    if (isset($input['clientLinkMaskList'])) { $settings['clientLinkMaskList'] = $input['clientLinkMaskList']; }
    if (isset($input['post_category'])) { $settings['post_category'] = sanitize_text_field($input['post_category']); }
    if (isset($input['display_posts'])) { $settings['display_posts'] = sanitize_text_field($input['display_posts']); }
    if (isset($input['post_offset'])) { $settings['post_offset'] = sanitize_text_field($input['post_offset']); }
    if (isset($input['post_order_by'])) { $settings['post_order_by'] = sanitize_text_field($input['post_order_by']); }
    if (isset($input['post_order'])) { $settings['post_order'] = sanitize_text_field($input['post_order']); }
    if (isset($input['desktop_column'])) { $settings['desktop_column'] = sanitize_text_field($input['desktop_column']); }
    if (isset($input['tablet_column'])) { $settings['tablet_column'] = sanitize_text_field($input['tablet_column']); }
    if (isset($input['mobile_column'])) { $settings['mobile_column'] = sanitize_text_field($input['mobile_column']); }
    if (isset($input['columns_gap'])) { $settings['columns_gap'] = $input['columns_gap']; }
    if (isset($input['post_title_tag'])) { $settings['post_title_tag'] = sanitize_text_field($input['post_title_tag']); }
    if (isset($input['display_post_title'])) { $settings['display_post_title'] = sanitize_text_field($input['display_post_title']); }
    if (isset($input['disable_link'])) { $settings['disable_link'] = sanitize_text_field($input['disable_link']); }
    if (isset($input['disable_link_options'])) { $settings['disable_link_options'] = sanitize_text_field($input['disable_link_options']); }
    if (isset($input['display_thumbnail'])) { $settings['display_thumbnail'] = sanitize_text_field($input['display_thumbnail']); }
    if (isset($input['display_thumbnail_options'])) { $settings['display_thumbnail_options'] = sanitize_text_field($input['display_thumbnail_options']); }
    if (isset($input['filter_category'])) { $settings['filter_category'] = sanitize_text_field($input['filter_category']); }
    if (isset($input['filter_category_options'])) { $settings['filter_category_options'] = sanitize_text_field($input['filter_category_options']); }
    if (isset($input['post_extra_option'])) { $settings['post_extra_option'] = sanitize_text_field($input['post_extra_option']); }
    if (isset($input['post_extra_option_options'])) { $settings['post_extra_option_options'] = sanitize_text_field($input['post_extra_option_options']); }
    if (isset($input['title_color'])) { $settings['title_color'] = sanitize_text_field($input['title_color']); }
    if (isset($input['title_hover_color'])) { $settings['title_hover_color'] = sanitize_text_field($input['title_hover_color']); }
    if (isset($input['section_filter_category_styling_options'])) { $settings['section_filter_category_styling_options'] = sanitize_text_field($input['section_filter_category_styling_options']); }
    if (isset($input['layout_style'])) { $settings['layout_style'] = sanitize_text_field($input['layout_style']); }
    if (isset($input['plus_pro_layout_style_options'])) { $settings['plus_pro_layout_style_options'] = sanitize_text_field($input['plus_pro_layout_style_options']); }
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
