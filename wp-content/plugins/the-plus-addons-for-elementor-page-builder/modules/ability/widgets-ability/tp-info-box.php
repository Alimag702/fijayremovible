<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-info-box', [
    'label' => __('Info Box', 'tpebl'),
    'description' => __('Adds the The Plus "Info Box" widget (tp-info-box) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'info_box_layout' => ['type' => 'string', 'description' => 'Select Layout', 'enum' => ['carousel_layout', 'single_layout']],
        'main_style' => ['type' => 'string', 'description' => 'Info Box Style', 'enum' => ['info_box_layout', 'style_1', 'style_11', 'style_2', 'style_3', 'style_4', 'style_7']],
        'loop_select_icon_options' => ['type' => 'string', 'description' => 'loop_select_icon_options'],
        'main_style_pro_options' => ['type' => 'string', 'description' => 'main_style_pro_options'],
        'connection_switch' => ['type' => 'string', 'description' => 'Carousel Anything Connection', 'enum' => ['yes', 'no']],
        'connection_switch_options' => ['type' => 'string', 'description' => 'connection_switch_options'],
        'title' => ['type' => 'string', 'description' => 'Title Of Info Box'],
        'content_desc' => ['type' => 'string', 'description' => 'Description'],
        'text_align' => ['type' => 'object', 'description' => 'Info Box Alignment', 'enum' => ['center', 'icon', 'left', 'main_style', 'right', 'toggle', '{{WRAPPER}} .pt_plus_info_box.info-box-style_3 .info-box-bg-box .service-center', '{{WRAPPER}} .pt_plus_info_box.info-box-style_3 .info-box-bg-box .service-center .service-border']],
        'url_link' => ['type' => 'object', 'description' => 'Link'],
        'image_icon' => ['type' => 'string', 'description' => 'Select Icon', 'enum' => ['icon', 'info_box_layout', 'main_style', 'svg', 'text']],
        'tp_info_title' => ['type' => 'string', 'description' => 'Title'],
        'svg_icon_options' => ['type' => 'string', 'description' => 'svg_icon_options'],
        'select_image' => ['type' => 'integer', 'description' => 'Use Image As icon (Image ID)'],
        'icon_font_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['font_awesome', 'font_awesome_5', 'icon_image', 'icon_mind', 'image_icon', 'info_box_layout', 'main_style']],
        'icon_fontawesome' => ['type' => 'string', 'description' => 'Icon Library'],
        'icon_fontawesome_5' => ['type' => 'string', 'description' => 'Icon Library'],
        'icons_image_pro_options' => ['type' => 'string', 'description' => 'icons_image_pro_options'],
        'display_button' => ['type' => 'string', 'description' => 'Button', 'enum' => ['yes', 'no']],
        'button_type_switch' => ['type' => 'string', 'description' => 'Button Type', 'enum' => ['basic', 'display_button', 'icon', 'info_box_layout', 'main_style', 'toggle']],
        'button_global_style_preset' => ['type' => 'string', 'description' => 'Global Style', 'enum' => ['button_type_switch', 'display_button', 'info_box_layout', 'main_style']],
        'button_style' => ['type' => 'string', 'description' => 'Button Style', 'enum' => ['button_type_switch', 'display_button', 'info_box_layout', 'main_style', 'style-7', 'style-8', 'style-9']],
        'button_style_options' => ['type' => 'string', 'description' => 'button_style_options'],
        'button_text' => ['type' => 'string', 'description' => 'Button Text'],
        'button_link' => ['type' => 'object', 'description' => 'Button Link'],
        'button_icon_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['button_style!', 'display_button', 'font_awesome', 'font_awesome_5', 'icon_mind', 'info_box_layout', 'main_style']],
        'button_icon' => ['type' => 'string', 'description' => 'Icon'],
        'button_icon_5' => ['type' => 'string', 'description' => 'Icon Library'],
        'button_icons_mind_options' => ['type' => 'string', 'description' => 'button_icons_mind_options'],
        'before_after' => ['type' => 'string', 'description' => 'Icon Position', 'enum' => ['after', 'before', 'button_icon_style!', 'button_style!', 'display_button', 'info_box_layout', 'main_style']],
        'icon_spacing' => ['type' => 'object', 'description' => 'Icon Spacing (Slider/Size Object)'],
        'hover_info_button' => ['type' => 'string', 'description' => 'Hover Button InfoBox', 'enum' => ['yes', 'no']],
        'display_pin_text' => ['type' => 'string', 'description' => 'Display Pin Text', 'enum' => ['yes', 'no']],
        'display_pin_text_options' => ['type' => 'string', 'description' => 'display_pin_text_options'],
        'title_tag' => ['type' => 'string', 'description' => 'Title Tag', 'enum' => ['info_box_layout', 'main_style']],
        'full_infobox_switch' => ['type' => 'string', 'description' => 'Full Infobox Link', 'enum' => ['yes', 'no']],
        'full_infobox_switch_options' => ['type' => 'string', 'description' => 'full_infobox_switch_options'],
        'title_top_space' => ['type' => 'object', 'description' => 'Title Top Space (Slider/Size Object)'],
        'title_btm_space' => ['type' => 'object', 'description' => 'Title Bottom Space (Slider/Size Object)'],
        'title_color_option' => ['type' => 'string', 'description' => 'Title Color', 'enum' => ['gradient', 'icon', 'solid']],
        'title_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'title_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'title_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'title_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'title_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'title_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['of_type', 'title_color_option']],
        'title_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'title_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['of_type', 'title_color_option', 'title_gradient_style', '{{WRAPPER}} .pt_plus_info_box .info-box-inner .service-title']],
        'title_hover_color_option' => ['type' => 'string', 'description' => 'Title Hover Color', 'enum' => ['gradient', 'icon', 'solid']],
        'title_hover_color' => ['type' => 'string', 'description' => 'Hover Color (Color Hex/RGBA)'],
        'title_hover_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'title_hover_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'title_hover_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'title_hover_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'title_hover_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['of_type', 'title_hover_color_option']],
        'title_hover_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'title_hover_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['of_type', 'title_hover_color_option', 'title_hover_gradient_style', '{{WRAPPER}} .pt_plus_info_box .info-box-inner:hover .service-title,{{WRAPPER}} .pt_plus_info_box .info-box-inner.tp-info-active .service-title']],
        'border_check' => ['type' => 'string', 'description' => 'Display Border', 'enum' => ['yes', 'no']],
        'border_width' => ['type' => 'object', 'description' => 'Border Width (Slider/Size Object)'],
        'border_height' => ['type' => 'object', 'description' => 'Border Height (Slider/Size Object)'],
        'title_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'desc_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'desc_color' => ['type' => 'string', 'description' => 'Desc Color (Color Hex/RGBA)'],
        'desc_hover_color' => ['type' => 'string', 'description' => 'Desc Hover Color (Color Hex/RGBA)'],
        'box_border' => ['type' => 'string', 'description' => 'Box Border', 'enum' => ['yes', 'no']],
        'box_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['box_border', 'main_style', '{{WRAPPER}} .pt_plus_info_box .info-box-inner .info-box-bg-box']],
        'box_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'box_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'box_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'border_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'border_check_right' => ['type' => 'string', 'description' => 'Side image Border', 'enum' => ['yes', 'no']],
        'border_right_color' => ['type' => 'string', 'description' => 'Border Right Color (Color Hex/RGBA)'],
        'bg_hover_animation' => ['type' => 'string', 'description' => 'Background Hover Animation', 'enum' => ['hover_fadein', 'hover_normal', 'hover_slide_bottom', 'hover_slide_left', 'hover_slide_right', 'hover_slide_top']],
        'bg_hover_animation_pro' => ['type' => 'string', 'description' => 'bg_hover_animation_pro'],
        'button_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'button_top_space' => ['type' => 'object', 'description' => 'Button Above Space (Slider/Size Object)'],
        'button_icon_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'btn_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'button_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['button_style', 'dashed', 'dotted', 'groove', 'none', 'solid', '{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap']],
        'button_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'button_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'button_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'btn_text_hover_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'button_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'button_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'section_svg_styling_options' => ['type' => 'string', 'description' => 'section_svg_styling_options'],
        'icon_style' => ['type' => 'string', 'description' => 'Icon Styles', 'enum' => ['hexagon', 'pentagon', 'rounded', 'square', 'square-rotate']],
        'icon_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'icon_width' => ['type' => 'object', 'description' => 'Icon Width (Slider/Size Object)'],
        'icon_color_option' => ['type' => 'string', 'description' => 'Icon Color', 'enum' => ['gradient', 'icon', 'solid']],
        'icon_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'icon_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'icon_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'icon_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'icon_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'icon_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['icon_color_option', 'of_type']],
        'icon_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'icon_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['icon_color_option', 'icon_gradient_style', 'of_type', '{{WRAPPER}} .pt_plus_info_box .info-box-inner .service-icon:before,
					{{WRAPPER}} .pt_plus_info_box .info-box-inner .service-icon i:before']],
        'icon_fill_color' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'icon_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'icon_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'icon_hover_color_option' => ['type' => 'string', 'description' => 'Icon Color', 'enum' => ['gradient', 'icon', 'solid']],
        'icon_hover_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'icon_hover_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'icon_hover_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'icon_hover_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'icon_hover_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'icon_hover_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['icon_hover_color_option', 'of_type']],
        'icon_hover_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'icon_hover_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['icon_hover_color_option', 'icon_hover_gradient_style', 'of_type', '{{WRAPPER}} .pt_plus_info_box .info-box-inner:hover .service-icon:before,{{WRAPPER}} .pt_plus_info_box .info-box-inner.tp-info-active .service-icon:before,{{WRAPPER}} .pt_plus_info_box .info-box-inner:hover .service-icon i:before,{{WRAPPER}} .pt_plus_info_box .info-box-inner.tp-info-active .service-icon i:before']],
        'icon_fill_color_hover' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color_hover' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'icon_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'icon__hover_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'icon_overlay' => ['type' => 'string', 'description' => 'Icon Overlay', 'enum' => ['yes', 'no']],
        'icon_overlay_options' => ['type' => 'string', 'description' => 'icon_overlay_options'],
        'icon_shine_effect' => ['type' => 'string', 'description' => 'Icon Shine Effect', 'enum' => ['yes', 'no']],
        'icon_shine_effect_options' => ['type' => 'string', 'description' => 'icon_shine_effect_options'],
        'img_max_width' => ['type' => 'object', 'description' => 'Max Width (Slider/Size Object)'],
        'image_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'image_hover_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'section_pin_text_styling_options' => ['type' => 'string', 'description' => 'section_pin_text_styling_options'],
        'section_carousel_options_styling_options' => ['type' => 'string', 'description' => 'section_carousel_options_styling_options'],
        'service_text_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'tab_text_color_n' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'service_text_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'tab_text_color_h' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'service_text_border_radius_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'box_padding' => ['type' => 'object', 'description' => 'Box Padding (Dimensions Object)'],
        'vertical_center' => ['type' => 'string', 'description' => 'Vertical Center', 'enum' => ['yes', 'no']],
        'tilt_parallax' => ['type' => 'string', 'description' => 'Tilt 3D Parallax', 'enum' => ['yes', 'no']],
        'Parallax_options' => ['type' => 'string', 'description' => 'Parallax_options'],
        'messy_column' => ['type' => 'string', 'description' => 'Messy Columns', 'enum' => ['yes', 'no']],
        'messy_column_options' => ['type' => 'string', 'description' => 'messy_column_options'],
        'min_height_section' => ['type' => 'string', 'description' => 'Minimum Height Section', 'enum' => ['yes', 'no']],
        'minimum_height' => ['type' => 'object', 'description' => 'Minimum Height (Slider/Size Object)'],
        'box_hover_effects' => ['type' => 'string', 'description' => 'Box Hover Effects'],
        'box_hover_effects_pro' => ['type' => 'string', 'description' => 'box_hover_effects_pro'],
        'responsive_visible_opt' => ['type' => 'string', 'description' => 'Responsive Visibility', 'enum' => ['yes', 'no']],
        'desktop_opt' => ['type' => 'string', 'description' => 'Desktop', 'enum' => ['yes', 'no']],
        'tablet_opt' => ['type' => 'string', 'description' => 'Tablet', 'enum' => ['yes', 'no']],
        'mobile_opt' => ['type' => 'string', 'description' => 'Mobile', 'enum' => ['yes', 'no']],
        'animation_effects' => ['type' => 'string', 'description' => 'Choose Animation Effect'],
        'animation_delay' => ['type' => 'object', 'description' => 'Animation Delay (Slider/Size Object)'],
        'animation_duration_default' => ['type' => 'string', 'description' => 'Animation Duration', 'enum' => ['yes', 'no']],
        'animate_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'animation_out_effects' => ['type' => 'string', 'description' => 'Out Animation Effect', 'enum' => ['animation_effects!']],
        'animation_out_delay' => ['type' => 'object', 'description' => 'Out Animation Delay (Slider/Size Object)'],
        'animation_out_duration_default' => ['type' => 'string', 'description' => 'Out Animation Duration', 'enum' => ['yes', 'no']],
        'animation_out_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports SVG stroke typography, background clipping typography, and animated underline physics.']
        ],
        'required' => ['post_id', 'parent_id', 'title'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_info_box_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_info_box_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_info_box_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_info_box_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-info-box';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Info Box widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['info_box_layout'])) { $settings['info_box_layout'] = sanitize_text_field($input['info_box_layout']); }
    if (isset($input['main_style'])) { $settings['main_style'] = sanitize_text_field($input['main_style']); }
    if (isset($input['loop_select_icon_options'])) { $settings['loop_select_icon_options'] = sanitize_text_field($input['loop_select_icon_options']); }
    if (isset($input['main_style_pro_options'])) { $settings['main_style_pro_options'] = sanitize_text_field($input['main_style_pro_options']); }
    if (isset($input['connection_switch'])) { $settings['connection_switch'] = sanitize_text_field($input['connection_switch']); }
    if (isset($input['connection_switch_options'])) { $settings['connection_switch_options'] = sanitize_text_field($input['connection_switch_options']); }
    if (isset($input['title'])) { $settings['title'] = sanitize_text_field($input['title']); }
    if (isset($input['content_desc'])) { $settings['content_desc'] = sanitize_text_field($input['content_desc']); }
    if (isset($input['text_align'])) { $settings['text_align'] = $input['text_align']; }
    if (isset($input['url_link'])) { $settings['url_link'] = $input['url_link']; }
    if (isset($input['image_icon'])) { $settings['image_icon'] = sanitize_text_field($input['image_icon']); }
    if (isset($input['tp_info_title'])) { $settings['tp_info_title'] = sanitize_text_field($input['tp_info_title']); }
    if (isset($input['svg_icon_options'])) { $settings['svg_icon_options'] = sanitize_text_field($input['svg_icon_options']); }
    if (!empty($input['select_image'])) { $settings['select_image'] = ['id' => absint($input['select_image'])]; }
    if (isset($input['icon_font_style'])) { $settings['icon_font_style'] = sanitize_text_field($input['icon_font_style']); }
    if (isset($input['icon_fontawesome'])) { $settings['icon_fontawesome'] = sanitize_text_field($input['icon_fontawesome']); }
    if (isset($input['icon_fontawesome_5'])) { $settings['icon_fontawesome_5'] = sanitize_text_field($input['icon_fontawesome_5']); }
    if (isset($input['icons_image_pro_options'])) { $settings['icons_image_pro_options'] = sanitize_text_field($input['icons_image_pro_options']); }
    if (isset($input['display_button'])) { $settings['display_button'] = sanitize_text_field($input['display_button']); }
    if (isset($input['button_type_switch'])) { $settings['button_type_switch'] = sanitize_text_field($input['button_type_switch']); }
    if (isset($input['button_global_style_preset'])) { $settings['button_global_style_preset'] = sanitize_text_field($input['button_global_style_preset']); }
    if (isset($input['button_style'])) { $settings['button_style'] = sanitize_text_field($input['button_style']); }
    if (isset($input['button_style_options'])) { $settings['button_style_options'] = sanitize_text_field($input['button_style_options']); }
    if (isset($input['button_text'])) { $settings['button_text'] = sanitize_text_field($input['button_text']); }
    if (isset($input['button_link'])) { $settings['button_link'] = $input['button_link']; }
    if (isset($input['button_icon_style'])) { $settings['button_icon_style'] = sanitize_text_field($input['button_icon_style']); }
    if (isset($input['button_icon'])) { $settings['button_icon'] = sanitize_text_field($input['button_icon']); }
    if (isset($input['button_icon_5'])) { $settings['button_icon_5'] = sanitize_text_field($input['button_icon_5']); }
    if (isset($input['button_icons_mind_options'])) { $settings['button_icons_mind_options'] = sanitize_text_field($input['button_icons_mind_options']); }
    if (isset($input['before_after'])) { $settings['before_after'] = sanitize_text_field($input['before_after']); }
    if (isset($input['icon_spacing'])) { $settings['icon_spacing'] = $input['icon_spacing']; }
    if (isset($input['hover_info_button'])) { $settings['hover_info_button'] = sanitize_text_field($input['hover_info_button']); }
    if (isset($input['display_pin_text'])) { $settings['display_pin_text'] = sanitize_text_field($input['display_pin_text']); }
    if (isset($input['display_pin_text_options'])) { $settings['display_pin_text_options'] = sanitize_text_field($input['display_pin_text_options']); }
    if (isset($input['title_tag'])) { $settings['title_tag'] = sanitize_text_field($input['title_tag']); }
    if (isset($input['full_infobox_switch'])) { $settings['full_infobox_switch'] = sanitize_text_field($input['full_infobox_switch']); }
    if (isset($input['full_infobox_switch_options'])) { $settings['full_infobox_switch_options'] = sanitize_text_field($input['full_infobox_switch_options']); }
    if (isset($input['title_top_space'])) { $settings['title_top_space'] = $input['title_top_space']; }
    if (isset($input['title_btm_space'])) { $settings['title_btm_space'] = $input['title_btm_space']; }
    if (isset($input['title_color_option'])) { $settings['title_color_option'] = sanitize_text_field($input['title_color_option']); }
    if (isset($input['title_color'])) { $settings['title_color'] = sanitize_text_field($input['title_color']); }
    if (isset($input['title_gradient_color1'])) { $settings['title_gradient_color1'] = sanitize_text_field($input['title_gradient_color1']); }
    if (isset($input['title_gradient_color1_control'])) { $settings['title_gradient_color1_control'] = $input['title_gradient_color1_control']; }
    if (isset($input['title_gradient_color2'])) { $settings['title_gradient_color2'] = sanitize_text_field($input['title_gradient_color2']); }
    if (isset($input['title_gradient_color2_control'])) { $settings['title_gradient_color2_control'] = $input['title_gradient_color2_control']; }
    if (isset($input['title_gradient_style'])) { $settings['title_gradient_style'] = sanitize_text_field($input['title_gradient_style']); }
    if (isset($input['title_gradient_angle'])) { $settings['title_gradient_angle'] = $input['title_gradient_angle']; }
    if (isset($input['title_gradient_position'])) { $settings['title_gradient_position'] = sanitize_text_field($input['title_gradient_position']); }
    if (isset($input['title_hover_color_option'])) { $settings['title_hover_color_option'] = sanitize_text_field($input['title_hover_color_option']); }
    if (isset($input['title_hover_color'])) { $settings['title_hover_color'] = sanitize_text_field($input['title_hover_color']); }
    if (isset($input['title_hover_gradient_color1'])) { $settings['title_hover_gradient_color1'] = sanitize_text_field($input['title_hover_gradient_color1']); }
    if (isset($input['title_hover_gradient_color1_control'])) { $settings['title_hover_gradient_color1_control'] = $input['title_hover_gradient_color1_control']; }
    if (isset($input['title_hover_gradient_color2'])) { $settings['title_hover_gradient_color2'] = sanitize_text_field($input['title_hover_gradient_color2']); }
    if (isset($input['title_hover_gradient_color2_control'])) { $settings['title_hover_gradient_color2_control'] = $input['title_hover_gradient_color2_control']; }
    if (isset($input['title_hover_gradient_style'])) { $settings['title_hover_gradient_style'] = sanitize_text_field($input['title_hover_gradient_style']); }
    if (isset($input['title_hover_gradient_angle'])) { $settings['title_hover_gradient_angle'] = $input['title_hover_gradient_angle']; }
    if (isset($input['title_hover_gradient_position'])) { $settings['title_hover_gradient_position'] = sanitize_text_field($input['title_hover_gradient_position']); }
    if (isset($input['border_check'])) { $settings['border_check'] = sanitize_text_field($input['border_check']); }
    if (isset($input['border_width'])) { $settings['border_width'] = $input['border_width']; }
    if (isset($input['border_height'])) { $settings['border_height'] = $input['border_height']; }
    if (isset($input['title_border_color'])) { $settings['title_border_color'] = sanitize_text_field($input['title_border_color']); }
    if (isset($input['desc_padding'])) { $settings['desc_padding'] = $input['desc_padding']; }
    if (isset($input['desc_color'])) { $settings['desc_color'] = sanitize_text_field($input['desc_color']); }
    if (isset($input['desc_hover_color'])) { $settings['desc_hover_color'] = sanitize_text_field($input['desc_hover_color']); }
    if (isset($input['box_border'])) { $settings['box_border'] = sanitize_text_field($input['box_border']); }
    if (isset($input['box_border_style'])) { $settings['box_border_style'] = sanitize_text_field($input['box_border_style']); }
    if (isset($input['box_border_color'])) { $settings['box_border_color'] = sanitize_text_field($input['box_border_color']); }
    if (isset($input['box_border_width'])) { $settings['box_border_width'] = $input['box_border_width']; }
    if (isset($input['border_radius'])) { $settings['border_radius'] = $input['border_radius']; }
    if (isset($input['box_border_hover_color'])) { $settings['box_border_hover_color'] = sanitize_text_field($input['box_border_hover_color']); }
    if (isset($input['border_hover_radius'])) { $settings['border_hover_radius'] = $input['border_hover_radius']; }
    if (isset($input['border_check_right'])) { $settings['border_check_right'] = sanitize_text_field($input['border_check_right']); }
    if (isset($input['border_right_color'])) { $settings['border_right_color'] = sanitize_text_field($input['border_right_color']); }
    if (isset($input['bg_hover_animation'])) { $settings['bg_hover_animation'] = sanitize_text_field($input['bg_hover_animation']); }
    if (isset($input['bg_hover_animation_pro'])) { $settings['bg_hover_animation_pro'] = sanitize_text_field($input['bg_hover_animation_pro']); }
    if (isset($input['button_padding'])) { $settings['button_padding'] = $input['button_padding']; }
    if (isset($input['button_top_space'])) { $settings['button_top_space'] = $input['button_top_space']; }
    if (isset($input['button_icon_size'])) { $settings['button_icon_size'] = $input['button_icon_size']; }
    if (isset($input['btn_text_color'])) { $settings['btn_text_color'] = sanitize_text_field($input['btn_text_color']); }
    if (isset($input['button_border_style'])) { $settings['button_border_style'] = sanitize_text_field($input['button_border_style']); }
    if (isset($input['button_border_width'])) { $settings['button_border_width'] = $input['button_border_width']; }
    if (isset($input['button_border_color'])) { $settings['button_border_color'] = sanitize_text_field($input['button_border_color']); }
    if (isset($input['button_radius'])) { $settings['button_radius'] = $input['button_radius']; }
    if (isset($input['btn_text_hover_color'])) { $settings['btn_text_hover_color'] = sanitize_text_field($input['btn_text_hover_color']); }
    if (isset($input['button_border_hover_color'])) { $settings['button_border_hover_color'] = sanitize_text_field($input['button_border_hover_color']); }
    if (isset($input['button_hover_radius'])) { $settings['button_hover_radius'] = $input['button_hover_radius']; }
    if (isset($input['section_svg_styling_options'])) { $settings['section_svg_styling_options'] = sanitize_text_field($input['section_svg_styling_options']); }
    if (isset($input['icon_style'])) { $settings['icon_style'] = sanitize_text_field($input['icon_style']); }
    if (isset($input['icon_size'])) { $settings['icon_size'] = $input['icon_size']; }
    if (isset($input['icon_width'])) { $settings['icon_width'] = $input['icon_width']; }
    if (isset($input['icon_color_option'])) { $settings['icon_color_option'] = sanitize_text_field($input['icon_color_option']); }
    if (isset($input['icon_color'])) { $settings['icon_color'] = sanitize_text_field($input['icon_color']); }
    if (isset($input['icon_gradient_color1'])) { $settings['icon_gradient_color1'] = sanitize_text_field($input['icon_gradient_color1']); }
    if (isset($input['icon_gradient_color1_control'])) { $settings['icon_gradient_color1_control'] = $input['icon_gradient_color1_control']; }
    if (isset($input['icon_gradient_color2'])) { $settings['icon_gradient_color2'] = sanitize_text_field($input['icon_gradient_color2']); }
    if (isset($input['icon_gradient_color2_control'])) { $settings['icon_gradient_color2_control'] = $input['icon_gradient_color2_control']; }
    if (isset($input['icon_gradient_style'])) { $settings['icon_gradient_style'] = sanitize_text_field($input['icon_gradient_style']); }
    if (isset($input['icon_gradient_angle'])) { $settings['icon_gradient_angle'] = $input['icon_gradient_angle']; }
    if (isset($input['icon_gradient_position'])) { $settings['icon_gradient_position'] = sanitize_text_field($input['icon_gradient_position']); }
    if (isset($input['icon_fill_color'])) { $settings['icon_fill_color'] = sanitize_text_field($input['icon_fill_color']); }
    if (isset($input['icon_stroke_color'])) { $settings['icon_stroke_color'] = sanitize_text_field($input['icon_stroke_color']); }
    if (isset($input['icon_border_color'])) { $settings['icon_border_color'] = sanitize_text_field($input['icon_border_color']); }
    if (isset($input['icon_border_radius'])) { $settings['icon_border_radius'] = $input['icon_border_radius']; }
    if (isset($input['icon_hover_color_option'])) { $settings['icon_hover_color_option'] = sanitize_text_field($input['icon_hover_color_option']); }
    if (isset($input['icon_hover_color'])) { $settings['icon_hover_color'] = sanitize_text_field($input['icon_hover_color']); }
    if (isset($input['icon_hover_gradient_color1'])) { $settings['icon_hover_gradient_color1'] = sanitize_text_field($input['icon_hover_gradient_color1']); }
    if (isset($input['icon_hover_gradient_color1_control'])) { $settings['icon_hover_gradient_color1_control'] = $input['icon_hover_gradient_color1_control']; }
    if (isset($input['icon_hover_gradient_color2'])) { $settings['icon_hover_gradient_color2'] = sanitize_text_field($input['icon_hover_gradient_color2']); }
    if (isset($input['icon_hover_gradient_color2_control'])) { $settings['icon_hover_gradient_color2_control'] = $input['icon_hover_gradient_color2_control']; }
    if (isset($input['icon_hover_gradient_style'])) { $settings['icon_hover_gradient_style'] = sanitize_text_field($input['icon_hover_gradient_style']); }
    if (isset($input['icon_hover_gradient_angle'])) { $settings['icon_hover_gradient_angle'] = $input['icon_hover_gradient_angle']; }
    if (isset($input['icon_hover_gradient_position'])) { $settings['icon_hover_gradient_position'] = sanitize_text_field($input['icon_hover_gradient_position']); }
    if (isset($input['icon_fill_color_hover'])) { $settings['icon_fill_color_hover'] = sanitize_text_field($input['icon_fill_color_hover']); }
    if (isset($input['icon_stroke_color_hover'])) { $settings['icon_stroke_color_hover'] = sanitize_text_field($input['icon_stroke_color_hover']); }
    if (isset($input['icon_border_hover_color'])) { $settings['icon_border_hover_color'] = sanitize_text_field($input['icon_border_hover_color']); }
    if (isset($input['icon__hover_border_radius'])) { $settings['icon__hover_border_radius'] = $input['icon__hover_border_radius']; }
    if (isset($input['icon_overlay'])) { $settings['icon_overlay'] = sanitize_text_field($input['icon_overlay']); }
    if (isset($input['icon_overlay_options'])) { $settings['icon_overlay_options'] = sanitize_text_field($input['icon_overlay_options']); }
    if (isset($input['icon_shine_effect'])) { $settings['icon_shine_effect'] = sanitize_text_field($input['icon_shine_effect']); }
    if (isset($input['icon_shine_effect_options'])) { $settings['icon_shine_effect_options'] = sanitize_text_field($input['icon_shine_effect_options']); }
    if (isset($input['img_max_width'])) { $settings['img_max_width'] = $input['img_max_width']; }
    if (isset($input['image_border_radius'])) { $settings['image_border_radius'] = $input['image_border_radius']; }
    if (isset($input['image_hover_border_radius'])) { $settings['image_hover_border_radius'] = $input['image_hover_border_radius']; }
    if (isset($input['section_pin_text_styling_options'])) { $settings['section_pin_text_styling_options'] = sanitize_text_field($input['section_pin_text_styling_options']); }
    if (isset($input['section_carousel_options_styling_options'])) { $settings['section_carousel_options_styling_options'] = sanitize_text_field($input['section_carousel_options_styling_options']); }
    if (isset($input['service_text_padding'])) { $settings['service_text_padding'] = $input['service_text_padding']; }
    if (isset($input['tab_text_color_n'])) { $settings['tab_text_color_n'] = sanitize_text_field($input['tab_text_color_n']); }
    if (isset($input['service_text_border_radius'])) { $settings['service_text_border_radius'] = $input['service_text_border_radius']; }
    if (isset($input['tab_text_color_h'])) { $settings['tab_text_color_h'] = sanitize_text_field($input['tab_text_color_h']); }
    if (isset($input['service_text_border_radius_h'])) { $settings['service_text_border_radius_h'] = $input['service_text_border_radius_h']; }
    if (isset($input['box_padding'])) { $settings['box_padding'] = $input['box_padding']; }
    if (isset($input['vertical_center'])) { $settings['vertical_center'] = sanitize_text_field($input['vertical_center']); }
    if (isset($input['tilt_parallax'])) { $settings['tilt_parallax'] = sanitize_text_field($input['tilt_parallax']); }
    if (isset($input['Parallax_options'])) { $settings['Parallax_options'] = sanitize_text_field($input['Parallax_options']); }
    if (isset($input['messy_column'])) { $settings['messy_column'] = sanitize_text_field($input['messy_column']); }
    if (isset($input['messy_column_options'])) { $settings['messy_column_options'] = sanitize_text_field($input['messy_column_options']); }
    if (isset($input['min_height_section'])) { $settings['min_height_section'] = sanitize_text_field($input['min_height_section']); }
    if (isset($input['minimum_height'])) { $settings['minimum_height'] = $input['minimum_height']; }
    if (isset($input['box_hover_effects'])) { $settings['box_hover_effects'] = sanitize_text_field($input['box_hover_effects']); }
    if (isset($input['box_hover_effects_pro'])) { $settings['box_hover_effects_pro'] = sanitize_text_field($input['box_hover_effects_pro']); }
    if (isset($input['responsive_visible_opt'])) { $settings['responsive_visible_opt'] = sanitize_text_field($input['responsive_visible_opt']); }
    if (isset($input['desktop_opt'])) { $settings['desktop_opt'] = sanitize_text_field($input['desktop_opt']); }
    if (isset($input['tablet_opt'])) { $settings['tablet_opt'] = sanitize_text_field($input['tablet_opt']); }
    if (isset($input['mobile_opt'])) { $settings['mobile_opt'] = sanitize_text_field($input['mobile_opt']); }
    if (isset($input['animation_effects'])) { $settings['animation_effects'] = sanitize_text_field($input['animation_effects']); }
    if (isset($input['animation_delay'])) { $settings['animation_delay'] = $input['animation_delay']; }
    if (isset($input['animation_duration_default'])) { $settings['animation_duration_default'] = sanitize_text_field($input['animation_duration_default']); }
    if (isset($input['animate_duration'])) { $settings['animate_duration'] = $input['animate_duration']; }
    if (isset($input['animation_out_effects'])) { $settings['animation_out_effects'] = sanitize_text_field($input['animation_out_effects']); }
    if (isset($input['animation_out_delay'])) { $settings['animation_out_delay'] = $input['animation_out_delay']; }
    if (isset($input['animation_out_duration_default'])) { $settings['animation_out_duration_default'] = sanitize_text_field($input['animation_out_duration_default']); }
    if (isset($input['animation_out_duration'])) { $settings['animation_out_duration'] = $input['animation_out_duration']; }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
