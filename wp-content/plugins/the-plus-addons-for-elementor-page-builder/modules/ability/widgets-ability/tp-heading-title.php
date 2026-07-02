<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-heading-title', [
    'label' => __('Heading Title', 'tpebl'),
    'description' => __('Adds the The Plus "Heading Title" widget (tp-heading-title) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'heading_style' => ['type' => 'string', 'description' => 'Style', 'enum' => ['style_1', 'style_2', 'style_4', 'style_5', 'style_6', 'style_7', 'style_8', 'style_9']],
        'select_heading' => ['type' => 'string', 'description' => 'Select Heading', 'enum' => ['page_title']],
        'sub_title_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'devices', 'icon', 'justify', 'left', 'prefix_class', 'right']],
        'title' => ['type' => 'string', 'description' => 'Heading Title'],
        'sub_title' => ['type' => 'string', 'description' => 'Sub Title'],
        'title_s' => ['type' => 'string', 'description' => 'Extra Title'],
        'heading_s_style' => ['type' => 'string', 'description' => 'Extra Title Position', 'enum' => ['heading_style', 'text_after', 'text_before']],
        'heading_title_subtitle_limit' => ['type' => 'string', 'description' => 'heading_title_subtitle_limit', 'enum' => ['yes', 'no']],
        'display_heading_title_limit' => ['type' => 'string', 'description' => 'Heading Title Limit', 'enum' => ['yes', 'no']],
        'display_heading_title_by' => ['type' => 'string', 'description' => 'Limit on', 'enum' => ['char', 'display_heading_title_limit', 'heading_title_subtitle_limit', 'word']],
        'display_heading_title_input' => ['type' => 'string', 'description' => 'Heading Title Count'],
        'display_title_3_dots' => ['type' => 'string', 'description' => 'Display Dots', 'enum' => ['yes', 'no']],
        'display_sub_title_limit' => ['type' => 'string', 'description' => 'Sub Title Limit', 'enum' => ['yes', 'no']],
        'display_sub_title_by' => ['type' => 'string', 'description' => 'Limit on', 'enum' => ['char', 'display_sub_title_limit', 'heading_title_subtitle_limit', 'word']],
        'display_sub_title_input' => ['type' => 'string', 'description' => 'Sub Title Count'],
        'display_sub_title_3_dots' => ['type' => 'string', 'description' => 'Display Dots', 'enum' => ['yes', 'no']],
        'enable_text_animation' => ['type' => 'string', 'description' => 'Enable Animation'],
        'text_animations' => ['type' => 'string', 'description' => 'Animation'],
        'tp_select_text_global_animation' => ['type' => 'string', 'description' => 'Global Animation'],
        'text_animation_type' => ['type' => 'string', 'description' => 'Animation Type'],
        'tp_tansformtion_toggel' => ['type' => 'string', 'description' => 'Transform Effects '],
        'transform_x' => ['type' => 'string', 'description' => 'X Position'],
        'transform_y' => ['type' => 'string', 'description' => 'Y Position'],
        'transform_skewx' => ['type' => 'string', 'description' => 'Skew X'],
        'transform_skewy' => ['type' => 'string', 'description' => 'Skew Y'],
        'transform_scale' => ['type' => 'string', 'description' => 'Scale'],
        'transform_rotation' => ['type' => 'string', 'description' => 'Rotation'],
        'transform_origin' => ['type' => 'string', 'description' => 'Transform Origin'],
        'split_type' => ['type' => 'string', 'description' => 'Split Type'],
        'text_trigger' => ['type' => 'string', 'description' => 'Animation Trigger'],
        'tp_scrub' => ['type' => 'string', 'description' => 'tp_scrub'],
        'heading_animation_controls' => ['type' => 'string', 'description' => 'heading_animation_controls', 'enum' => ['yes', 'no']],
        'text_duration' => ['type' => 'string', 'description' => 'Duration'],
        'text_delay' => ['type' => 'string', 'description' => 'Delay'],
        'text_stagger' => ['type' => 'string', 'description' => 'Stagger'],
        'text_ease' => ['type' => 'string', 'description' => 'Animation Effects'],
        'text_repeat' => ['type' => 'string', 'description' => 'Repeat'],
        'enable_text_animation_sub_txt' => ['type' => 'string', 'description' => 'Enable Animation'],
        'sub_text_animations' => ['type' => 'string', 'description' => 'Animation'],
        'tp_select_sub_text_global_animation' => ['type' => 'string', 'description' => 'Global Animation'],
        'text_animation_type_sub_txt' => ['type' => 'string', 'description' => 'Animation Type'],
        'tp_tansformtion_toggel_sub_txt' => ['type' => 'string', 'description' => 'Transform Effects '],
        'transform_x_sub_txt' => ['type' => 'string', 'description' => 'X Position'],
        'transform_y_sub_txt' => ['type' => 'string', 'description' => 'Y Position'],
        'transform_skewx_sub_txt' => ['type' => 'string', 'description' => 'Skew X'],
        'transform_skewy_sub_txt' => ['type' => 'string', 'description' => 'Skew Y'],
        'transform_scale_sub_txt' => ['type' => 'string', 'description' => 'Scale'],
        'transform_rotation_sub_txt' => ['type' => 'string', 'description' => 'Rotation'],
        'transform_origin_sub_txt' => ['type' => 'string', 'description' => 'Transform Origin'],
        'split_type_sub_txt' => ['type' => 'string', 'description' => 'Split Type'],
        'text_trigger_sub_txt' => ['type' => 'string', 'description' => 'Animation Trigger'],
        'tp_scrub_sub_txt' => ['type' => 'string', 'description' => 'tp_scrub_sub_txt'],
        'sub_animation_controls' => ['type' => 'string', 'description' => 'sub_animation_controls', 'enum' => ['yes', 'no']],
        'text_duration_sub_txt' => ['type' => 'string', 'description' => 'Duration'],
        'text_delay_sub_txt' => ['type' => 'string', 'description' => 'Delay'],
        'text_stagger_sub_txt' => ['type' => 'string', 'description' => 'Stagger'],
        'text_ease_sub_txt' => ['type' => 'string', 'description' => 'Animation Effects'],
        'text_repeat_sub_txt' => ['type' => 'string', 'description' => 'Repeat'],
        'sep_img' => ['type' => 'integer', 'description' => 'Separator With Image (Image ID)'],
        'input_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'double_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'double_top' => ['type' => 'string', 'description' => 'Top Separator Height'],
        'double_bottom' => ['type' => 'string', 'description' => 'Bottom Separator Height'],
        'sep_clr' => ['type' => 'string', 'description' => 'Separator Color (Color Hex/RGBA)'],
        'sep_width' => ['type' => 'object', 'description' => 'Separator Width (Slider/Size Object)'],
        'dot_color' => ['type' => 'string', 'description' => 'Separator Dot Color (Color Hex/RGBA)'],
        'sep_height' => ['type' => 'object', 'description' => 'Separator Height (Slider/Size Object)'],
        'top_clr_width' => ['type' => 'object', 'description' => 'Width (Slider/Size Object)'],
        'top_clr_height' => ['type' => 'object', 'description' => 'Height (Slider/Size Object)'],
        'top_clr' => ['type' => 'string', 'description' => 'Separator Vertical Color (Color Hex/RGBA)'],
        'title_sep_spacing' => ['type' => 'object', 'description' => 'Separator Spacing (Slider/Size Object)'],
        'title_h' => ['type' => 'string', 'description' => 'Title Tag'],
        'title_link' => ['type' => 'object', 'description' => 'Heading Title Link'],
        's_maintitle_pg' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'title_color' => ['type' => 'string', 'description' => 'Title Color', 'enum' => ['gradient', 'icon', 'solid', 'toggle']],
        'title_solid_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'title_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'title_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'title_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'title_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'title_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['of_type', 'title_color']],
        'title_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'title_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['of_type', 'title_color', 'title_gradient_style', '{{WRAPPER}} .heading .heading-title']],
        'title_hover_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'special_effect' => ['type' => 'string', 'description' => 'Special Effect', 'enum' => ['yes', 'no']],
        'special_effect_options' => ['type' => 'string', 'description' => 'special_effect_options'],
        'subtitle_sep_spacing' => ['type' => 'object', 'description' => 'Separator Spacing (Slider/Size Object)'],
        'sub_title_tag' => ['type' => 'string', 'description' => 'Subtitle Tag'],
        's_subtitle_pg' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'sub_title_color' => ['type' => 'string', 'description' => 'Subtitle Title Color', 'enum' => ['gradient', 'icon', 'solid', 'toggle']],
        'sub_title_solid_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'sub_title_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'sub_title_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'sub_title_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'sub_title_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'sub_title_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['of_type', 'sub_title_color']],
        'sub_title_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'sub_title_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['of_type', 'sub_title_color', 'sub_title_gradient_style', '{{WRAPPER}} .heading .heading-sub-title']],
        'sub_title_hover_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'ex_title_color' => ['type' => 'string', 'description' => 'Extra Title Color', 'enum' => ['gradient', 'icon', 'solid', 'toggle']],
        'ex_title_solid_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'ex_title_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'ex_title_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'ex_title_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'ex_title_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'ex_title_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['ex_title_color', 'of_type']],
        'ex_title_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'ex_title_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['ex_title_color', 'ex_title_gradient_style', 'of_type', '{{WRAPPER}} .heading .title-s']],
        'ex_title_hover_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'position' => ['type' => 'string', 'description' => 'Title Position', 'enum' => ['after', 'before']],
        'mobile_center_align' => ['type' => 'string', 'description' => 'Center Alignment In Mobile', 'enum' => ['yes', 'no']],
        'animation_effects' => ['type' => 'string', 'description' => 'Choose Animation Effect'],
        'animation_delay' => ['type' => 'object', 'description' => 'Animation Delay (Slider/Size Object)'],
        'animation_duration_default' => ['type' => 'string', 'description' => 'Animation Duration', 'enum' => ['yes', 'no']],
        'animate_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'animation_out_effects' => ['type' => 'string', 'description' => 'Out Animation Effect', 'enum' => ['animation_effects!']],
        'animation_out_delay' => ['type' => 'object', 'description' => 'Out Animation Delay (Slider/Size Object)'],
        'animation_out_duration_default' => ['type' => 'string', 'description' => 'Out Animation Duration', 'enum' => ['yes', 'no']],
        'animation_out_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports SVG title stroke, background clipping typography, and animated underline physics.']
        ],
        'required' => ['post_id', 'parent_id', 'title'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_heading_title_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_heading_title_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_heading_title_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_heading_title_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-heading-title';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Heading Title widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['heading_style'])) { $settings['heading_style'] = sanitize_text_field($input['heading_style']); }
    if (isset($input['select_heading'])) { $settings['select_heading'] = sanitize_text_field($input['select_heading']); }
    if (isset($input['sub_title_align'])) { $settings['sub_title_align'] = $input['sub_title_align']; }
    if (isset($input['title'])) { $settings['title'] = sanitize_text_field($input['title']); }
    if (isset($input['sub_title'])) { $settings['sub_title'] = sanitize_text_field($input['sub_title']); }
    if (isset($input['title_s'])) { $settings['title_s'] = sanitize_text_field($input['title_s']); }
    if (isset($input['heading_s_style'])) { $settings['heading_s_style'] = sanitize_text_field($input['heading_s_style']); }
    if (isset($input['heading_title_subtitle_limit'])) { $settings['heading_title_subtitle_limit'] = sanitize_text_field($input['heading_title_subtitle_limit']); }
    if (isset($input['display_heading_title_limit'])) { $settings['display_heading_title_limit'] = sanitize_text_field($input['display_heading_title_limit']); }
    if (isset($input['display_heading_title_by'])) { $settings['display_heading_title_by'] = sanitize_text_field($input['display_heading_title_by']); }
    if (isset($input['display_heading_title_input'])) { $settings['display_heading_title_input'] = sanitize_text_field($input['display_heading_title_input']); }
    if (isset($input['display_title_3_dots'])) { $settings['display_title_3_dots'] = sanitize_text_field($input['display_title_3_dots']); }
    if (isset($input['display_sub_title_limit'])) { $settings['display_sub_title_limit'] = sanitize_text_field($input['display_sub_title_limit']); }
    if (isset($input['display_sub_title_by'])) { $settings['display_sub_title_by'] = sanitize_text_field($input['display_sub_title_by']); }
    if (isset($input['display_sub_title_input'])) { $settings['display_sub_title_input'] = sanitize_text_field($input['display_sub_title_input']); }
    if (isset($input['display_sub_title_3_dots'])) { $settings['display_sub_title_3_dots'] = sanitize_text_field($input['display_sub_title_3_dots']); }
    if (isset($input['enable_text_animation'])) { $settings['enable_text_animation'] = sanitize_text_field($input['enable_text_animation']); }
    if (isset($input['text_animations'])) { $settings['text_animations'] = sanitize_text_field($input['text_animations']); }
    if (isset($input['tp_select_text_global_animation'])) { $settings['tp_select_text_global_animation'] = sanitize_text_field($input['tp_select_text_global_animation']); }
    if (isset($input['text_animation_type'])) { $settings['text_animation_type'] = sanitize_text_field($input['text_animation_type']); }
    if (isset($input['tp_tansformtion_toggel'])) { $settings['tp_tansformtion_toggel'] = sanitize_text_field($input['tp_tansformtion_toggel']); }
    if (isset($input['transform_x'])) { $settings['transform_x'] = sanitize_text_field($input['transform_x']); }
    if (isset($input['transform_y'])) { $settings['transform_y'] = sanitize_text_field($input['transform_y']); }
    if (isset($input['transform_skewx'])) { $settings['transform_skewx'] = sanitize_text_field($input['transform_skewx']); }
    if (isset($input['transform_skewy'])) { $settings['transform_skewy'] = sanitize_text_field($input['transform_skewy']); }
    if (isset($input['transform_scale'])) { $settings['transform_scale'] = sanitize_text_field($input['transform_scale']); }
    if (isset($input['transform_rotation'])) { $settings['transform_rotation'] = sanitize_text_field($input['transform_rotation']); }
    if (isset($input['transform_origin'])) { $settings['transform_origin'] = sanitize_text_field($input['transform_origin']); }
    if (isset($input['split_type'])) { $settings['split_type'] = sanitize_text_field($input['split_type']); }
    if (isset($input['text_trigger'])) { $settings['text_trigger'] = sanitize_text_field($input['text_trigger']); }
    if (isset($input['tp_scrub'])) { $settings['tp_scrub'] = sanitize_text_field($input['tp_scrub']); }
    if (isset($input['heading_animation_controls'])) { $settings['heading_animation_controls'] = sanitize_text_field($input['heading_animation_controls']); }
    if (isset($input['text_duration'])) { $settings['text_duration'] = sanitize_text_field($input['text_duration']); }
    if (isset($input['text_delay'])) { $settings['text_delay'] = sanitize_text_field($input['text_delay']); }
    if (isset($input['text_stagger'])) { $settings['text_stagger'] = sanitize_text_field($input['text_stagger']); }
    if (isset($input['text_ease'])) { $settings['text_ease'] = sanitize_text_field($input['text_ease']); }
    if (isset($input['text_repeat'])) { $settings['text_repeat'] = sanitize_text_field($input['text_repeat']); }
    if (isset($input['enable_text_animation_sub_txt'])) { $settings['enable_text_animation_sub_txt'] = sanitize_text_field($input['enable_text_animation_sub_txt']); }
    if (isset($input['sub_text_animations'])) { $settings['sub_text_animations'] = sanitize_text_field($input['sub_text_animations']); }
    if (isset($input['tp_select_sub_text_global_animation'])) { $settings['tp_select_sub_text_global_animation'] = sanitize_text_field($input['tp_select_sub_text_global_animation']); }
    if (isset($input['text_animation_type_sub_txt'])) { $settings['text_animation_type_sub_txt'] = sanitize_text_field($input['text_animation_type_sub_txt']); }
    if (isset($input['tp_tansformtion_toggel_sub_txt'])) { $settings['tp_tansformtion_toggel_sub_txt'] = sanitize_text_field($input['tp_tansformtion_toggel_sub_txt']); }
    if (isset($input['transform_x_sub_txt'])) { $settings['transform_x_sub_txt'] = sanitize_text_field($input['transform_x_sub_txt']); }
    if (isset($input['transform_y_sub_txt'])) { $settings['transform_y_sub_txt'] = sanitize_text_field($input['transform_y_sub_txt']); }
    if (isset($input['transform_skewx_sub_txt'])) { $settings['transform_skewx_sub_txt'] = sanitize_text_field($input['transform_skewx_sub_txt']); }
    if (isset($input['transform_skewy_sub_txt'])) { $settings['transform_skewy_sub_txt'] = sanitize_text_field($input['transform_skewy_sub_txt']); }
    if (isset($input['transform_scale_sub_txt'])) { $settings['transform_scale_sub_txt'] = sanitize_text_field($input['transform_scale_sub_txt']); }
    if (isset($input['transform_rotation_sub_txt'])) { $settings['transform_rotation_sub_txt'] = sanitize_text_field($input['transform_rotation_sub_txt']); }
    if (isset($input['transform_origin_sub_txt'])) { $settings['transform_origin_sub_txt'] = sanitize_text_field($input['transform_origin_sub_txt']); }
    if (isset($input['split_type_sub_txt'])) { $settings['split_type_sub_txt'] = sanitize_text_field($input['split_type_sub_txt']); }
    if (isset($input['text_trigger_sub_txt'])) { $settings['text_trigger_sub_txt'] = sanitize_text_field($input['text_trigger_sub_txt']); }
    if (isset($input['tp_scrub_sub_txt'])) { $settings['tp_scrub_sub_txt'] = sanitize_text_field($input['tp_scrub_sub_txt']); }
    if (isset($input['sub_animation_controls'])) { $settings['sub_animation_controls'] = sanitize_text_field($input['sub_animation_controls']); }
    if (isset($input['text_duration_sub_txt'])) { $settings['text_duration_sub_txt'] = sanitize_text_field($input['text_duration_sub_txt']); }
    if (isset($input['text_delay_sub_txt'])) { $settings['text_delay_sub_txt'] = sanitize_text_field($input['text_delay_sub_txt']); }
    if (isset($input['text_stagger_sub_txt'])) { $settings['text_stagger_sub_txt'] = sanitize_text_field($input['text_stagger_sub_txt']); }
    if (isset($input['text_ease_sub_txt'])) { $settings['text_ease_sub_txt'] = sanitize_text_field($input['text_ease_sub_txt']); }
    if (isset($input['text_repeat_sub_txt'])) { $settings['text_repeat_sub_txt'] = sanitize_text_field($input['text_repeat_sub_txt']); }
    if (!empty($input['sep_img'])) { $settings['sep_img'] = ['id' => absint($input['sep_img'])]; }
    if (isset($input['input_margin'])) { $settings['input_margin'] = $input['input_margin']; }
    if (isset($input['double_color'])) { $settings['double_color'] = sanitize_text_field($input['double_color']); }
    if (isset($input['double_top'])) { $settings['double_top'] = sanitize_text_field($input['double_top']); }
    if (isset($input['double_bottom'])) { $settings['double_bottom'] = sanitize_text_field($input['double_bottom']); }
    if (isset($input['sep_clr'])) { $settings['sep_clr'] = sanitize_text_field($input['sep_clr']); }
    if (isset($input['sep_width'])) { $settings['sep_width'] = $input['sep_width']; }
    if (isset($input['dot_color'])) { $settings['dot_color'] = sanitize_text_field($input['dot_color']); }
    if (isset($input['sep_height'])) { $settings['sep_height'] = $input['sep_height']; }
    if (isset($input['top_clr_width'])) { $settings['top_clr_width'] = $input['top_clr_width']; }
    if (isset($input['top_clr_height'])) { $settings['top_clr_height'] = $input['top_clr_height']; }
    if (isset($input['top_clr'])) { $settings['top_clr'] = sanitize_text_field($input['top_clr']); }
    if (isset($input['title_sep_spacing'])) { $settings['title_sep_spacing'] = $input['title_sep_spacing']; }
    if (isset($input['title_h'])) { $settings['title_h'] = sanitize_text_field($input['title_h']); }
    if (isset($input['title_link'])) { $settings['title_link'] = $input['title_link']; }
    if (isset($input['s_maintitle_pg'])) { $settings['s_maintitle_pg'] = $input['s_maintitle_pg']; }
    if (isset($input['title_color'])) { $settings['title_color'] = sanitize_text_field($input['title_color']); }
    if (isset($input['title_solid_color'])) { $settings['title_solid_color'] = sanitize_text_field($input['title_solid_color']); }
    if (isset($input['title_gradient_color1'])) { $settings['title_gradient_color1'] = sanitize_text_field($input['title_gradient_color1']); }
    if (isset($input['title_gradient_color1_control'])) { $settings['title_gradient_color1_control'] = $input['title_gradient_color1_control']; }
    if (isset($input['title_gradient_color2'])) { $settings['title_gradient_color2'] = sanitize_text_field($input['title_gradient_color2']); }
    if (isset($input['title_gradient_color2_control'])) { $settings['title_gradient_color2_control'] = $input['title_gradient_color2_control']; }
    if (isset($input['title_gradient_style'])) { $settings['title_gradient_style'] = sanitize_text_field($input['title_gradient_style']); }
    if (isset($input['title_gradient_angle'])) { $settings['title_gradient_angle'] = $input['title_gradient_angle']; }
    if (isset($input['title_gradient_position'])) { $settings['title_gradient_position'] = sanitize_text_field($input['title_gradient_position']); }
    if (isset($input['title_hover_color'])) { $settings['title_hover_color'] = sanitize_text_field($input['title_hover_color']); }
    if (isset($input['special_effect'])) { $settings['special_effect'] = sanitize_text_field($input['special_effect']); }
    if (isset($input['special_effect_options'])) { $settings['special_effect_options'] = sanitize_text_field($input['special_effect_options']); }
    if (isset($input['subtitle_sep_spacing'])) { $settings['subtitle_sep_spacing'] = $input['subtitle_sep_spacing']; }
    if (isset($input['sub_title_tag'])) { $settings['sub_title_tag'] = sanitize_text_field($input['sub_title_tag']); }
    if (isset($input['s_subtitle_pg'])) { $settings['s_subtitle_pg'] = $input['s_subtitle_pg']; }
    if (isset($input['sub_title_color'])) { $settings['sub_title_color'] = sanitize_text_field($input['sub_title_color']); }
    if (isset($input['sub_title_solid_color'])) { $settings['sub_title_solid_color'] = sanitize_text_field($input['sub_title_solid_color']); }
    if (isset($input['sub_title_gradient_color1'])) { $settings['sub_title_gradient_color1'] = sanitize_text_field($input['sub_title_gradient_color1']); }
    if (isset($input['sub_title_gradient_color1_control'])) { $settings['sub_title_gradient_color1_control'] = $input['sub_title_gradient_color1_control']; }
    if (isset($input['sub_title_gradient_color2'])) { $settings['sub_title_gradient_color2'] = sanitize_text_field($input['sub_title_gradient_color2']); }
    if (isset($input['sub_title_gradient_color2_control'])) { $settings['sub_title_gradient_color2_control'] = $input['sub_title_gradient_color2_control']; }
    if (isset($input['sub_title_gradient_style'])) { $settings['sub_title_gradient_style'] = sanitize_text_field($input['sub_title_gradient_style']); }
    if (isset($input['sub_title_gradient_angle'])) { $settings['sub_title_gradient_angle'] = $input['sub_title_gradient_angle']; }
    if (isset($input['sub_title_gradient_position'])) { $settings['sub_title_gradient_position'] = sanitize_text_field($input['sub_title_gradient_position']); }
    if (isset($input['sub_title_hover_color'])) { $settings['sub_title_hover_color'] = sanitize_text_field($input['sub_title_hover_color']); }
    if (isset($input['ex_title_color'])) { $settings['ex_title_color'] = sanitize_text_field($input['ex_title_color']); }
    if (isset($input['ex_title_solid_color'])) { $settings['ex_title_solid_color'] = sanitize_text_field($input['ex_title_solid_color']); }
    if (isset($input['ex_title_gradient_color1'])) { $settings['ex_title_gradient_color1'] = sanitize_text_field($input['ex_title_gradient_color1']); }
    if (isset($input['ex_title_gradient_color1_control'])) { $settings['ex_title_gradient_color1_control'] = $input['ex_title_gradient_color1_control']; }
    if (isset($input['ex_title_gradient_color2'])) { $settings['ex_title_gradient_color2'] = sanitize_text_field($input['ex_title_gradient_color2']); }
    if (isset($input['ex_title_gradient_color2_control'])) { $settings['ex_title_gradient_color2_control'] = $input['ex_title_gradient_color2_control']; }
    if (isset($input['ex_title_gradient_style'])) { $settings['ex_title_gradient_style'] = sanitize_text_field($input['ex_title_gradient_style']); }
    if (isset($input['ex_title_gradient_angle'])) { $settings['ex_title_gradient_angle'] = $input['ex_title_gradient_angle']; }
    if (isset($input['ex_title_gradient_position'])) { $settings['ex_title_gradient_position'] = sanitize_text_field($input['ex_title_gradient_position']); }
    if (isset($input['ex_title_hover_color'])) { $settings['ex_title_hover_color'] = sanitize_text_field($input['ex_title_hover_color']); }
    if (isset($input['position'])) { $settings['position'] = sanitize_text_field($input['position']); }
    if (isset($input['mobile_center_align'])) { $settings['mobile_center_align'] = sanitize_text_field($input['mobile_center_align']); }
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
