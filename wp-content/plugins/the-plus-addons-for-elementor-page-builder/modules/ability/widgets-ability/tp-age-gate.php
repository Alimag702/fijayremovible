<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-age-gate', [
    'label' => __('Age Gate', 'tpebl'),
    'description' => __('Adds the The Plus "Age Gate" widget (tp-age-gate) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
            'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
            'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'age_verify_method' => ['type' => 'string', 'description' => 'Method', 'enum' => ['columns', 'method-1', 'method-2', 'method-3']],
        'backend_preview' => ['type' => 'string', 'description' => 'Backend Visibility', 'enum' => ['yes', 'no']],
        'age_gate_align' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'devices', 'flex-end', 'flex-start', 'icon', '{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-inner-wrapper .tp-agegate-boxes,
					{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-inner-wrapper .tp-agegate-boxes *:not(.tp-age-btn-ex)']],
        'age_icon_popover_toggle' => ['type' => 'string', 'description' => 'Logo', 'enum' => ['yes', 'no']],
        'age_icon_img_type' => ['type' => 'string', 'description' => 'Logo', 'enum' => ['yes', 'no']],
        'age_head_img' => ['type' => 'integer', 'description' => 'Icon library (Image ID)'],
        'age_title_popover_toggle' => ['type' => 'string', 'description' => 'Title', 'enum' => ['yes', 'no']],
        'age_gate_title' => ['type' => 'string', 'description' => 'Title', 'enum' => ['yes', 'no']],
        'age_gate_title_input' => ['type' => 'string', 'description' => 'Label'],
        'age_gate_description' => ['type' => 'string', 'description' => 'Text Description', 'enum' => ['yes', 'no']],
        'age_gate_description_input' => ['type' => 'string', 'description' => 'Type'],
        'age_gate_description_inputwo' => ['type' => 'string', 'description' => 'Type'],
        'age_gate_description_inputhree' => ['type' => 'string', 'description' => 'Type'],
        'chkinput_text' => ['type' => 'string', 'description' => 'Confirm Box'],
        'age_extra_info_switch' => ['type' => 'string', 'description' => 'Extra Content', 'enum' => ['yes', 'no']],
        'age_gate_align_txtera' => ['type' => 'string', 'description' => 'Alignment', 'enum' => ['center', 'icon', 'left', 'right', '{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-inner-wrapper .tp-agegate-boxes,
					{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-inner-wrapper .tp-agegate-boxes *:not(.tp-age-btn-ex)']],
        'age_extra_info' => ['type' => 'string', 'description' => 'Type'],
        'button_text' => ['type' => 'string', 'description' => 'Text'],
        'icon_action' => ['type' => 'string', 'description' => 'Icon', 'enum' => ['yes', 'no']],
        'icon_position' => ['type' => 'string', 'description' => 'Icon Position', 'enum' => ['age_icon_postfix', 'age_icon_prefix', 'icon_action']],
        'button_icon' => ['type' => 'string', 'description' => 'Icon library'],
        'second_button_text' => ['type' => 'string', 'description' => 'Text'],
        'second_icon_action' => ['type' => 'string', 'description' => 'Icon', 'enum' => ['yes', 'no']],
        'second_icon_position' => ['type' => 'string', 'description' => 'Icon Position', 'enum' => ['age_scnd_icon_postfix', 'age_scnd_icon_prefix', 'age_verify_method', 'second_icon_action']],
        'second_button_icon' => ['type' => 'string', 'description' => 'Icon'],
        'birthyears' => ['type' => 'string', 'description' => 'Minimum Age Limit'],
        'age_cookies' => ['type' => 'string', 'description' => 'Cookies', 'enum' => ['yes', 'no']],
        'age_cookies_days' => ['type' => 'string', 'description' => 'Cookies Expiry Time'],
        'db_max_width' => ['type' => 'object', 'description' => 'Form Content Max-width (Slider/Size Object)'],
        'age_sec_bg_image_switch' => ['type' => 'string', 'description' => 'Background Image', 'enum' => ['yes', 'no']],
        'age_sec_bg_image' => ['type' => 'integer', 'description' => 'Background (Image ID)'],
        'age_bgImg_pos' => ['type' => 'string', 'description' => 'Background Position', 'enum' => ['age_sec_bg_image_switch', '{{WRAPPER}} .tp-agegate-wrapper']],
        'age_sec_bg_overlay_color' => ['type' => 'string', 'description' => 'Overlay Color (Color Hex/RGBA)'],
        'age_side_image_show' => ['type' => 'string', 'description' => 'Right Side Image', 'enum' => ['yes', 'no']],
        'age_side_img' => ['type' => 'integer', 'description' => 'Image (Image ID)'],
        'age_rightImg_pos' => ['type' => 'string', 'description' => 'Right Image Position', 'enum' => ['age_side_image_show', '{{WRAPPER}} .tp-agegate-boxes.tp-equ-width-50']],
        'age_gate_wrong_message' => ['type' => 'string', 'description' => 'Error Message'],
        'logo_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'logo_size' => ['type' => 'object', 'description' => 'Logo Size (Slider/Size Object)'],
        'logo_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'title_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'title_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'titleNmlColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'titleHvrColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'desc_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'desc_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'descNmlColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'descNmlBRadius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'descHvrColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'descHvrBRadius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'chktxt_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'chktxt_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'chktxtNmlColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'chktxtHvrColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'inputdate_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'inputdate_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'inputdate_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'inputdate_bradius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'inputdate_color_h' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'inputdate_bradius_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'fbtn_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'fbtn_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'fbtn_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'fbtn_bradius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'fbtn_color_h' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'fbtn_bradius_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'tgl_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'tgl_icn_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'tgl_icn_space' => ['type' => 'object', 'description' => 'Offset (Slider/Size Object)'],
        'tgl_icn_space_left' => ['type' => 'object', 'description' => 'Offset (Slider/Size Object)'],
        'tglNormalColor' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'tglHoverColor' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'sbtn_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'sbtn_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'sbtn_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'sbtn_bradius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'sbtn_color_h' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'sbtn_bradius_h' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'scndBtn_icn_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'scndBtn_icn_space' => ['type' => 'object', 'description' => 'Offset (Slider/Size Object)'],
        'scndBtn_icn_space_left' => ['type' => 'object', 'description' => 'Offset (Slider/Size Object)'],
        'scndBtn_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'scndBtnNormalColor' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'scndBtnHoverColor' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'info_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'info_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'einfo_Size' => ['type' => 'object', 'description' => 'Text Size (Slider/Size Object)'],
        'einfoNmlColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'einfoHvrColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'msg_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'msg_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'msgNmlColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'msgNmlBRadius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'msgHvrColor' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'msgHvrBRadius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'box_position' => ['type' => 'string', 'description' => 'Box Position', 'enum' => ['yes', 'no']],
        'box_left_auto' => ['type' => 'object', 'description' => 'Left (Auto)', 'enum' => ['yes', 'no']],
        'box_pos_xposition' => ['type' => 'object', 'description' => 'Left (Slider/Size Object)'],
        'box_right_auto' => ['type' => 'object', 'description' => 'Right (Auto)', 'enum' => ['yes', 'no']],
        'box_pos_rightposition' => ['type' => 'object', 'description' => 'Right (Slider/Size Object)'],
        'box_width' => ['type' => 'object', 'description' => 'Box Width (Slider/Size Object)'],
        'box_height' => ['type' => 'object', 'description' => 'Box Height (Slider/Size Object)'],
        'box_bradiusNml' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'box_bradiusHvr' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
            'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports Cookie-based persistence orchestration, Lottie animation triggers, and responsive interactive geometry.']
        ],
        'required' => ['post_id', 'parent_id'],
        'additionalProperties' => false,
    ],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_age_gate_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_age_gate_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_age_gate_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_age_gate_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-age-gate';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Age Gate widget is not registered on this site.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['age_verify_method'])) { $settings['age_verify_method'] = sanitize_text_field($input['age_verify_method']); }
    if (isset($input['backend_preview'])) { $settings['backend_preview'] = sanitize_text_field($input['backend_preview']); }
    if (isset($input['age_gate_align'])) { $settings['age_gate_align'] = $input['age_gate_align']; }
    if (isset($input['age_icon_popover_toggle'])) { $settings['age_icon_popover_toggle'] = sanitize_text_field($input['age_icon_popover_toggle']); }
    if (isset($input['age_icon_img_type'])) { $settings['age_icon_img_type'] = sanitize_text_field($input['age_icon_img_type']); }
    if (!empty($input['age_head_img'])) { $settings['age_head_img'] = ['id' => absint($input['age_head_img'])]; }
    if (isset($input['age_title_popover_toggle'])) { $settings['age_title_popover_toggle'] = sanitize_text_field($input['age_title_popover_toggle']); }
    if (isset($input['age_gate_title'])) { $settings['age_gate_title'] = sanitize_text_field($input['age_gate_title']); }
    if (isset($input['age_gate_title_input'])) { $settings['age_gate_title_input'] = sanitize_text_field($input['age_gate_title_input']); }
    if (isset($input['age_gate_description'])) { $settings['age_gate_description'] = sanitize_text_field($input['age_gate_description']); }
    if (isset($input['age_gate_description_input'])) { $settings['age_gate_description_input'] = sanitize_text_field($input['age_gate_description_input']); }
    if (isset($input['age_gate_description_inputwo'])) { $settings['age_gate_description_inputwo'] = sanitize_text_field($input['age_gate_description_inputwo']); }
    if (isset($input['age_gate_description_inputhree'])) { $settings['age_gate_description_inputhree'] = sanitize_text_field($input['age_gate_description_inputhree']); }
    if (isset($input['chkinput_text'])) { $settings['chkinput_text'] = sanitize_text_field($input['chkinput_text']); }
    if (isset($input['age_extra_info_switch'])) { $settings['age_extra_info_switch'] = sanitize_text_field($input['age_extra_info_switch']); }
    if (isset($input['age_gate_align_txtera'])) { $settings['age_gate_align_txtera'] = sanitize_text_field($input['age_gate_align_txtera']); }
    if (isset($input['age_extra_info'])) { $settings['age_extra_info'] = sanitize_text_field($input['age_extra_info']); }
    if (isset($input['button_text'])) { $settings['button_text'] = sanitize_text_field($input['button_text']); }
    if (isset($input['icon_action'])) { $settings['icon_action'] = sanitize_text_field($input['icon_action']); }
    if (isset($input['icon_position'])) { $settings['icon_position'] = sanitize_text_field($input['icon_position']); }
    if (isset($input['button_icon'])) { $settings['button_icon'] = sanitize_text_field($input['button_icon']); }
    if (isset($input['second_button_text'])) { $settings['second_button_text'] = sanitize_text_field($input['second_button_text']); }
    if (isset($input['second_icon_action'])) { $settings['second_icon_action'] = sanitize_text_field($input['second_icon_action']); }
    if (isset($input['second_icon_position'])) { $settings['second_icon_position'] = sanitize_text_field($input['second_icon_position']); }
    if (isset($input['second_button_icon'])) { $settings['second_button_icon'] = sanitize_text_field($input['second_button_icon']); }
    if (isset($input['birthyears'])) { $settings['birthyears'] = sanitize_text_field($input['birthyears']); }
    if (isset($input['age_cookies'])) { $settings['age_cookies'] = sanitize_text_field($input['age_cookies']); }
    if (isset($input['age_cookies_days'])) { $settings['age_cookies_days'] = sanitize_text_field($input['age_cookies_days']); }
    if (isset($input['db_max_width'])) { $settings['db_max_width'] = $input['db_max_width']; }
    if (isset($input['age_sec_bg_image_switch'])) { $settings['age_sec_bg_image_switch'] = sanitize_text_field($input['age_sec_bg_image_switch']); }
    if (!empty($input['age_sec_bg_image'])) { $settings['age_sec_bg_image'] = ['id' => absint($input['age_sec_bg_image'])]; }
    if (isset($input['age_bgImg_pos'])) { $settings['age_bgImg_pos'] = sanitize_text_field($input['age_bgImg_pos']); }
    if (isset($input['age_sec_bg_overlay_color'])) { $settings['age_sec_bg_overlay_color'] = sanitize_text_field($input['age_sec_bg_overlay_color']); }
    if (isset($input['age_side_image_show'])) { $settings['age_side_image_show'] = sanitize_text_field($input['age_side_image_show']); }
    if (!empty($input['age_side_img'])) { $settings['age_side_img'] = ['id' => absint($input['age_side_img'])]; }
    if (isset($input['age_rightImg_pos'])) { $settings['age_rightImg_pos'] = sanitize_text_field($input['age_rightImg_pos']); }
    if (isset($input['age_gate_wrong_message'])) { $settings['age_gate_wrong_message'] = sanitize_text_field($input['age_gate_wrong_message']); }
    if (isset($input['logo_margin'])) { $settings['logo_margin'] = $input['logo_margin']; }
    if (isset($input['logo_size'])) { $settings['logo_size'] = $input['logo_size']; }
    if (isset($input['logo_border_radius'])) { $settings['logo_border_radius'] = $input['logo_border_radius']; }
    if (isset($input['title_padding'])) { $settings['title_padding'] = $input['title_padding']; }
    if (isset($input['title_margin'])) { $settings['title_margin'] = $input['title_margin']; }
    if (isset($input['titleNmlColor'])) { $settings['titleNmlColor'] = sanitize_text_field($input['titleNmlColor']); }
    if (isset($input['titleHvrColor'])) { $settings['titleHvrColor'] = sanitize_text_field($input['titleHvrColor']); }
    if (isset($input['desc_padding'])) { $settings['desc_padding'] = $input['desc_padding']; }
    if (isset($input['desc_margin'])) { $settings['desc_margin'] = $input['desc_margin']; }
    if (isset($input['descNmlColor'])) { $settings['descNmlColor'] = sanitize_text_field($input['descNmlColor']); }
    if (isset($input['descNmlBRadius'])) { $settings['descNmlBRadius'] = $input['descNmlBRadius']; }
    if (isset($input['descHvrColor'])) { $settings['descHvrColor'] = sanitize_text_field($input['descHvrColor']); }
    if (isset($input['descHvrBRadius'])) { $settings['descHvrBRadius'] = $input['descHvrBRadius']; }
    if (isset($input['chktxt_padding'])) { $settings['chktxt_padding'] = $input['chktxt_padding']; }
    if (isset($input['chktxt_margin'])) { $settings['chktxt_margin'] = $input['chktxt_margin']; }
    if (isset($input['chktxtNmlColor'])) { $settings['chktxtNmlColor'] = sanitize_text_field($input['chktxtNmlColor']); }
    if (isset($input['chktxtHvrColor'])) { $settings['chktxtHvrColor'] = sanitize_text_field($input['chktxtHvrColor']); }
    if (isset($input['inputdate_margin'])) { $settings['inputdate_margin'] = $input['inputdate_margin']; }
    if (isset($input['inputdate_padding'])) { $settings['inputdate_padding'] = $input['inputdate_padding']; }
    if (isset($input['inputdate_color'])) { $settings['inputdate_color'] = sanitize_text_field($input['inputdate_color']); }
    if (isset($input['inputdate_bradius'])) { $settings['inputdate_bradius'] = $input['inputdate_bradius']; }
    if (isset($input['inputdate_color_h'])) { $settings['inputdate_color_h'] = sanitize_text_field($input['inputdate_color_h']); }
    if (isset($input['inputdate_bradius_h'])) { $settings['inputdate_bradius_h'] = $input['inputdate_bradius_h']; }
    if (isset($input['fbtn_padding'])) { $settings['fbtn_padding'] = $input['fbtn_padding']; }
    if (isset($input['fbtn_margin'])) { $settings['fbtn_margin'] = $input['fbtn_margin']; }
    if (isset($input['fbtn_color'])) { $settings['fbtn_color'] = sanitize_text_field($input['fbtn_color']); }
    if (isset($input['fbtn_bradius'])) { $settings['fbtn_bradius'] = $input['fbtn_bradius']; }
    if (isset($input['fbtn_color_h'])) { $settings['fbtn_color_h'] = sanitize_text_field($input['fbtn_color_h']); }
    if (isset($input['fbtn_bradius_h'])) { $settings['fbtn_bradius_h'] = $input['fbtn_bradius_h']; }
    if (isset($input['tgl_margin'])) { $settings['tgl_margin'] = $input['tgl_margin']; }
    if (isset($input['tgl_icn_size'])) { $settings['tgl_icn_size'] = $input['tgl_icn_size']; }
    if (isset($input['tgl_icn_space'])) { $settings['tgl_icn_space'] = $input['tgl_icn_space']; }
    if (isset($input['tgl_icn_space_left'])) { $settings['tgl_icn_space_left'] = $input['tgl_icn_space_left']; }
    if (isset($input['tglNormalColor'])) { $settings['tglNormalColor'] = sanitize_text_field($input['tglNormalColor']); }
    if (isset($input['tglHoverColor'])) { $settings['tglHoverColor'] = sanitize_text_field($input['tglHoverColor']); }
    if (isset($input['sbtn_padding'])) { $settings['sbtn_padding'] = $input['sbtn_padding']; }
    if (isset($input['sbtn_margin'])) { $settings['sbtn_margin'] = $input['sbtn_margin']; }
    if (isset($input['sbtn_color'])) { $settings['sbtn_color'] = sanitize_text_field($input['sbtn_color']); }
    if (isset($input['sbtn_bradius'])) { $settings['sbtn_bradius'] = $input['sbtn_bradius']; }
    if (isset($input['sbtn_color_h'])) { $settings['sbtn_color_h'] = sanitize_text_field($input['sbtn_color_h']); }
    if (isset($input['sbtn_bradius_h'])) { $settings['sbtn_bradius_h'] = $input['sbtn_bradius_h']; }
    if (isset($input['scndBtn_icn_size'])) { $settings['scndBtn_icn_size'] = $input['scndBtn_icn_size']; }
    if (isset($input['scndBtn_icn_space'])) { $settings['scndBtn_icn_space'] = $input['scndBtn_icn_space']; }
    if (isset($input['scndBtn_icn_space_left'])) { $settings['scndBtn_icn_space_left'] = $input['scndBtn_icn_space_left']; }
    if (isset($input['scndBtn_margin'])) { $settings['scndBtn_margin'] = $input['scndBtn_margin']; }
    if (isset($input['scndBtnNormalColor'])) { $settings['scndBtnNormalColor'] = sanitize_text_field($input['scndBtnNormalColor']); }
    if (isset($input['scndBtnHoverColor'])) { $settings['scndBtnHoverColor'] = sanitize_text_field($input['scndBtnHoverColor']); }
    if (isset($input['info_padding'])) { $settings['info_padding'] = $input['info_padding']; }
    if (isset($input['info_margin'])) { $settings['info_margin'] = $input['info_margin']; }
    if (isset($input['einfo_Size'])) { $settings['einfo_Size'] = $input['einfo_Size']; }
    if (isset($input['einfoNmlColor'])) { $settings['einfoNmlColor'] = sanitize_text_field($input['einfoNmlColor']); }
    if (isset($input['einfoHvrColor'])) { $settings['einfoHvrColor'] = sanitize_text_field($input['einfoHvrColor']); }
    if (isset($input['msg_padding'])) { $settings['msg_padding'] = $input['msg_padding']; }
    if (isset($input['msg_margin'])) { $settings['msg_margin'] = $input['msg_margin']; }
    if (isset($input['msgNmlColor'])) { $settings['msgNmlColor'] = sanitize_text_field($input['msgNmlColor']); }
    if (isset($input['msgNmlBRadius'])) { $settings['msgNmlBRadius'] = $input['msgNmlBRadius']; }
    if (isset($input['msgHvrColor'])) { $settings['msgHvrColor'] = sanitize_text_field($input['msgHvrColor']); }
    if (isset($input['msgHvrBRadius'])) { $settings['msgHvrBRadius'] = $input['msgHvrBRadius']; }
    if (isset($input['box_position'])) { $settings['box_position'] = sanitize_text_field($input['box_position']); }
    if (isset($input['box_left_auto'])) { $settings['box_left_auto'] = $input['box_left_auto']; }
    if (isset($input['box_pos_xposition'])) { $settings['box_pos_xposition'] = $input['box_pos_xposition']; }
    if (isset($input['box_right_auto'])) { $settings['box_right_auto'] = $input['box_right_auto']; }
    if (isset($input['box_pos_rightposition'])) { $settings['box_pos_rightposition'] = $input['box_pos_rightposition']; }
    if (isset($input['box_width'])) { $settings['box_width'] = $input['box_width']; }
    if (isset($input['box_height'])) { $settings['box_height'] = $input['box_height']; }
    if (isset($input['box_bradiusNml'])) { $settings['box_bradiusNml'] = $input['box_bradiusNml']; }
    if (isset($input['box_bradiusHvr'])) { $settings['box_bradiusHvr'] = $input['box_bradiusHvr']; }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
