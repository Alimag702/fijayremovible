<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-button', [
    'label' => __('Button', 'tpebl'),
    'description' => __('Adds the The Plus "Button" widget (tp-button) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'button_type_switch' => ['type' => 'string', 'description' => 'Button Type', 'enum' => ['basic', 'icon', 'toggle']],
        'button_global_style_preset' => ['type' => 'string', 'description' => 'Global Style', 'enum' => ['button_type_switch']],
        'button_style' => ['type' => 'string', 'description' => 'Button Style', 'enum' => ['button_type_switch', 'style-1', 'style-10', 'style-11', 'style-12', 'style-13', 'style-14', 'style-15', 'style-16', 'style-17', 'style-18', 'style-19', 'style-2', 'style-20', 'style-21', 'style-22', 'style-24', 'style-3', 'style-4', 'style-5', 'style-6', 'style-7', 'style-8', 'style-9']],
        'button_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'icon', 'left', 'right']],
        'btn_hover_style' => ['type' => 'string', 'description' => 'Button Style', 'enum' => ['button_style', 'button_type_switch', 'hover-bottom', 'hover-left', 'hover-right', 'hover-top']],
        'button_text' => ['type' => 'string', 'description' => 'Text'],
        'button_24_text' => ['type' => 'string', 'description' => 'Button Tag Text'],
        'button_hover_text' => ['type' => 'string', 'description' => 'button_hover_text'],
        'button_link' => ['type' => 'object', 'description' => 'Link'],
        'button_custom_attributes' => ['type' => 'string', 'description' => 'Add Custom Attributes', 'enum' => ['yes', 'no']],
        'custom_attributes' => ['type' => 'string', 'description' => 'Custom Attributes'],
        'adv_button_icon_5' => ['type' => 'string', 'description' => 'Icon Library'],
        'adv_before_after' => ['type' => 'string', 'description' => 'Icon Position', 'enum' => ['after', 'before']],
        'icon_hover_style' => ['type' => 'string', 'description' => 'Icon Hover Style', 'enum' => ['button_style', 'hover-bottom', 'hover-top']],
        'button_icon_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['button_style!', 'font_awesome', 'font_awesome_5', 'icon_mind', 'none']],
        'font_awesome' => ['type' => 'string', 'description' => 'Font Awesome', 'enum' => ['yes', 'no']],
        'button_icon' => ['type' => 'string', 'description' => 'Icon'],
        'font_awesome_5' => ['type' => 'string', 'description' => 'Font Awesome 5', 'enum' => ['yes', 'no']],
        'button_icon_5' => ['type' => 'string', 'description' => 'Icon Library'],
        'iconmind_options' => ['type' => 'string', 'description' => 'iconmind_options'],
        'icon_circl_size' => ['type' => 'object', 'description' => 'Circle Size (Slider/Size Object)'],
        'before_after' => ['type' => 'string', 'description' => 'Icon Position', 'enum' => ['after', 'before', 'button_icon_style!', 'button_style!']],
        'icon_spacing' => ['type' => 'object', 'description' => 'Icon Spacing (Slider/Size Object)'],
        'icon_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'button_css_id' => ['type' => 'string', 'description' => 'Button ID'],
        'button_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'button_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'button_svg_icon_size' => ['type' => 'object', 'description' => 'SVG Icon Size (Slider/Size Object)'],
        'btn_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'btn_icon_color' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'icon_fill_color' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'button_border_style' => ['type' => 'string', 'description' => 'Border Style'],
        'button_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'button_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'button_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'button_radius_18' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'btn_bottom_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'bottom_border_height' => ['type' => 'object', 'description' => 'Border Height (Slider/Size Object)'],
        'btn_text_hover_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'btn_icon_color_hover' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'icon_fill_color_hover' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color_hover' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'hover_button_border_style' => ['type' => 'string', 'description' => 'Border Style'],
        'hover_button_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'button_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'button_radius_hover_18' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'button_hover_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'btn_bottom_border_hover_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'btn_tag_text_color' => ['type' => 'string', 'description' => 'Button Tag Color (Color Hex/RGBA)'],
        'btn_magic_scroll' => ['type' => 'string', 'description' => 'Magic Scroll', 'enum' => ['yes', 'no']],
        'btn_magic_scroll_options' => ['type' => 'string', 'description' => 'btn_magic_scroll_options'],
        'plus_tooltip' => ['type' => 'string', 'description' => 'plus_tooltip', 'enum' => ['yes', 'no']],
        'plus_tooltip_options' => ['type' => 'string', 'description' => 'plus_tooltip_options'],
        'btn_special_effect' => ['type' => 'string', 'description' => 'Special Effect', 'enum' => ['yes', 'no']],
        'btn_special_effect_options' => ['type' => 'string', 'description' => 'btn_special_effect_options'],
        'plus_mouse_move_parallax' => ['type' => 'string', 'description' => 'Mouse Move Parallax', 'enum' => ['yes', 'no']],
        'plus_mouse_move_parallax_options' => ['type' => 'string', 'description' => 'plus_mouse_move_parallax_options'],
        'plus_continuous_animation' => ['type' => 'string', 'description' => 'plus_continuous_animation', 'enum' => ['yes', 'no']],
        'plus_continuous_animation_options' => ['type' => 'string', 'description' => 'plus_continuous_animation_options'],
        'full_width_btn' => ['type' => 'string', 'description' => 'full_width_btn', 'enum' => ['yes', 'no']],
        'btn_hover_effects' => ['type' => 'string', 'description' => 'btn_hover_effects'],
        'btn_hover_effects_pro' => ['type' => 'string', 'description' => 'btn_hover_effects_pro'],
        'hover_shadow_color' => ['type' => 'string', 'description' => 'Shadow Color (Color Hex/RGBA)'],
        'shake_animate' => ['type' => 'string', 'description' => 'shake_animate', 'enum' => ['yes', 'no']],
        'shake_animate_duration' => ['type' => 'string', 'description' => 'Interval Shake Duration'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports 24+ stylistic hover presets, dynamic SVG pathing, and responsive kinetic geometry.']
        ],
        'required' => ['post_id', 'parent_id', 'button_text'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_button_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_button_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_button_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_button_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-button';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Button widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['button_type_switch'])) { $settings['button_type_switch'] = sanitize_text_field($input['button_type_switch']); }
    if (isset($input['button_global_style_preset'])) { $settings['button_global_style_preset'] = sanitize_text_field($input['button_global_style_preset']); }
    if (isset($input['button_style'])) { $settings['button_style'] = sanitize_text_field($input['button_style']); }
    if (isset($input['button_align'])) { $settings['button_align'] = $input['button_align']; }
    if (isset($input['btn_hover_style'])) { $settings['btn_hover_style'] = sanitize_text_field($input['btn_hover_style']); }
    if (isset($input['button_text'])) { $settings['button_text'] = sanitize_text_field($input['button_text']); }
    if (isset($input['button_24_text'])) { $settings['button_24_text'] = sanitize_text_field($input['button_24_text']); }
    if (isset($input['button_hover_text'])) { $settings['button_hover_text'] = sanitize_text_field($input['button_hover_text']); }
    if (isset($input['button_link'])) { $settings['button_link'] = $input['button_link']; }
    if (isset($input['button_custom_attributes'])) { $settings['button_custom_attributes'] = sanitize_text_field($input['button_custom_attributes']); }
    if (isset($input['custom_attributes'])) { $settings['custom_attributes'] = sanitize_text_field($input['custom_attributes']); }
    if (isset($input['adv_button_icon_5'])) { $settings['adv_button_icon_5'] = sanitize_text_field($input['adv_button_icon_5']); }
    if (isset($input['adv_before_after'])) { $settings['adv_before_after'] = sanitize_text_field($input['adv_before_after']); }
    if (isset($input['icon_hover_style'])) { $settings['icon_hover_style'] = sanitize_text_field($input['icon_hover_style']); }
    if (isset($input['button_icon_style'])) { $settings['button_icon_style'] = sanitize_text_field($input['button_icon_style']); }
    if (isset($input['font_awesome'])) { $settings['font_awesome'] = sanitize_text_field($input['font_awesome']); }
    if (isset($input['button_icon'])) { $settings['button_icon'] = sanitize_text_field($input['button_icon']); }
    if (isset($input['font_awesome_5'])) { $settings['font_awesome_5'] = sanitize_text_field($input['font_awesome_5']); }
    if (isset($input['button_icon_5'])) { $settings['button_icon_5'] = sanitize_text_field($input['button_icon_5']); }
    if (isset($input['iconmind_options'])) { $settings['iconmind_options'] = sanitize_text_field($input['iconmind_options']); }
    if (isset($input['icon_circl_size'])) { $settings['icon_circl_size'] = $input['icon_circl_size']; }
    if (isset($input['before_after'])) { $settings['before_after'] = sanitize_text_field($input['before_after']); }
    if (isset($input['icon_spacing'])) { $settings['icon_spacing'] = $input['icon_spacing']; }
    if (isset($input['icon_size'])) { $settings['icon_size'] = $input['icon_size']; }
    if (isset($input['button_css_id'])) { $settings['button_css_id'] = sanitize_text_field($input['button_css_id']); }
    if (isset($input['button_margin'])) { $settings['button_margin'] = $input['button_margin']; }
    if (isset($input['button_padding'])) { $settings['button_padding'] = $input['button_padding']; }
    if (isset($input['button_svg_icon_size'])) { $settings['button_svg_icon_size'] = $input['button_svg_icon_size']; }
    if (isset($input['btn_text_color'])) { $settings['btn_text_color'] = sanitize_text_field($input['btn_text_color']); }
    if (isset($input['btn_icon_color'])) { $settings['btn_icon_color'] = sanitize_text_field($input['btn_icon_color']); }
    if (isset($input['icon_fill_color'])) { $settings['icon_fill_color'] = sanitize_text_field($input['icon_fill_color']); }
    if (isset($input['icon_stroke_color'])) { $settings['icon_stroke_color'] = sanitize_text_field($input['icon_stroke_color']); }
    if (isset($input['button_border_style'])) { $settings['button_border_style'] = sanitize_text_field($input['button_border_style']); }
    if (isset($input['button_border_width'])) { $settings['button_border_width'] = $input['button_border_width']; }
    if (isset($input['button_border_color'])) { $settings['button_border_color'] = sanitize_text_field($input['button_border_color']); }
    if (isset($input['button_radius'])) { $settings['button_radius'] = $input['button_radius']; }
    if (isset($input['button_radius_18'])) { $settings['button_radius_18'] = $input['button_radius_18']; }
    if (isset($input['btn_bottom_border_color'])) { $settings['btn_bottom_border_color'] = sanitize_text_field($input['btn_bottom_border_color']); }
    if (isset($input['bottom_border_height'])) { $settings['bottom_border_height'] = $input['bottom_border_height']; }
    if (isset($input['btn_text_hover_color'])) { $settings['btn_text_hover_color'] = sanitize_text_field($input['btn_text_hover_color']); }
    if (isset($input['btn_icon_color_hover'])) { $settings['btn_icon_color_hover'] = sanitize_text_field($input['btn_icon_color_hover']); }
    if (isset($input['icon_fill_color_hover'])) { $settings['icon_fill_color_hover'] = sanitize_text_field($input['icon_fill_color_hover']); }
    if (isset($input['icon_stroke_color_hover'])) { $settings['icon_stroke_color_hover'] = sanitize_text_field($input['icon_stroke_color_hover']); }
    if (isset($input['hover_button_border_style'])) { $settings['hover_button_border_style'] = sanitize_text_field($input['hover_button_border_style']); }
    if (isset($input['hover_button_border_width'])) { $settings['hover_button_border_width'] = $input['hover_button_border_width']; }
    if (isset($input['button_border_hover_color'])) { $settings['button_border_hover_color'] = sanitize_text_field($input['button_border_hover_color']); }
    if (isset($input['button_radius_hover_18'])) { $settings['button_radius_hover_18'] = $input['button_radius_hover_18']; }
    if (isset($input['button_hover_radius'])) { $settings['button_hover_radius'] = $input['button_hover_radius']; }
    if (isset($input['btn_bottom_border_hover_color'])) { $settings['btn_bottom_border_hover_color'] = sanitize_text_field($input['btn_bottom_border_hover_color']); }
    if (isset($input['btn_tag_text_color'])) { $settings['btn_tag_text_color'] = sanitize_text_field($input['btn_tag_text_color']); }
    if (isset($input['btn_magic_scroll'])) { $settings['btn_magic_scroll'] = sanitize_text_field($input['btn_magic_scroll']); }
    if (isset($input['btn_magic_scroll_options'])) { $settings['btn_magic_scroll_options'] = sanitize_text_field($input['btn_magic_scroll_options']); }
    if (isset($input['plus_tooltip'])) { $settings['plus_tooltip'] = sanitize_text_field($input['plus_tooltip']); }
    if (isset($input['plus_tooltip_options'])) { $settings['plus_tooltip_options'] = sanitize_text_field($input['plus_tooltip_options']); }
    if (isset($input['btn_special_effect'])) { $settings['btn_special_effect'] = sanitize_text_field($input['btn_special_effect']); }
    if (isset($input['btn_special_effect_options'])) { $settings['btn_special_effect_options'] = sanitize_text_field($input['btn_special_effect_options']); }
    if (isset($input['plus_mouse_move_parallax'])) { $settings['plus_mouse_move_parallax'] = sanitize_text_field($input['plus_mouse_move_parallax']); }
    if (isset($input['plus_mouse_move_parallax_options'])) { $settings['plus_mouse_move_parallax_options'] = sanitize_text_field($input['plus_mouse_move_parallax_options']); }
    if (isset($input['plus_continuous_animation'])) { $settings['plus_continuous_animation'] = sanitize_text_field($input['plus_continuous_animation']); }
    if (isset($input['plus_continuous_animation_options'])) { $settings['plus_continuous_animation_options'] = sanitize_text_field($input['plus_continuous_animation_options']); }
    if (isset($input['full_width_btn'])) { $settings['full_width_btn'] = sanitize_text_field($input['full_width_btn']); }
    if (isset($input['btn_hover_effects'])) { $settings['btn_hover_effects'] = sanitize_text_field($input['btn_hover_effects']); }
    if (isset($input['btn_hover_effects_pro'])) { $settings['btn_hover_effects_pro'] = sanitize_text_field($input['btn_hover_effects_pro']); }
    if (isset($input['hover_shadow_color'])) { $settings['hover_shadow_color'] = sanitize_text_field($input['hover_shadow_color']); }
    if (isset($input['shake_animate'])) { $settings['shake_animate'] = sanitize_text_field($input['shake_animate']); }
    if (isset($input['shake_animate_duration'])) { $settings['shake_animate_duration'] = sanitize_text_field($input['shake_animate_duration']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
