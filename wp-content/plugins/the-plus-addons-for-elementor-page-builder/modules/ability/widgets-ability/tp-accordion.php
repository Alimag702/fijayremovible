<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-accordion', [
    'label' => __('Accordion', 'tpebl'),
    'description' => __('Adds the The Plus "Accordion" widget (tp-accordion) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'accordion_type' => ['type' => 'string', 'description' => 'Content Source', 'enum' => ['acf_repeater', 'content']],
        'acf_rep_pro' => ['type' => 'string', 'description' => 'acf_rep_pro'],
        'tab_title' => ['type' => 'string', 'description' => 'Title'],
        'content_source' => ['type' => 'string', 'description' => 'Type', 'enum' => ['content', 'page_template']],
        'tab_content' => ['type' => 'string', 'description' => 'Content'],
        'content_template' => ['type' => 'string', 'description' => 'Templates', 'enum' => ['content_source', 'show_label']],
        'backend_preview_template' => ['type' => 'string', 'description' => 'Backend Visibility', 'enum' => ['yes', 'no']],
        'display_icon' => ['type' => 'string', 'description' => 'display_icon', 'enum' => ['yes', 'no']],
        'display_icon_options' => ['type' => 'string', 'description' => 'display_icon_options'],
        'tabs' => ['type' => 'array', 'items' => ['type' => 'object'], 'description' => 'Accordions'],
        'display_icon' => ['type' => 'string', 'description' => 'display_icon', 'enum' => ['yes', 'no']],
        'icon_align' => ['type' => 'string', 'description' => 'Alignment', 'enum' => ['display_icon', 'icon', 'left', 'right', 'toggle']],
        'icon_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['display_icon', 'font_awesome', 'font_awesome_5', 'icon_mind']],
        'icon_fs_popover_toggle' => ['type' => 'string', 'description' => 'Font Awesome'],
        'icon_fontawesome' => ['type' => 'string', 'description' => 'Icon Library'],
        'icon_fontawesome_active' => ['type' => 'string', 'description' => 'Active Icon Library'],
        'icon_f5_popover_toggle' => ['type' => 'string', 'description' => 'Font Awesome 5'],
        'icon_fontawesome_5' => ['type' => 'string', 'description' => 'Icon Library'],
        'icon_fontawesome_5_active' => ['type' => 'string', 'description' => 'Icon Library'],
        'icons_mind_options' => ['type' => 'string', 'description' => 'icons_mind_options'],
        'title_html_tag' => ['type' => 'string', 'description' => 'Title Tag', 'enum' => ['div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']],
        'on_hover_accordion' => ['type' => 'string', 'description' => 'On Hover Accordion', 'enum' => ['yes', 'no']],
        'on_hover_section' => ['type' => 'string', 'description' => 'on_hover_section'],
        'horizontal_accordion' => ['type' => 'string', 'description' => 'Horizontal Accordion', 'enum' => ['yes', 'no']],
        'horizontal_section' => ['type' => 'string', 'description' => 'horizontal_section'],
        'tabs_autoplay' => ['type' => 'string', 'description' => 'Autoplay', 'enum' => ['yes', 'no']],
        'autoplay_section' => ['type' => 'string', 'description' => 'autoplay_section'],
        'expand_collapse' => ['type' => 'string', 'description' => 'Expand & Collapse Button', 'enum' => ['yes', 'no']],
        'expand_collapse_section' => ['type' => 'string', 'description' => 'expand_collapse_section'],
        'search_bar' => ['type' => 'string', 'description' => 'Search Bar', 'enum' => ['yes', 'no']],
        'search_bar_section' => ['type' => 'string', 'description' => 'search_bar_section'],
        'slider_accordion' => ['type' => 'string', 'description' => 'Slider & Pagination', 'enum' => ['yes', 'no']],
        'slider_accordion_section' => ['type' => 'string', 'description' => 'slider_accordion_section'],
        'active_accordion' => ['type' => 'string', 'description' => 'active_accordion'],
        'accordion_scroll_top' => ['type' => 'string', 'description' => 'accordion_scroll_top', 'enum' => ['yes', 'no']],
        'scroll_top_section' => ['type' => 'string', 'description' => 'scroll_top_section'],
        'schema_accordion' => ['type' => 'string', 'description' => 'schema_accordion', 'enum' => ['yes', 'no']],
        'schema_accordion_section' => ['type' => 'string', 'description' => 'schema_accordion_section'],
        'accordion_stager' => ['type' => 'string', 'description' => 'accordion_stager', 'enum' => ['yes', 'no']],
        'accordion_stager_section' => ['type' => 'string', 'description' => 'accordion_stager_section'],
        'icon_space' => ['type' => 'object', 'description' => 'Gap (Slider/Size Object)'],
        'toggle_icon_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'icon_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'icon_fill_color' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'icon_active_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'icon_fill_color_active' => ['type' => 'string', 'description' => 'Active Fill  (Color Hex/RGBA)'],
        'icon_stroke_color_active' => ['type' => 'string', 'description' => 'Active Stroke (Color Hex/RGBA)'],
        'title_accordion_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'title_color_option' => ['type' => 'string', 'description' => 'Color', 'enum' => ['gradient', 'icon', 'solid']],
        'title_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'title_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'title_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'title_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'title_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'title_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['of_type', 'title_color_option']],
        'title_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'title_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['of_type', 'title_color_option', 'title_gradient_style', '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header']],
        'title_active_color_option' => ['type' => 'string', 'description' => 'Title Active Color', 'enum' => ['gradient', 'icon', 'solid']],
        'title_active_color' => ['type' => 'string', 'description' => 'Active Color (Color Hex/RGBA)'],
        'title_active_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'title_active_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'title_active_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'title_active_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'title_active_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['of_type', 'title_active_color_option']],
        'title_active_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'title_active_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['of_type', 'title_active_color_option', 'title_active_gradient_style', '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header.active']],
        'title_box_border' => ['type' => 'string', 'description' => 'Box Border', 'enum' => ['yes', 'no']],
        'title_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['title_box_border', '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header']],
        'title_box_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'title_box_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'title_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'accordion_space' => ['type' => 'object', 'description' => 'Accordion Between Space (Slider/Size Object)'],
        'content_accordion_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'content_accordion_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'desc_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'content_box_border' => ['type' => 'string', 'description' => 'Box Border', 'enum' => ['yes', 'no']],
        'content_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['content_box_border', '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-content']],
        'content_box_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'content_box_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'content_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'section_hover_styling_options' => ['type' => 'string', 'description' => 'section_hover_styling_options'],
        'animation_effects' => ['type' => 'string', 'description' => 'In Animation Effect'],
        'animation_delay' => ['type' => 'object', 'description' => 'Animation Delay (Slider/Size Object)'],
        'animation_duration_default' => ['type' => 'string', 'description' => 'Animation Duration', 'enum' => ['yes', 'no']],
        'animate_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'animation_out_effects' => ['type' => 'string', 'description' => 'Out Animation Effect', 'enum' => ['animation_effects!']],
        'animation_out_delay' => ['type' => 'object', 'description' => 'Out Animation Delay (Slider/Size Object)'],
        'animation_out_duration_default' => ['type' => 'string', 'description' => 'Out Animation Duration', 'enum' => ['yes', 'no']],
        'animation_out_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports kinetic open/close physics, template-based item injection, and responsive interactive geometry.']
        ],
        'required' => ['post_id', 'parent_id'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_accordion_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_accordion_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_accordion_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_accordion_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-accordion';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Accordion widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['accordion_type'])) { $settings['accordion_type'] = sanitize_text_field($input['accordion_type']); }
    if (isset($input['acf_rep_pro'])) { $settings['acf_rep_pro'] = sanitize_text_field($input['acf_rep_pro']); }
    if (isset($input['tab_title'])) { $settings['tab_title'] = sanitize_text_field($input['tab_title']); }
    if (isset($input['content_source'])) { $settings['content_source'] = sanitize_text_field($input['content_source']); }
    if (isset($input['tab_content'])) { $settings['tab_content'] = sanitize_text_field($input['tab_content']); }
    if (isset($input['content_template'])) { $settings['content_template'] = sanitize_text_field($input['content_template']); }
    if (isset($input['backend_preview_template'])) { $settings['backend_preview_template'] = sanitize_text_field($input['backend_preview_template']); }
    if (isset($input['display_icon'])) { $settings['display_icon'] = sanitize_text_field($input['display_icon']); }
    if (isset($input['display_icon_options'])) { $settings['display_icon_options'] = sanitize_text_field($input['display_icon_options']); }
    if (isset($input['tabs'])) { $settings['tabs'] = $input['tabs']; }
    if (isset($input['display_icon'])) { $settings['display_icon'] = sanitize_text_field($input['display_icon']); }
    if (isset($input['icon_align'])) { $settings['icon_align'] = sanitize_text_field($input['icon_align']); }
    if (isset($input['icon_style'])) { $settings['icon_style'] = sanitize_text_field($input['icon_style']); }
    if (isset($input['icon_fs_popover_toggle'])) { $settings['icon_fs_popover_toggle'] = sanitize_text_field($input['icon_fs_popover_toggle']); }
    if (isset($input['icon_fontawesome'])) { $settings['icon_fontawesome'] = sanitize_text_field($input['icon_fontawesome']); }
    if (isset($input['icon_fontawesome_active'])) { $settings['icon_fontawesome_active'] = sanitize_text_field($input['icon_fontawesome_active']); }
    if (isset($input['icon_f5_popover_toggle'])) { $settings['icon_f5_popover_toggle'] = sanitize_text_field($input['icon_f5_popover_toggle']); }
    if (isset($input['icon_fontawesome_5'])) { $settings['icon_fontawesome_5'] = sanitize_text_field($input['icon_fontawesome_5']); }
    if (isset($input['icon_fontawesome_5_active'])) { $settings['icon_fontawesome_5_active'] = sanitize_text_field($input['icon_fontawesome_5_active']); }
    if (isset($input['icons_mind_options'])) { $settings['icons_mind_options'] = sanitize_text_field($input['icons_mind_options']); }
    if (isset($input['title_html_tag'])) { $settings['title_html_tag'] = sanitize_text_field($input['title_html_tag']); }
    if (isset($input['on_hover_accordion'])) { $settings['on_hover_accordion'] = sanitize_text_field($input['on_hover_accordion']); }
    if (isset($input['on_hover_section'])) { $settings['on_hover_section'] = sanitize_text_field($input['on_hover_section']); }
    if (isset($input['horizontal_accordion'])) { $settings['horizontal_accordion'] = sanitize_text_field($input['horizontal_accordion']); }
    if (isset($input['horizontal_section'])) { $settings['horizontal_section'] = sanitize_text_field($input['horizontal_section']); }
    if (isset($input['tabs_autoplay'])) { $settings['tabs_autoplay'] = sanitize_text_field($input['tabs_autoplay']); }
    if (isset($input['autoplay_section'])) { $settings['autoplay_section'] = sanitize_text_field($input['autoplay_section']); }
    if (isset($input['expand_collapse'])) { $settings['expand_collapse'] = sanitize_text_field($input['expand_collapse']); }
    if (isset($input['expand_collapse_section'])) { $settings['expand_collapse_section'] = sanitize_text_field($input['expand_collapse_section']); }
    if (isset($input['search_bar'])) { $settings['search_bar'] = sanitize_text_field($input['search_bar']); }
    if (isset($input['search_bar_section'])) { $settings['search_bar_section'] = sanitize_text_field($input['search_bar_section']); }
    if (isset($input['slider_accordion'])) { $settings['slider_accordion'] = sanitize_text_field($input['slider_accordion']); }
    if (isset($input['slider_accordion_section'])) { $settings['slider_accordion_section'] = sanitize_text_field($input['slider_accordion_section']); }
    if (isset($input['active_accordion'])) { $settings['active_accordion'] = sanitize_text_field($input['active_accordion']); }
    if (isset($input['accordion_scroll_top'])) { $settings['accordion_scroll_top'] = sanitize_text_field($input['accordion_scroll_top']); }
    if (isset($input['scroll_top_section'])) { $settings['scroll_top_section'] = sanitize_text_field($input['scroll_top_section']); }
    if (isset($input['schema_accordion'])) { $settings['schema_accordion'] = sanitize_text_field($input['schema_accordion']); }
    if (isset($input['schema_accordion_section'])) { $settings['schema_accordion_section'] = sanitize_text_field($input['schema_accordion_section']); }
    if (isset($input['accordion_stager'])) { $settings['accordion_stager'] = sanitize_text_field($input['accordion_stager']); }
    if (isset($input['accordion_stager_section'])) { $settings['accordion_stager_section'] = sanitize_text_field($input['accordion_stager_section']); }
    if (isset($input['icon_space'])) { $settings['icon_space'] = $input['icon_space']; }
    if (isset($input['toggle_icon_size'])) { $settings['toggle_icon_size'] = $input['toggle_icon_size']; }
    if (isset($input['icon_color'])) { $settings['icon_color'] = sanitize_text_field($input['icon_color']); }
    if (isset($input['icon_fill_color'])) { $settings['icon_fill_color'] = sanitize_text_field($input['icon_fill_color']); }
    if (isset($input['icon_stroke_color'])) { $settings['icon_stroke_color'] = sanitize_text_field($input['icon_stroke_color']); }
    if (isset($input['icon_active_color'])) { $settings['icon_active_color'] = sanitize_text_field($input['icon_active_color']); }
    if (isset($input['icon_fill_color_active'])) { $settings['icon_fill_color_active'] = sanitize_text_field($input['icon_fill_color_active']); }
    if (isset($input['icon_stroke_color_active'])) { $settings['icon_stroke_color_active'] = sanitize_text_field($input['icon_stroke_color_active']); }
    if (isset($input['title_accordion_padding'])) { $settings['title_accordion_padding'] = $input['title_accordion_padding']; }
    if (isset($input['title_color_option'])) { $settings['title_color_option'] = sanitize_text_field($input['title_color_option']); }
    if (isset($input['title_color'])) { $settings['title_color'] = sanitize_text_field($input['title_color']); }
    if (isset($input['title_gradient_color1'])) { $settings['title_gradient_color1'] = sanitize_text_field($input['title_gradient_color1']); }
    if (isset($input['title_gradient_color1_control'])) { $settings['title_gradient_color1_control'] = $input['title_gradient_color1_control']; }
    if (isset($input['title_gradient_color2'])) { $settings['title_gradient_color2'] = sanitize_text_field($input['title_gradient_color2']); }
    if (isset($input['title_gradient_color2_control'])) { $settings['title_gradient_color2_control'] = $input['title_gradient_color2_control']; }
    if (isset($input['title_gradient_style'])) { $settings['title_gradient_style'] = sanitize_text_field($input['title_gradient_style']); }
    if (isset($input['title_gradient_angle'])) { $settings['title_gradient_angle'] = $input['title_gradient_angle']; }
    if (isset($input['title_gradient_position'])) { $settings['title_gradient_position'] = sanitize_text_field($input['title_gradient_position']); }
    if (isset($input['title_active_color_option'])) { $settings['title_active_color_option'] = sanitize_text_field($input['title_active_color_option']); }
    if (isset($input['title_active_color'])) { $settings['title_active_color'] = sanitize_text_field($input['title_active_color']); }
    if (isset($input['title_active_gradient_color1'])) { $settings['title_active_gradient_color1'] = sanitize_text_field($input['title_active_gradient_color1']); }
    if (isset($input['title_active_gradient_color1_control'])) { $settings['title_active_gradient_color1_control'] = $input['title_active_gradient_color1_control']; }
    if (isset($input['title_active_gradient_color2'])) { $settings['title_active_gradient_color2'] = sanitize_text_field($input['title_active_gradient_color2']); }
    if (isset($input['title_active_gradient_color2_control'])) { $settings['title_active_gradient_color2_control'] = $input['title_active_gradient_color2_control']; }
    if (isset($input['title_active_gradient_style'])) { $settings['title_active_gradient_style'] = sanitize_text_field($input['title_active_gradient_style']); }
    if (isset($input['title_active_gradient_angle'])) { $settings['title_active_gradient_angle'] = $input['title_active_gradient_angle']; }
    if (isset($input['title_active_gradient_position'])) { $settings['title_active_gradient_position'] = sanitize_text_field($input['title_active_gradient_position']); }
    if (isset($input['title_box_border'])) { $settings['title_box_border'] = sanitize_text_field($input['title_box_border']); }
    if (isset($input['title_border_style'])) { $settings['title_border_style'] = sanitize_text_field($input['title_border_style']); }
    if (isset($input['title_box_border_width'])) { $settings['title_box_border_width'] = $input['title_box_border_width']; }
    if (isset($input['title_box_border_color'])) { $settings['title_box_border_color'] = sanitize_text_field($input['title_box_border_color']); }
    if (isset($input['title_border_radius'])) { $settings['title_border_radius'] = $input['title_border_radius']; }
    if (isset($input['accordion_space'])) { $settings['accordion_space'] = $input['accordion_space']; }
    if (isset($input['content_accordion_padding'])) { $settings['content_accordion_padding'] = $input['content_accordion_padding']; }
    if (isset($input['content_accordion_margin'])) { $settings['content_accordion_margin'] = $input['content_accordion_margin']; }
    if (isset($input['desc_color'])) { $settings['desc_color'] = sanitize_text_field($input['desc_color']); }
    if (isset($input['content_box_border'])) { $settings['content_box_border'] = sanitize_text_field($input['content_box_border']); }
    if (isset($input['content_border_style'])) { $settings['content_border_style'] = sanitize_text_field($input['content_border_style']); }
    if (isset($input['content_box_border_width'])) { $settings['content_box_border_width'] = $input['content_box_border_width']; }
    if (isset($input['content_box_border_color'])) { $settings['content_box_border_color'] = sanitize_text_field($input['content_box_border_color']); }
    if (isset($input['content_border_radius'])) { $settings['content_border_radius'] = $input['content_border_radius']; }
    if (isset($input['section_hover_styling_options'])) { $settings['section_hover_styling_options'] = sanitize_text_field($input['section_hover_styling_options']); }
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
