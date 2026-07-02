<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-breadcrumbs-bar', [
    'label' => __('Breadcrumbs Bar', 'tpebl'),
    'description' => __('Adds the The Plus "Breadcrumbs Bar" widget (tp-breadcrumbs-bar) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'breadcrumbs_style' => ['type' => 'string', 'description' => 'Breadcrumbs Style', 'enum' => ['columns', 'style_1', 'style_2']],
        'breadcrumbs_full_auto' => ['type' => 'string', 'description' => 'Breadcrumbs Full Width', 'enum' => ['yes', 'no']],
        'breadcrumbs_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'devices', 'flex-end', 'flex-start', 'icon', 'prefix_class', '{{WRAPPER}} .pt_plus_breadcrumbs_bar, {{WRAPPER}} .pt_plus_breadcrumbs_bar #breadcrumbs, {{WRAPPER}} .pt_plus_breadcrumbs_bar_inner.bred_style_1.breadcrumps-full']],
        'home_title' => ['type' => 'string', 'description' => 'Home Title'],
        'home_select_icon' => ['type' => 'string', 'description' => 'Select Icon', 'enum' => ['icon']],
        'icon_font_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['font_awesome', 'home_select_icon', 'icon_image', 'icon_mind']],
        'fontawesome_option' => ['type' => 'string', 'description' => 'Font Awesome', 'enum' => ['yes', 'no']],
        'icon_fontawesome' => ['type' => 'string', 'description' => 'Icon Library'],
        'special_effect_options' => ['type' => 'string', 'description' => 'special_effect_options'],
        'icon_img_options' => ['type' => 'string', 'description' => 'Icon Image', 'enum' => ['yes', 'no']],
        'icons_image' => ['type' => 'integer', 'description' => 'Use Image As icon (Image ID)'],
        'sep_select_icon' => ['type' => 'string', 'description' => 'Select Icon', 'enum' => ['sep_icon']],
        'sep_icon_font_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['sep_font_awesome', 'sep_icon_image', 'sep_icon_mind', 'sep_select_icon']],
        'font_awesome_option' => ['type' => 'string', 'description' => 'Font Awesome', 'enum' => ['yes', 'no']],
        'sep_icon_fontawesome' => ['type' => 'string', 'description' => 'Icon Library'],
        'sep_icon_mind_options' => ['type' => 'string', 'description' => 'sep_icon_mind_options'],
        'icon_image_options' => ['type' => 'string', 'description' => 'Icon Image', 'enum' => ['yes', 'no']],
        'sep_icons_image' => ['type' => 'integer', 'description' => 'Use Image As icon (Image ID)'],
        'section_letter_limit' => ['type' => 'string', 'description' => 'Letter Limit', 'enum' => ['yes', 'no']],
        'letter_limit_parent_switch' => ['type' => 'string', 'description' => 'Parent', 'enum' => ['yes', 'no']],
        'letter_limit_parent' => ['type' => 'string', 'description' => 'Parent'],
        'letter_limit_current_switch' => ['type' => 'string', 'description' => 'Current', 'enum' => ['yes', 'no']],
        'letter_limit_current' => ['type' => 'string', 'description' => 'Current'],
        'breadcrumbs_on_off_home' => ['type' => 'string', 'description' => 'Home', 'enum' => ['yes', 'no']],
        'breadcrumbs_on_off_parent' => ['type' => 'string', 'description' => 'Parent', 'enum' => ['yes', 'no']],
        'breadcrumbs_on_off_current' => ['type' => 'string', 'description' => 'Current', 'enum' => ['yes', 'no']],
        'tpae_theme_builder' => ['type' => 'string', 'description' => 'tpae_theme_builder'],
        'bredcrums_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'bredcrums_padding_gap' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'bred_text_color_option' => ['type' => 'string', 'description' => 'Text Color', 'enum' => ['gradient', 'icon', 'solid']],
        'text_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'text_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'text_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'text_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'text_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'text_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['breadcrumbs_style!', 'bred_text_color_option', 'of_type']],
        'text_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'text_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['breadcrumbs_style!', 'bred_text_color_option', 'of_type', 'text_gradient_style', '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs .current_tab_sec']],
        'bred_text_hover_color_option' => ['type' => 'string', 'description' => 'Text Hover Color', 'enum' => ['gradient', 'icon', 'solid']],
        'active_page_text_default' => ['type' => 'string', 'description' => 'Active Color for Page Title', 'enum' => ['yes', 'no']],
        'text_hover_color' => ['type' => 'string', 'description' => 'Hover Color (Color Hex/RGBA)'],
        'text_hover_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'text_hover_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'text_hover_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'text_hover_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'text_hover_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['breadcrumbs_style!', 'bred_text_hover_color_option', 'of_type']],
        'text_hover_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'text_hover_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['breadcrumbs_style!', 'bred_text_hover_color_option', 'of_type', 'text_hover_gradient_style', '{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs a:hover,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current:hover .current_tab_sec,{{WRAPPER}} .pt_plus_breadcrumbs_bar .pt_plus_breadcrumbs_bar_inner.bred_style_1 nav#breadcrumbs span.current_active .current_tab_sec']],
        'icon_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'icon_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        'icon_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'icon_color_hover' => ['type' => 'string', 'description' => 'Hover Color (Color Hex/RGBA)'],
        'image_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        'image_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'seprator_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'seprator_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        'breadcrumps_gap' => ['type' => 'object', 'description' => 'Spacing (Slider/Size Object)'],
        'seprator_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'seprator_color_hover' => ['type' => 'string', 'description' => 'Hover Color (Color Hex/RGBA)'],
        'seprator_image_size' => ['type' => 'object', 'description' => 'Size (Slider/Size Object)'],
        'c_bg_st1_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'content_background_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'sep_bg_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'sep_bg_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'c_bg_st2' => ['type' => 'string', 'description' => 'All (Color Hex/RGBA)'],
        'c_bg_st2_home' => ['type' => 'string', 'description' => 'Home (Color Hex/RGBA)'],
        'c_bg_st2_current_active' => ['type' => 'string', 'description' => 'Active (Color Hex/RGBA)'],
        'c_bg_st2_hover' => ['type' => 'string', 'description' => 'All (Color Hex/RGBA)'],
        'c_bg_st2_home_hover' => ['type' => 'string', 'description' => 'Home (Color Hex/RGBA)'],
        'c_bg_st2_current_active_hover' => ['type' => 'string', 'description' => 'Active (Color Hex/RGBA)'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports multi-layout SEO pathing, dynamic separator physics, and responsive typographic hierarchy.']
        ],
        'required' => ['post_id', 'parent_id'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_breadcrumbs_bar_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_breadcrumbs_bar_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_breadcrumbs_bar_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_breadcrumbs_bar_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-breadcrumbs-bar';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Breadcrumbs Bar widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['breadcrumbs_style'])) { $settings['breadcrumbs_style'] = sanitize_text_field($input['breadcrumbs_style']); }
    if (isset($input['breadcrumbs_full_auto'])) { $settings['breadcrumbs_full_auto'] = sanitize_text_field($input['breadcrumbs_full_auto']); }
    if (isset($input['breadcrumbs_align'])) { $settings['breadcrumbs_align'] = $input['breadcrumbs_align']; }
    if (isset($input['home_title'])) { $settings['home_title'] = sanitize_text_field($input['home_title']); }
    if (isset($input['home_select_icon'])) { $settings['home_select_icon'] = sanitize_text_field($input['home_select_icon']); }
    if (isset($input['icon_font_style'])) { $settings['icon_font_style'] = sanitize_text_field($input['icon_font_style']); }
    if (isset($input['fontawesome_option'])) { $settings['fontawesome_option'] = sanitize_text_field($input['fontawesome_option']); }
    if (isset($input['icon_fontawesome'])) { $settings['icon_fontawesome'] = sanitize_text_field($input['icon_fontawesome']); }
    if (isset($input['special_effect_options'])) { $settings['special_effect_options'] = sanitize_text_field($input['special_effect_options']); }
    if (isset($input['icon_img_options'])) { $settings['icon_img_options'] = sanitize_text_field($input['icon_img_options']); }
    if (!empty($input['icons_image'])) { $settings['icons_image'] = ['id' => absint($input['icons_image'])]; }
    if (isset($input['sep_select_icon'])) { $settings['sep_select_icon'] = sanitize_text_field($input['sep_select_icon']); }
    if (isset($input['sep_icon_font_style'])) { $settings['sep_icon_font_style'] = sanitize_text_field($input['sep_icon_font_style']); }
    if (isset($input['font_awesome_option'])) { $settings['font_awesome_option'] = sanitize_text_field($input['font_awesome_option']); }
    if (isset($input['sep_icon_fontawesome'])) { $settings['sep_icon_fontawesome'] = sanitize_text_field($input['sep_icon_fontawesome']); }
    if (isset($input['sep_icon_mind_options'])) { $settings['sep_icon_mind_options'] = sanitize_text_field($input['sep_icon_mind_options']); }
    if (isset($input['icon_image_options'])) { $settings['icon_image_options'] = sanitize_text_field($input['icon_image_options']); }
    if (!empty($input['sep_icons_image'])) { $settings['sep_icons_image'] = ['id' => absint($input['sep_icons_image'])]; }
    if (isset($input['section_letter_limit'])) { $settings['section_letter_limit'] = sanitize_text_field($input['section_letter_limit']); }
    if (isset($input['letter_limit_parent_switch'])) { $settings['letter_limit_parent_switch'] = sanitize_text_field($input['letter_limit_parent_switch']); }
    if (isset($input['letter_limit_parent'])) { $settings['letter_limit_parent'] = sanitize_text_field($input['letter_limit_parent']); }
    if (isset($input['letter_limit_current_switch'])) { $settings['letter_limit_current_switch'] = sanitize_text_field($input['letter_limit_current_switch']); }
    if (isset($input['letter_limit_current'])) { $settings['letter_limit_current'] = sanitize_text_field($input['letter_limit_current']); }
    if (isset($input['breadcrumbs_on_off_home'])) { $settings['breadcrumbs_on_off_home'] = sanitize_text_field($input['breadcrumbs_on_off_home']); }
    if (isset($input['breadcrumbs_on_off_parent'])) { $settings['breadcrumbs_on_off_parent'] = sanitize_text_field($input['breadcrumbs_on_off_parent']); }
    if (isset($input['breadcrumbs_on_off_current'])) { $settings['breadcrumbs_on_off_current'] = sanitize_text_field($input['breadcrumbs_on_off_current']); }
    if (isset($input['tpae_theme_builder'])) { $settings['tpae_theme_builder'] = sanitize_text_field($input['tpae_theme_builder']); }
    if (isset($input['bredcrums_margin'])) { $settings['bredcrums_margin'] = $input['bredcrums_margin']; }
    if (isset($input['bredcrums_padding_gap'])) { $settings['bredcrums_padding_gap'] = $input['bredcrums_padding_gap']; }
    if (isset($input['bred_text_color_option'])) { $settings['bred_text_color_option'] = sanitize_text_field($input['bred_text_color_option']); }
    if (isset($input['text_color'])) { $settings['text_color'] = sanitize_text_field($input['text_color']); }
    if (isset($input['text_gradient_color1'])) { $settings['text_gradient_color1'] = sanitize_text_field($input['text_gradient_color1']); }
    if (isset($input['text_gradient_color1_control'])) { $settings['text_gradient_color1_control'] = $input['text_gradient_color1_control']; }
    if (isset($input['text_gradient_color2'])) { $settings['text_gradient_color2'] = sanitize_text_field($input['text_gradient_color2']); }
    if (isset($input['text_gradient_color2_control'])) { $settings['text_gradient_color2_control'] = $input['text_gradient_color2_control']; }
    if (isset($input['text_gradient_style'])) { $settings['text_gradient_style'] = sanitize_text_field($input['text_gradient_style']); }
    if (isset($input['text_gradient_angle'])) { $settings['text_gradient_angle'] = $input['text_gradient_angle']; }
    if (isset($input['text_gradient_position'])) { $settings['text_gradient_position'] = sanitize_text_field($input['text_gradient_position']); }
    if (isset($input['bred_text_hover_color_option'])) { $settings['bred_text_hover_color_option'] = sanitize_text_field($input['bred_text_hover_color_option']); }
    if (isset($input['active_page_text_default'])) { $settings['active_page_text_default'] = sanitize_text_field($input['active_page_text_default']); }
    if (isset($input['text_hover_color'])) { $settings['text_hover_color'] = sanitize_text_field($input['text_hover_color']); }
    if (isset($input['text_hover_gradient_color1'])) { $settings['text_hover_gradient_color1'] = sanitize_text_field($input['text_hover_gradient_color1']); }
    if (isset($input['text_hover_gradient_color1_control'])) { $settings['text_hover_gradient_color1_control'] = $input['text_hover_gradient_color1_control']; }
    if (isset($input['text_hover_gradient_color2'])) { $settings['text_hover_gradient_color2'] = sanitize_text_field($input['text_hover_gradient_color2']); }
    if (isset($input['text_hover_gradient_color2_control'])) { $settings['text_hover_gradient_color2_control'] = $input['text_hover_gradient_color2_control']; }
    if (isset($input['text_hover_gradient_style'])) { $settings['text_hover_gradient_style'] = sanitize_text_field($input['text_hover_gradient_style']); }
    if (isset($input['text_hover_gradient_angle'])) { $settings['text_hover_gradient_angle'] = $input['text_hover_gradient_angle']; }
    if (isset($input['text_hover_gradient_position'])) { $settings['text_hover_gradient_position'] = sanitize_text_field($input['text_hover_gradient_position']); }
    if (isset($input['icon_padding'])) { $settings['icon_padding'] = $input['icon_padding']; }
    if (isset($input['icon_size'])) { $settings['icon_size'] = $input['icon_size']; }
    if (isset($input['icon_color'])) { $settings['icon_color'] = sanitize_text_field($input['icon_color']); }
    if (isset($input['icon_color_hover'])) { $settings['icon_color_hover'] = sanitize_text_field($input['icon_color_hover']); }
    if (isset($input['image_size'])) { $settings['image_size'] = $input['image_size']; }
    if (isset($input['image_border_radius'])) { $settings['image_border_radius'] = $input['image_border_radius']; }
    if (isset($input['seprator_padding'])) { $settings['seprator_padding'] = $input['seprator_padding']; }
    if (isset($input['seprator_size'])) { $settings['seprator_size'] = $input['seprator_size']; }
    if (isset($input['breadcrumps_gap'])) { $settings['breadcrumps_gap'] = $input['breadcrumps_gap']; }
    if (isset($input['seprator_color'])) { $settings['seprator_color'] = sanitize_text_field($input['seprator_color']); }
    if (isset($input['seprator_color_hover'])) { $settings['seprator_color_hover'] = sanitize_text_field($input['seprator_color_hover']); }
    if (isset($input['seprator_image_size'])) { $settings['seprator_image_size'] = $input['seprator_image_size']; }
    if (isset($input['c_bg_st1_padding'])) { $settings['c_bg_st1_padding'] = $input['c_bg_st1_padding']; }
    if (isset($input['content_background_border_radius'])) { $settings['content_background_border_radius'] = $input['content_background_border_radius']; }
    if (isset($input['sep_bg_padding'])) { $settings['sep_bg_padding'] = $input['sep_bg_padding']; }
    if (isset($input['sep_bg_border_radius'])) { $settings['sep_bg_border_radius'] = $input['sep_bg_border_radius']; }
    if (isset($input['c_bg_st2'])) { $settings['c_bg_st2'] = sanitize_text_field($input['c_bg_st2']); }
    if (isset($input['c_bg_st2_home'])) { $settings['c_bg_st2_home'] = sanitize_text_field($input['c_bg_st2_home']); }
    if (isset($input['c_bg_st2_current_active'])) { $settings['c_bg_st2_current_active'] = sanitize_text_field($input['c_bg_st2_current_active']); }
    if (isset($input['c_bg_st2_hover'])) { $settings['c_bg_st2_hover'] = sanitize_text_field($input['c_bg_st2_hover']); }
    if (isset($input['c_bg_st2_home_hover'])) { $settings['c_bg_st2_home_hover'] = sanitize_text_field($input['c_bg_st2_home_hover']); }
    if (isset($input['c_bg_st2_current_active_hover'])) { $settings['c_bg_st2_current_active_hover'] = sanitize_text_field($input['c_bg_st2_current_active_hover']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
