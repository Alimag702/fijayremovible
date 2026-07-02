<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

wp_register_ability('tpae/tpae-carousel-anything', [
    'label' => __('Carousel Anything', 'tpebl'),
    'description' => __('Adds the The Plus "Carousel Anything" widget (tp-carousel-anything) to an Elementor container.', 'tpebl'),
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
        'tab_title' => ['type' => 'string', 'description' => 'Title'],
        'content_template_type' => ['type' => 'string', 'description' => 'Content Type', 'enum' => ['dropdown', 'manually']],
        'content_template' => ['type' => 'string', 'description' => 'content_template', 'enum' => ['content_template_type']],
        'content_template_id' => ['type' => 'string', 'description' => 'Enter Elementor Template Shortcode'],
        'carousel_content' => ['type' => 'array', 'items' => ['type' => 'object'], 'description' => 'carousel_content'],
        'slide_random_order' => ['type' => 'string', 'description' => 'slide_random_order', 'enum' => ['yes', 'no']],
        'tab_content_options' => ['type' => 'string', 'description' => 'tab_content_options'],
        'slide_overflow_hidden' => ['type' => 'string', 'description' => 'Overflow Hidden', 'enum' => ['yes', 'no']],
        'carousel_unique_id' => ['type' => 'string', 'description' => 'Unique Carousel ID'],
        'slider_direction' => ['type' => 'string', 'description' => 'Slider Mode', 'enum' => ['horizontal', 'vertical']],
        'vertical_direction' => ['type' => 'string', 'description' => 'vertical_direction'],
        'carousel_direction' => ['type' => 'string', 'description' => 'Slide Direction', 'enum' => ['ltr', 'rtl']],
        'slide_speed' => ['type' => 'object', 'description' => 'Slide Speed (Slider/Size Object)'],
        'slide_fade_inout' => ['type' => 'string', 'description' => 'Slide Animation', 'enum' => ['fadeinout', 'none', 'slider_direction']],
        'slider_animation' => ['type' => 'string', 'description' => 'Animation Type', 'enum' => ['ease', 'linear']],
        'Slider_animation_effect' => ['type' => 'string', 'description' => 'Slider_animation_effect'],
        'slider_desktop_column' => ['type' => 'string', 'description' => 'slider_desktop_column', 'enum' => ['1']],
        'steps_slide' => ['type' => 'string', 'description' => 'Next Previous', 'enum' => ['1', '2']],
        'slider_padding' => ['type' => 'object', 'description' => 'Slide Padding (Dimensions Object)'],
        'slider_draggable' => ['type' => 'string', 'description' => 'Draggable', 'enum' => ['yes', 'no']],
        'multi_drag' => ['type' => 'string', 'description' => 'Multi Drag', 'enum' => ['yes', 'no']],
        'slider_infinite' => ['type' => 'string', 'description' => 'slider_infinite', 'enum' => ['yes', 'no']],
        'infinite_mode_options' => ['type' => 'string', 'description' => 'infinite_mode_options'],
        'slider_pause_hover' => ['type' => 'string', 'description' => 'slider_pause_hover', 'enum' => ['yes', 'no']],
        'pause_hover_option' => ['type' => 'string', 'description' => 'pause_hover_option'],
        'slider_adaptive_height' => ['type' => 'string', 'description' => 'Adaptive Height', 'enum' => ['yes', 'no']],
        'slider_autoplay' => ['type' => 'string', 'description' => 'slider_autoplay', 'enum' => ['yes', 'no']],
        'autoplay_options' => ['type' => 'string', 'description' => 'autoplay_options'],
        'slider_dots' => ['type' => 'string', 'description' => 'slider_dots', 'enum' => ['yes', 'no']],
        'slider_dots_style' => ['type' => 'string', 'description' => 'Dots Style', 'enum' => ['slider_dots', 'style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6', 'style-7']],
        'dot_style' => ['type' => 'string', 'description' => 'dot_style'],
        'slick_dots_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        'dots_border_color' => ['type' => 'string', 'description' => 'Dots Border Color (Color Hex/RGBA)'],
        'dots_top_padding' => ['type' => 'object', 'description' => 'Dots Top Padding (Slider/Size Object)'],
        'overlay_content_dots' => ['type' => 'string', 'description' => 'Overlay Content Dots', 'enum' => ['yes', 'no']],
        'direction_dots' => ['type' => 'string', 'description' => 'direction_dots', 'enum' => ['yes', 'no']],
        'direction_dots_option' => ['type' => 'string', 'description' => 'direction_dots_option'],
        'hover_show_dots' => ['type' => 'string', 'description' => 'hover_show_dots', 'enum' => ['yes', 'no']],
        'hover_dots_option' => ['type' => 'string', 'description' => 'hover_dots_option'],
        'slider_arrows' => ['type' => 'string', 'description' => 'slider_arrows', 'enum' => ['yes', 'no']],
        'slider_arrows_style' => ['type' => 'string', 'description' => 'Arrows Style', 'enum' => ['slider_arrows', 'style-1', 'style-2', 'style-3', 'style-4', 'style-5', 'style-6']],
        'arrow_style' => ['type' => 'string', 'description' => 'arrow_style'],
        'arrow_bg_color' => ['type' => 'string', 'description' => 'Arrow Background Color (Color Hex/RGBA)'],
        'arrow_icon_color' => ['type' => 'string', 'description' => 'Arrow Icon Color (Color Hex/RGBA)'],
        'arrow_hover_bg_color' => ['type' => 'string', 'description' => 'Arrow Hover Background Color (Color Hex/RGBA)'],
        'arrow_hover_icon_color' => ['type' => 'string', 'description' => 'Arrow Hover Icon Color (Color Hex/RGBA)'],
        'outer_section_arrow' => ['type' => 'string', 'description' => 'outer_section_arrow', 'enum' => ['yes', 'no']],
        'outer_content_arrow' => ['type' => 'string', 'description' => 'outer_content_arrow'],
        'hover_show_arrow' => ['type' => 'string', 'description' => 'hover_show_arrow', 'enum' => ['yes', 'no']],
        'show_arrow_style' => ['type' => 'string', 'description' => 'show_arrow_style'],
        'slider_center_mode' => ['type' => 'string', 'description' => 'slider_center_mode', 'enum' => ['yes', 'no']],
        'center_mode_effect' => ['type' => 'string', 'description' => 'center_mode_effect'],
        'slide_row_top_space' => ['type' => 'object', 'description' => 'Row Top Space (Slider/Size Object)'],
        'tab_carousel_tablet_options' => ['type' => 'string', 'description' => 'tab_carousel_tablet_options'],
        'tab_carousel_mobile_options' => ['type' => 'string', 'description' => 'tab_carousel_mobile_options'],
            'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports multi-source template injection, kinetic autoplay orchestration, and responsive hardware-accelerated physics.']
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
    'execute_callback' => 'tpae_mcp_add_theplus_carousel_anything_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_carousel_anything_permission',
    'meta' => [
        'show_in_rest' => true,
        'mcp' => ['public' => true, 'type' => 'tool'],
    ],
]);

function tpae_mcp_add_theplus_carousel_anything_permission(?array $input = null): bool
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

function tpae_mcp_add_theplus_carousel_anything_ability(array $input)
{
    if (!tpae_mcp_has_elementor()) {
        return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl'));
    }

    $widget_type = 'tp-carousel-anything';
    if (!tpae_mcp_has_registered_widget($widget_type)) {
        return new WP_Error('widget_missing', __('The Plus Carousel Anything widget is not registered.', 'tpebl'));
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

    if (isset($input['tab_title'])) { $settings['tab_title'] = sanitize_text_field($input['tab_title']); }
    if (isset($input['content_template_type'])) { $settings['content_template_type'] = sanitize_text_field($input['content_template_type']); }
    if (isset($input['content_template'])) { $settings['content_template'] = sanitize_text_field($input['content_template']); }
    if (isset($input['content_template_id'])) { $settings['content_template_id'] = sanitize_text_field($input['content_template_id']); }
    if (isset($input['carousel_content'])) { $settings['carousel_content'] = $input['carousel_content']; }
    if (isset($input['slide_random_order'])) { $settings['slide_random_order'] = sanitize_text_field($input['slide_random_order']); }
    if (isset($input['tab_content_options'])) { $settings['tab_content_options'] = sanitize_text_field($input['tab_content_options']); }
    if (isset($input['slide_overflow_hidden'])) { $settings['slide_overflow_hidden'] = sanitize_text_field($input['slide_overflow_hidden']); }
    if (isset($input['carousel_unique_id'])) { $settings['carousel_unique_id'] = sanitize_text_field($input['carousel_unique_id']); }
    if (isset($input['slider_direction'])) { $settings['slider_direction'] = sanitize_text_field($input['slider_direction']); }
    if (isset($input['vertical_direction'])) { $settings['vertical_direction'] = sanitize_text_field($input['vertical_direction']); }
    if (isset($input['carousel_direction'])) { $settings['carousel_direction'] = sanitize_text_field($input['carousel_direction']); }
    if (isset($input['slide_speed'])) { $settings['slide_speed'] = $input['slide_speed']; }
    if (isset($input['slide_fade_inout'])) { $settings['slide_fade_inout'] = sanitize_text_field($input['slide_fade_inout']); }
    if (isset($input['slider_animation'])) { $settings['slider_animation'] = sanitize_text_field($input['slider_animation']); }
    if (isset($input['Slider_animation_effect'])) { $settings['Slider_animation_effect'] = sanitize_text_field($input['Slider_animation_effect']); }
    if (isset($input['slider_desktop_column'])) { $settings['slider_desktop_column'] = sanitize_text_field($input['slider_desktop_column']); }
    if (isset($input['steps_slide'])) { $settings['steps_slide'] = sanitize_text_field($input['steps_slide']); }
    if (isset($input['slider_padding'])) { $settings['slider_padding'] = $input['slider_padding']; }
    if (isset($input['slider_draggable'])) { $settings['slider_draggable'] = sanitize_text_field($input['slider_draggable']); }
    if (isset($input['multi_drag'])) { $settings['multi_drag'] = sanitize_text_field($input['multi_drag']); }
    if (isset($input['slider_infinite'])) { $settings['slider_infinite'] = sanitize_text_field($input['slider_infinite']); }
    if (isset($input['infinite_mode_options'])) { $settings['infinite_mode_options'] = sanitize_text_field($input['infinite_mode_options']); }
    if (isset($input['slider_pause_hover'])) { $settings['slider_pause_hover'] = sanitize_text_field($input['slider_pause_hover']); }
    if (isset($input['pause_hover_option'])) { $settings['pause_hover_option'] = sanitize_text_field($input['pause_hover_option']); }
    if (isset($input['slider_adaptive_height'])) { $settings['slider_adaptive_height'] = sanitize_text_field($input['slider_adaptive_height']); }
    if (isset($input['slider_autoplay'])) { $settings['slider_autoplay'] = sanitize_text_field($input['slider_autoplay']); }
    if (isset($input['autoplay_options'])) { $settings['autoplay_options'] = sanitize_text_field($input['autoplay_options']); }
    if (isset($input['slider_dots'])) { $settings['slider_dots'] = sanitize_text_field($input['slider_dots']); }
    if (isset($input['slider_dots_style'])) { $settings['slider_dots_style'] = sanitize_text_field($input['slider_dots_style']); }
    if (isset($input['dot_style'])) { $settings['dot_style'] = sanitize_text_field($input['dot_style']); }
    if (isset($input['slick_dots_size'])) { $settings['slick_dots_size'] = $input['slick_dots_size']; }
    if (isset($input['dots_border_color'])) { $settings['dots_border_color'] = sanitize_text_field($input['dots_border_color']); }
    if (isset($input['dots_top_padding'])) { $settings['dots_top_padding'] = $input['dots_top_padding']; }
    if (isset($input['overlay_content_dots'])) { $settings['overlay_content_dots'] = sanitize_text_field($input['overlay_content_dots']); }
    if (isset($input['direction_dots'])) { $settings['direction_dots'] = sanitize_text_field($input['direction_dots']); }
    if (isset($input['direction_dots_option'])) { $settings['direction_dots_option'] = sanitize_text_field($input['direction_dots_option']); }
    if (isset($input['hover_show_dots'])) { $settings['hover_show_dots'] = sanitize_text_field($input['hover_show_dots']); }
    if (isset($input['hover_dots_option'])) { $settings['hover_dots_option'] = sanitize_text_field($input['hover_dots_option']); }
    if (isset($input['slider_arrows'])) { $settings['slider_arrows'] = sanitize_text_field($input['slider_arrows']); }
    if (isset($input['slider_arrows_style'])) { $settings['slider_arrows_style'] = sanitize_text_field($input['slider_arrows_style']); }
    if (isset($input['arrow_style'])) { $settings['arrow_style'] = sanitize_text_field($input['arrow_style']); }
    if (isset($input['arrow_bg_color'])) { $settings['arrow_bg_color'] = sanitize_text_field($input['arrow_bg_color']); }
    if (isset($input['arrow_icon_color'])) { $settings['arrow_icon_color'] = sanitize_text_field($input['arrow_icon_color']); }
    if (isset($input['arrow_hover_bg_color'])) { $settings['arrow_hover_bg_color'] = sanitize_text_field($input['arrow_hover_bg_color']); }
    if (isset($input['arrow_hover_icon_color'])) { $settings['arrow_hover_icon_color'] = sanitize_text_field($input['arrow_hover_icon_color']); }
    if (isset($input['outer_section_arrow'])) { $settings['outer_section_arrow'] = sanitize_text_field($input['outer_section_arrow']); }
    if (isset($input['outer_content_arrow'])) { $settings['outer_content_arrow'] = sanitize_text_field($input['outer_content_arrow']); }
    if (isset($input['hover_show_arrow'])) { $settings['hover_show_arrow'] = sanitize_text_field($input['hover_show_arrow']); }
    if (isset($input['show_arrow_style'])) { $settings['show_arrow_style'] = sanitize_text_field($input['show_arrow_style']); }
    if (isset($input['slider_center_mode'])) { $settings['slider_center_mode'] = sanitize_text_field($input['slider_center_mode']); }
    if (isset($input['center_mode_effect'])) { $settings['center_mode_effect'] = sanitize_text_field($input['center_mode_effect']); }
    if (isset($input['slide_row_top_space'])) { $settings['slide_row_top_space'] = $input['slide_row_top_space']; }
    if (isset($input['tab_carousel_tablet_options'])) { $settings['tab_carousel_tablet_options'] = sanitize_text_field($input['tab_carousel_tablet_options']); }
    if (isset($input['tab_carousel_mobile_options'])) { $settings['tab_carousel_mobile_options'] = sanitize_text_field($input['tab_carousel_mobile_options']); }

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
