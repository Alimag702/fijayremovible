<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-flip-box', [
    'label' => __('Flip Box', 'tpebl'),
    'description' => __('Adds the The Plus "Flip Box" widget (tp-flip-box) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'flipbox_type' => ['type' => 'string', 'description' => 'Type', 'enum' => ['advanced', 'basic']],
        'info_box_layout' => ['type' => 'string', 'description' => 'Select Layout', 'enum' => ['carousel_layout', 'columns', 'single_layout']],
        'plus_pro_info_box_layout_options' => ['type' => 'string', 'description' => 'plus_pro_info_box_layout_options'],
        'flip_style' => ['type' => 'string', 'description' => 'Flip Type', 'enum' => ['columns', 'horizontal', 'info_box_layout', 'vertical']],
        'flip_box_height' => ['type' => 'object', 'description' => 'Box Height (Slider/Size Object)'],
        'title' => ['type' => 'string', 'description' => 'Title'],
        'image_icon' => ['type' => 'string', 'description' => 'Select Icon', 'enum' => ['icon', 'info_box_layout', 'svg']],
        'plus_pro_image_icon_svg_options' => ['type' => 'string', 'description' => 'plus_pro_image_icon_svg_options'],
        'select_image' => ['type' => 'integer', 'description' => 'Use Image As icon (Image ID)'],
        'select_image_size' => ['type' => 'object', 'description' => 'Icon Image Max-Width (Slider/Size Object)'],
        'icon_font_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['font_awesome', 'font_awesome_5', 'icon_mind', 'image_icon', 'info_box_layout']],
        'icon_fs_popover_toggle' => ['type' => 'string', 'description' => 'Font Awesome', 'enum' => ['yes', 'no']],
        'icon_fontawesome' => ['type' => 'string', 'description' => 'Icon Library'],
        'icon_f5_popover_toggle' => ['type' => 'string', 'description' => 'Font Awesome 5', 'enum' => ['yes', 'no']],
        'icon_fontawesome_5' => ['type' => 'string', 'description' => 'Icon Library'],
        'iconmind_options' => ['type' => 'string', 'description' => 'iconmind_options'],
        'content_desc' => ['type' => 'string', 'description' => 'Description'],
        'display_button' => ['type' => 'string', 'description' => 'Button', 'enum' => ['yes', 'no']],
        'button_type_switch' => ['type' => 'string', 'description' => 'Button Type', 'enum' => ['basic', 'display_button', 'icon', 'info_box_layout', 'toggle']],
        'button_global_style_preset' => ['type' => 'string', 'description' => 'Global Style', 'enum' => ['button_type_switch', 'display_button', 'info_box_layout']],
        'button_style' => ['type' => 'string', 'description' => 'Button Style', 'enum' => ['button_type_switch', 'display_button', 'info_box_layout', 'style-7', 'style-8', 'style-9']],
        'button_pro_options' => ['type' => 'string', 'description' => 'button_pro_options'],
        'button_text' => ['type' => 'string', 'description' => 'Text'],
        'button_link' => ['type' => 'object', 'description' => 'Button Link'],
        'button_icon_font_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['button_style!', 'display_button', 'font_awesome', 'font_awesome_5', 'icon_mind', 'info_box_layout']],
        'button_icon_toggle' => ['type' => 'string', 'description' => 'Font Awesome', 'enum' => ['yes', 'no']],
        'button_icon' => ['type' => 'string', 'description' => 'Icon'],
        'button_icon_5_toggle' => ['type' => 'string', 'description' => 'Font Awesome 5', 'enum' => ['yes', 'no']],
        'button_icon_5' => ['type' => 'string', 'description' => 'Icon Library'],
        'icon_mind_options' => ['type' => 'string', 'description' => 'icon_mind_options'],
        'before_after' => ['type' => 'string', 'description' => 'Icon Position', 'enum' => ['after', 'before', 'button_icon_font_style!', 'button_style!', 'display_button', 'info_box_layout']],
        'icon_spacing' => ['type' => 'object', 'description' => 'Icon Spacing (Slider/Size Object)'],
        'section_svg_styling_options' => ['type' => 'string', 'description' => 'section_svg_styling_options'],
        'icon_style' => ['type' => 'string', 'description' => 'Icon Styles', 'enum' => ['hexagon', 'pentagon', 'rounded', 'square', 'square-rotate']],
        'icon_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'icon_width' => ['type' => 'object', 'description' => 'Icon Width (Slider/Size Object)'],
        'icon_color_option' => ['type' => 'string', 'description' => 'Icon Color', 'enum' => ['gradient', 'icon', 'solid']],
        'icon_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'icon_fill_color' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'icon_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'icon_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'icon_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'icon_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'icon_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['icon_color_option', 'of_type']],
        'icon_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'icon_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['icon_color_option', 'icon_gradient_style', 'of_type', '{{WRAPPER}} .pt_plus_info_box .info-box-inner .service-icon:before,
					{{WRAPPER}} .pt_plus_info_box .info-box-inner .service-icon i:before']],
        'icon_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'icon_hover_color_option' => ['type' => 'string', 'description' => 'Icon Hover Color', 'enum' => ['gradient', 'icon', 'solid']],
        'icon_hover_color' => ['type' => 'string', 'description' => 'Hover Color (Color Hex/RGBA)'],
        'icon_fill_color_Hover' => ['type' => 'string', 'description' => 'Hover Fill  (Color Hex/RGBA)'],
        'icon_stroke_color_hover' => ['type' => 'string', 'description' => 'Hover Stroke (Color Hex/RGBA)'],
        'icon_hover_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'icon_hover_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'icon_hover_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'icon_hover_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'icon_hover_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['icon_hover_color_option', 'of_type']],
        'icon_hover_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'icon_hover_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['icon_hover_color_option', 'icon_hover_gradient_style', 'of_type', '{{WRAPPER}} .pt_plus_info_box .info-box-inner:hover .service-icon:before,
					{{WRAPPER}} .pt_plus_info_box .info-box-inner .service-icon i:before']],
        'icon_border_hover_color' => ['type' => 'string', 'description' => 'Hover Border Color (Color Hex/RGBA)'],
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
        'title_hover_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['of_type', 'title_hover_color_option', 'title_hover_gradient_style', '{{WRAPPER}} .pt_plus_info_box .info-box-inner:hover .service-title']],
        'desc_hover_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'button_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'button_svg_icon' => ['type' => 'object', 'description' => 'Svg Icon Size (Slider/Size Object)'],
        'btn_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'button_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['conditions', 'dashed', 'dotted', 'groove', 'name', 'none', 'operator', 'relation', 'solid', 'terms', 'value', '{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap']],
        'button_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'button_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'btn_text_hover_color' => ['type' => 'string', 'description' => 'Text Hover Color (Color Hex/RGBA)'],
        'button_border_hover_color' => ['type' => 'string', 'description' => 'Hover Border Color (Color Hex/RGBA)'],
        'box_front_overlay_bg_color' => ['type' => 'string', 'description' => 'Overlay Background Color (Color Hex/RGBA)'],
        'box_back_overlay_bg_color' => ['type' => 'string', 'description' => 'Overlay Background Color (Color Hex/RGBA)'],
        'box_border' => ['type' => 'string', 'description' => 'Box Border', 'enum' => ['yes', 'no']],
        'box_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['box_border', '{{WRAPPER}} .pt_plus_info_box .info-box-inner .service-flipbox-front,{{WRAPPER}} .pt_plus_info_box .info-box-inner .service-flipbox-back']],
        'box_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'box_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'plus_pro_carousel_options_options' => ['type' => 'string', 'description' => 'plus_pro_carousel_options_options'],
        'box_padding' => ['type' => 'object', 'description' => 'Box Padding (Dimensions Object)'],
        'messy_column' => ['type' => 'string', 'description' => 'Messy Columns', 'enum' => ['yes', 'no']],
        'messy_column_even' => ['type' => 'object', 'description' => 'Even Columns (Slider/Size Object)'],
        'messy_column_odd' => ['type' => 'object', 'description' => 'Odd Columns (Slider/Size Object)'],
        'box_hover_effects' => ['type' => 'string', 'description' => 'Box Hover Effects'],
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
                'settings' => ['type' => 'object', 'description' => 'Raw Elementor/The Plus control settings to merge into the widget at creation time. Use control keys from sprout/get-theplus-widget-schema.'],
        ],
        'required' => ['post_id', 'parent_id', 'title'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_flip_box_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_flip_box_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_flip_box_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_flip_box_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-flip-box';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Flip Box widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['flipbox_type'])) { $settings['flipbox_type'] = sanitize_text_field($input['flipbox_type']); }
    if (isset($input['info_box_layout'])) { $settings['info_box_layout'] = sanitize_text_field($input['info_box_layout']); }
    if (isset($input['plus_pro_info_box_layout_options'])) { $settings['plus_pro_info_box_layout_options'] = sanitize_text_field($input['plus_pro_info_box_layout_options']); }
    if (isset($input['flip_style'])) { $settings['flip_style'] = sanitize_text_field($input['flip_style']); }
    if (isset($input['flip_box_height'])) { $settings['flip_box_height'] = $input['flip_box_height']; }
    if (isset($input['title'])) { $settings['title'] = sanitize_text_field($input['title']); }
    if (isset($input['image_icon'])) { $settings['image_icon'] = sanitize_text_field($input['image_icon']); }
    if (isset($input['plus_pro_image_icon_svg_options'])) { $settings['plus_pro_image_icon_svg_options'] = sanitize_text_field($input['plus_pro_image_icon_svg_options']); }
    if (!empty($input['select_image'])) { $settings['select_image'] = ['id' => absint($input['select_image'])]; }
    if (isset($input['select_image_size'])) { $settings['select_image_size'] = $input['select_image_size']; }
    if (isset($input['icon_font_style'])) { $settings['icon_font_style'] = sanitize_text_field($input['icon_font_style']); }
    if (isset($input['icon_fs_popover_toggle'])) { $settings['icon_fs_popover_toggle'] = sanitize_text_field($input['icon_fs_popover_toggle']); }
    if (isset($input['icon_fontawesome'])) { $settings['icon_fontawesome'] = sanitize_text_field($input['icon_fontawesome']); }
    if (isset($input['icon_f5_popover_toggle'])) { $settings['icon_f5_popover_toggle'] = sanitize_text_field($input['icon_f5_popover_toggle']); }
    if (isset($input['icon_fontawesome_5'])) { $settings['icon_fontawesome_5'] = sanitize_text_field($input['icon_fontawesome_5']); }
    if (isset($input['iconmind_options'])) { $settings['iconmind_options'] = sanitize_text_field($input['iconmind_options']); }
    if (isset($input['content_desc'])) { $settings['content_desc'] = sanitize_text_field($input['content_desc']); }
    if (isset($input['display_button'])) { $settings['display_button'] = sanitize_text_field($input['display_button']); }
    if (isset($input['button_type_switch'])) { $settings['button_type_switch'] = sanitize_text_field($input['button_type_switch']); }
    if (isset($input['button_global_style_preset'])) { $settings['button_global_style_preset'] = sanitize_text_field($input['button_global_style_preset']); }
    if (isset($input['button_style'])) { $settings['button_style'] = sanitize_text_field($input['button_style']); }
    if (isset($input['button_pro_options'])) { $settings['button_pro_options'] = sanitize_text_field($input['button_pro_options']); }
    if (isset($input['button_text'])) { $settings['button_text'] = sanitize_text_field($input['button_text']); }
    if (isset($input['button_link'])) { $settings['button_link'] = $input['button_link']; }
    if (isset($input['button_icon_font_style'])) { $settings['button_icon_font_style'] = sanitize_text_field($input['button_icon_font_style']); }
    if (isset($input['button_icon_toggle'])) { $settings['button_icon_toggle'] = sanitize_text_field($input['button_icon_toggle']); }
    if (isset($input['button_icon'])) { $settings['button_icon'] = sanitize_text_field($input['button_icon']); }
    if (isset($input['button_icon_5_toggle'])) { $settings['button_icon_5_toggle'] = sanitize_text_field($input['button_icon_5_toggle']); }
    if (isset($input['button_icon_5'])) { $settings['button_icon_5'] = sanitize_text_field($input['button_icon_5']); }
    if (isset($input['icon_mind_options'])) { $settings['icon_mind_options'] = sanitize_text_field($input['icon_mind_options']); }
    if (isset($input['before_after'])) { $settings['before_after'] = sanitize_text_field($input['before_after']); }
    if (isset($input['icon_spacing'])) { $settings['icon_spacing'] = $input['icon_spacing']; }
    if (isset($input['section_svg_styling_options'])) { $settings['section_svg_styling_options'] = sanitize_text_field($input['section_svg_styling_options']); }
    if (isset($input['icon_style'])) { $settings['icon_style'] = sanitize_text_field($input['icon_style']); }
    if (isset($input['icon_size'])) { $settings['icon_size'] = $input['icon_size']; }
    if (isset($input['icon_width'])) { $settings['icon_width'] = $input['icon_width']; }
    if (isset($input['icon_color_option'])) { $settings['icon_color_option'] = sanitize_text_field($input['icon_color_option']); }
    if (isset($input['icon_color'])) { $settings['icon_color'] = sanitize_text_field($input['icon_color']); }
    if (isset($input['icon_fill_color'])) { $settings['icon_fill_color'] = sanitize_text_field($input['icon_fill_color']); }
    if (isset($input['icon_stroke_color'])) { $settings['icon_stroke_color'] = sanitize_text_field($input['icon_stroke_color']); }
    if (isset($input['icon_gradient_color1'])) { $settings['icon_gradient_color1'] = sanitize_text_field($input['icon_gradient_color1']); }
    if (isset($input['icon_gradient_color1_control'])) { $settings['icon_gradient_color1_control'] = $input['icon_gradient_color1_control']; }
    if (isset($input['icon_gradient_color2'])) { $settings['icon_gradient_color2'] = sanitize_text_field($input['icon_gradient_color2']); }
    if (isset($input['icon_gradient_color2_control'])) { $settings['icon_gradient_color2_control'] = $input['icon_gradient_color2_control']; }
    if (isset($input['icon_gradient_style'])) { $settings['icon_gradient_style'] = sanitize_text_field($input['icon_gradient_style']); }
    if (isset($input['icon_gradient_angle'])) { $settings['icon_gradient_angle'] = $input['icon_gradient_angle']; }
    if (isset($input['icon_gradient_position'])) { $settings['icon_gradient_position'] = sanitize_text_field($input['icon_gradient_position']); }
    if (isset($input['icon_border_color'])) { $settings['icon_border_color'] = sanitize_text_field($input['icon_border_color']); }
    if (isset($input['icon_hover_color_option'])) { $settings['icon_hover_color_option'] = sanitize_text_field($input['icon_hover_color_option']); }
    if (isset($input['icon_hover_color'])) { $settings['icon_hover_color'] = sanitize_text_field($input['icon_hover_color']); }
    if (isset($input['icon_fill_color_Hover'])) { $settings['icon_fill_color_Hover'] = sanitize_text_field($input['icon_fill_color_Hover']); }
    if (isset($input['icon_stroke_color_hover'])) { $settings['icon_stroke_color_hover'] = sanitize_text_field($input['icon_stroke_color_hover']); }
    if (isset($input['icon_hover_gradient_color1'])) { $settings['icon_hover_gradient_color1'] = sanitize_text_field($input['icon_hover_gradient_color1']); }
    if (isset($input['icon_hover_gradient_color1_control'])) { $settings['icon_hover_gradient_color1_control'] = $input['icon_hover_gradient_color1_control']; }
    if (isset($input['icon_hover_gradient_color2'])) { $settings['icon_hover_gradient_color2'] = sanitize_text_field($input['icon_hover_gradient_color2']); }
    if (isset($input['icon_hover_gradient_color2_control'])) { $settings['icon_hover_gradient_color2_control'] = $input['icon_hover_gradient_color2_control']; }
    if (isset($input['icon_hover_gradient_style'])) { $settings['icon_hover_gradient_style'] = sanitize_text_field($input['icon_hover_gradient_style']); }
    if (isset($input['icon_hover_gradient_angle'])) { $settings['icon_hover_gradient_angle'] = $input['icon_hover_gradient_angle']; }
    if (isset($input['icon_hover_gradient_position'])) { $settings['icon_hover_gradient_position'] = sanitize_text_field($input['icon_hover_gradient_position']); }
    if (isset($input['icon_border_hover_color'])) { $settings['icon_border_hover_color'] = sanitize_text_field($input['icon_border_hover_color']); }
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
    if (isset($input['desc_hover_color'])) { $settings['desc_hover_color'] = sanitize_text_field($input['desc_hover_color']); }
    if (isset($input['button_padding'])) { $settings['button_padding'] = $input['button_padding']; }
    if (isset($input['button_svg_icon'])) { $settings['button_svg_icon'] = $input['button_svg_icon']; }
    if (isset($input['btn_text_color'])) { $settings['btn_text_color'] = sanitize_text_field($input['btn_text_color']); }
    if (isset($input['button_border_style'])) { $settings['button_border_style'] = sanitize_text_field($input['button_border_style']); }
    if (isset($input['button_border_width'])) { $settings['button_border_width'] = $input['button_border_width']; }
    if (isset($input['button_border_color'])) { $settings['button_border_color'] = sanitize_text_field($input['button_border_color']); }
    if (isset($input['btn_text_hover_color'])) { $settings['btn_text_hover_color'] = sanitize_text_field($input['btn_text_hover_color']); }
    if (isset($input['button_border_hover_color'])) { $settings['button_border_hover_color'] = sanitize_text_field($input['button_border_hover_color']); }
    if (isset($input['box_front_overlay_bg_color'])) { $settings['box_front_overlay_bg_color'] = sanitize_text_field($input['box_front_overlay_bg_color']); }
    if (isset($input['box_back_overlay_bg_color'])) { $settings['box_back_overlay_bg_color'] = sanitize_text_field($input['box_back_overlay_bg_color']); }
    if (isset($input['box_border'])) { $settings['box_border'] = sanitize_text_field($input['box_border']); }
    if (isset($input['box_border_style'])) { $settings['box_border_style'] = sanitize_text_field($input['box_border_style']); }
    if (isset($input['box_border_color'])) { $settings['box_border_color'] = sanitize_text_field($input['box_border_color']); }
    if (isset($input['box_border_width'])) { $settings['box_border_width'] = $input['box_border_width']; }
    if (isset($input['border_radius'])) { $settings['border_radius'] = $input['border_radius']; }
    if (isset($input['plus_pro_carousel_options_options'])) { $settings['plus_pro_carousel_options_options'] = sanitize_text_field($input['plus_pro_carousel_options_options']); }
    if (isset($input['box_padding'])) { $settings['box_padding'] = $input['box_padding']; }
    if (isset($input['messy_column'])) { $settings['messy_column'] = sanitize_text_field($input['messy_column']); }
    if (isset($input['messy_column_even'])) { $settings['messy_column_even'] = $input['messy_column_even']; }
    if (isset($input['messy_column_odd'])) { $settings['messy_column_odd'] = $input['messy_column_odd']; }
    if (isset($input['box_hover_effects'])) { $settings['box_hover_effects'] = sanitize_text_field($input['box_hover_effects']); }
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
