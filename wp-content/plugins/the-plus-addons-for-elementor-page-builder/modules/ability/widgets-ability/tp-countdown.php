<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-countdown', [
    'label' => __('Countdown', 'tpebl'),
    'description' => __('Adds the The Plus "Countdown" widget (tp-countdown) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => ['type' => 'object', 'properties' => [
        'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
        'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
        'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'CDType' => ['type' => 'string', 'description' => 'Countdown Setup', 'enum' => ['normal', 'numbers', 'scarcity']],
        'tab_content_options1' => ['type' => 'string', 'description' => 'tab_content_options1'],
        'CDstyle' => ['type' => 'string', 'description' => 'Countdown Style', 'enum' => ['CDType', 'columns', 'style-1', 'style-2', 'style-3']],
        'counting_timer' => ['type' => 'string', 'description' => 'Launch Date'],
        'inline_style' => ['type' => 'string', 'description' => 'inline_style', 'enum' => ['yes', 'no']],
        'text_days' => ['type' => 'string', 'description' => 'Days Section Text'],
        'text_hours' => ['type' => 'string', 'description' => 'Hours Section Text'],
        'text_minutes' => ['type' => 'string', 'description' => 'Minutes Section Text'],
        'text_seconds' => ['type' => 'string', 'description' => 'Seconds Section Text'],
        'expirytype' => ['type' => 'string', 'description' => 'After Expiry Action', 'enum' => ['yes', 'no']],
        'expirytype_pro' => ['type' => 'string', 'description' => 'expirytype_pro'],
        'fliptheme' => ['type' => 'string', 'description' => 'Theme Color', 'enum' => ['CDType', 'conditions', 'dark', 'light', 'mix', 'name', 'operator', 'relation', 'terms', 'value']],
        'style_extra' => ['type' => 'string', 'description' => 'style_extra'],
        'countdownExpiry' => ['type' => 'string', 'description' => 'Select Action', 'enum' => ['conditions', 'name', 'none', 'operator', 'redirect', 'relation', 'showmsg', 'showtemp', 'terms', 'value']],
        'countdownExpiry_pro' => ['type' => 'string', 'description' => 'countdownExpiry_pro'],
        'cd_classbased' => ['type' => 'string', 'description' => 'cd_classbased', 'enum' => ['yes', 'no']],
        'cd_classbasedPro' => ['type' => 'string', 'description' => 'cd_classbasedPro'],
        'counter_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'counter_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'number_text_color' => ['type' => 'string', 'description' => 'Counter Font Color (Color Hex/RGBA)'],
        'days_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'days_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'hours_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'hours_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'minutes_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'minutes_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'seconds_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'seconds_border_color' => ['type' => 'string', 'description' => 'Border Color (Color Hex/RGBA)'],
        'count_border_style' => ['type' => 'string', 'description' => 'Border Style', 'enum' => ['dashed', 'dotted', 'groove', 'none', 'solid', '{{WRAPPER}} .pt_plus_countdown li']],
        'count_border_width' => ['type' => 'object', 'description' => 'Border Width (Dimensions Object)'],
        'count_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'strokewd1' => ['type' => 'string', 'description' => 'Stroke Width'],
        'trailwd' => ['type' => 'string', 'description' => 'Trail Width'],
        's3daynumberncr' => ['type' => 'string', 'description' => 'Counter Number Color (Color Hex/RGBA)'],
        's3daytextncr' => ['type' => 'string', 'description' => 'Counter Text Color (Color Hex/RGBA)'],
        's3daystrokencr' => ['type' => 'string', 'description' => 'Counter Stroke Color (Color Hex/RGBA)'],
        's3daystrailnncr' => ['type' => 'string', 'description' => 'Counter Trail Color (Color Hex/RGBA)'],
        's3hoursnumberncr' => ['type' => 'string', 'description' => 'Counter Number Color (Color Hex/RGBA)'],
        's3hourstextncr' => ['type' => 'string', 'description' => 'Counter Text Color (Color Hex/RGBA)'],
        's3hourstrokencr' => ['type' => 'string', 'description' => 'Counter Stroke Color (Color Hex/RGBA)'],
        's3hourstrailncr' => ['type' => 'string', 'description' => 'Counter Trail Color (Color Hex/RGBA)'],
        's3minutnumberncr' => ['type' => 'string', 'description' => 'Counter Number Color (Color Hex/RGBA)'],
        's3minuttextncr' => ['type' => 'string', 'description' => 'Counter Text Color (Color Hex/RGBA)'],
        's3miutstrokencr' => ['type' => 'string', 'description' => 'Counter Stroke Color (Color Hex/RGBA)'],
        's3miutstrailncr' => ['type' => 'string', 'description' => 'Counter Trail Color (Color Hex/RGBA)'],
        's3secondnumberncr' => ['type' => 'string', 'description' => 'Counter Number Color (Color Hex/RGBA)'],
        's3secondtextncr' => ['type' => 'string', 'description' => 'Counter Text Color (Color Hex/RGBA)'],
        's3secondtrokencr' => ['type' => 'string', 'description' => 'Counter Stroke Color (Color Hex/RGBA)'],
        's3secondstrailncr' => ['type' => 'string', 'description' => 'Counter Trail Color (Color Hex/RGBA)'],
        's3numberhcr' => ['type' => 'string', 'description' => 'Number Color (Color Hex/RGBA)'],
        's3texthcr' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        's3trokehcr' => ['type' => 'string', 'description' => 'Stroke Color (Color Hex/RGBA)'],
        's3strailhcr' => ['type' => 'string', 'description' => 'Trail Color (Color Hex/RGBA)'],
        's2daytextdcr' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        's2daytextdbrs' => ['type' => 'object', 'description' => 's2daytextdbrs (Dimensions Object)'],
        's2hoursnumberncr' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        's2daytexttbrs' => ['type' => 'object', 'description' => 's2daytexttbrs (Dimensions Object)'],
        's2minutesnumberncr' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        's2daytextmbrs' => ['type' => 'object', 'description' => 's2daytextmbrs (Dimensions Object)'],
        's2secondnumberncr' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        's2daytextsbrs' => ['type' => 'object', 'description' => 's2daytextsbrs (Dimensions Object)'],
        's2darktopncr' => ['type' => 'string', 'description' => 'Top Text Color (Color Hex/RGBA)'],
        's2darkbottomncr' => ['type' => 'string', 'description' => 'Bottom Text Color (Color Hex/RGBA)'],
        's2darktophcr' => ['type' => 'string', 'description' => 'Top Text Color (Color Hex/RGBA)'],
        's2darkbottomhcr' => ['type' => 'string', 'description' => 'Bottom Text Color (Color Hex/RGBA)'],
        'bgpad' => ['type' => 'object', 'description' => 'bgpad (Dimensions Object)'],
        'bgmar' => ['type' => 'object', 'description' => 'bgmar (Dimensions Object)'],
        'bgnbr' => ['type' => 'object', 'description' => 'bgnbr (Dimensions Object)'],
        'bghbr' => ['type' => 'object', 'description' => 'bghbr (Dimensions Object)'],
        'animation_effects' => ['type' => 'string', 'description' => 'Choose Animation Effect'],
        'animation_delay' => ['type' => 'object', 'description' => 'Animation Delay (Slider/Size Object)'],
        'animation_duration_default' => ['type' => 'string', 'description' => 'Animation Duration', 'enum' => ['yes', 'no']],
        'animate_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'animation_out_effects' => ['type' => 'string', 'description' => 'Out Animation Effect', 'enum' => ['animation_effects!']],
        'animation_out_delay' => ['type' => 'object', 'description' => 'Out Animation Delay (Slider/Size Object)'],
        'animation_out_duration_default' => ['type' => 'string', 'description' => 'Out Animation Duration', 'enum' => ['yes', 'no']],
        'animation_out_duration' => ['type' => 'object', 'description' => 'Duration Speed (Slider/Size Object)'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports evergreen temporal mapping, dynamic AJAX redirection logic, and responsive kinetic typography.']
        ],
        'required' => ['post_id', 'parent_id', 'counting_timer'], 'additionalProperties' => false],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_countdown_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_countdown_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_countdown_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_countdown_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-countdown';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Countdown widget is not registered.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['CDType'])) { $settings['CDType'] = sanitize_text_field($input['CDType']); }
    if (isset($input['tab_content_options1'])) { $settings['tab_content_options1'] = sanitize_text_field($input['tab_content_options1']); }
    if (isset($input['CDstyle'])) { $settings['CDstyle'] = sanitize_text_field($input['CDstyle']); }
    if (isset($input['counting_timer'])) { $settings['counting_timer'] = sanitize_text_field($input['counting_timer']); }
    if (isset($input['inline_style'])) { $settings['inline_style'] = sanitize_text_field($input['inline_style']); }
    if (isset($input['text_days'])) { $settings['text_days'] = sanitize_text_field($input['text_days']); }
    if (isset($input['text_hours'])) { $settings['text_hours'] = sanitize_text_field($input['text_hours']); }
    if (isset($input['text_minutes'])) { $settings['text_minutes'] = sanitize_text_field($input['text_minutes']); }
    if (isset($input['text_seconds'])) { $settings['text_seconds'] = sanitize_text_field($input['text_seconds']); }
    if (isset($input['expirytype'])) { $settings['expirytype'] = sanitize_text_field($input['expirytype']); }
    if (isset($input['expirytype_pro'])) { $settings['expirytype_pro'] = sanitize_text_field($input['expirytype_pro']); }
    if (isset($input['fliptheme'])) { $settings['fliptheme'] = sanitize_text_field($input['fliptheme']); }
    if (isset($input['style_extra'])) { $settings['style_extra'] = sanitize_text_field($input['style_extra']); }
    if (isset($input['countdownExpiry'])) { $settings['countdownExpiry'] = sanitize_text_field($input['countdownExpiry']); }
    if (isset($input['countdownExpiry_pro'])) { $settings['countdownExpiry_pro'] = sanitize_text_field($input['countdownExpiry_pro']); }
    if (isset($input['cd_classbased'])) { $settings['cd_classbased'] = sanitize_text_field($input['cd_classbased']); }
    if (isset($input['cd_classbasedPro'])) { $settings['cd_classbasedPro'] = sanitize_text_field($input['cd_classbasedPro']); }
    if (isset($input['counter_padding'])) { $settings['counter_padding'] = $input['counter_padding']; }
    if (isset($input['counter_margin'])) { $settings['counter_margin'] = $input['counter_margin']; }
    if (isset($input['number_text_color'])) { $settings['number_text_color'] = sanitize_text_field($input['number_text_color']); }
    if (isset($input['days_text_color'])) { $settings['days_text_color'] = sanitize_text_field($input['days_text_color']); }
    if (isset($input['days_border_color'])) { $settings['days_border_color'] = sanitize_text_field($input['days_border_color']); }
    if (isset($input['hours_text_color'])) { $settings['hours_text_color'] = sanitize_text_field($input['hours_text_color']); }
    if (isset($input['hours_border_color'])) { $settings['hours_border_color'] = sanitize_text_field($input['hours_border_color']); }
    if (isset($input['minutes_text_color'])) { $settings['minutes_text_color'] = sanitize_text_field($input['minutes_text_color']); }
    if (isset($input['minutes_border_color'])) { $settings['minutes_border_color'] = sanitize_text_field($input['minutes_border_color']); }
    if (isset($input['seconds_text_color'])) { $settings['seconds_text_color'] = sanitize_text_field($input['seconds_text_color']); }
    if (isset($input['seconds_border_color'])) { $settings['seconds_border_color'] = sanitize_text_field($input['seconds_border_color']); }
    if (isset($input['count_border_style'])) { $settings['count_border_style'] = sanitize_text_field($input['count_border_style']); }
    if (isset($input['count_border_width'])) { $settings['count_border_width'] = $input['count_border_width']; }
    if (isset($input['count_border_radius'])) { $settings['count_border_radius'] = $input['count_border_radius']; }
    if (isset($input['strokewd1'])) { $settings['strokewd1'] = sanitize_text_field($input['strokewd1']); }
    if (isset($input['trailwd'])) { $settings['trailwd'] = sanitize_text_field($input['trailwd']); }
    if (isset($input['s3daynumberncr'])) { $settings['s3daynumberncr'] = sanitize_text_field($input['s3daynumberncr']); }
    if (isset($input['s3daytextncr'])) { $settings['s3daytextncr'] = sanitize_text_field($input['s3daytextncr']); }
    if (isset($input['s3daystrokencr'])) { $settings['s3daystrokencr'] = sanitize_text_field($input['s3daystrokencr']); }
    if (isset($input['s3daystrailnncr'])) { $settings['s3daystrailnncr'] = sanitize_text_field($input['s3daystrailnncr']); }
    if (isset($input['s3hoursnumberncr'])) { $settings['s3hoursnumberncr'] = sanitize_text_field($input['s3hoursnumberncr']); }
    if (isset($input['s3hourstextncr'])) { $settings['s3hourstextncr'] = sanitize_text_field($input['s3hourstextncr']); }
    if (isset($input['s3hourstrokencr'])) { $settings['s3hourstrokencr'] = sanitize_text_field($input['s3hourstrokencr']); }
    if (isset($input['s3hourstrailncr'])) { $settings['s3hourstrailncr'] = sanitize_text_field($input['s3hourstrailncr']); }
    if (isset($input['s3minutnumberncr'])) { $settings['s3minutnumberncr'] = sanitize_text_field($input['s3minutnumberncr']); }
    if (isset($input['s3minuttextncr'])) { $settings['s3minuttextncr'] = sanitize_text_field($input['s3minuttextncr']); }
    if (isset($input['s3miutstrokencr'])) { $settings['s3miutstrokencr'] = sanitize_text_field($input['s3miutstrokencr']); }
    if (isset($input['s3miutstrailncr'])) { $settings['s3miutstrailncr'] = sanitize_text_field($input['s3miutstrailncr']); }
    if (isset($input['s3secondnumberncr'])) { $settings['s3secondnumberncr'] = sanitize_text_field($input['s3secondnumberncr']); }
    if (isset($input['s3secondtextncr'])) { $settings['s3secondtextncr'] = sanitize_text_field($input['s3secondtextncr']); }
    if (isset($input['s3secondtrokencr'])) { $settings['s3secondtrokencr'] = sanitize_text_field($input['s3secondtrokencr']); }
    if (isset($input['s3secondstrailncr'])) { $settings['s3secondstrailncr'] = sanitize_text_field($input['s3secondstrailncr']); }
    if (isset($input['s3numberhcr'])) { $settings['s3numberhcr'] = sanitize_text_field($input['s3numberhcr']); }
    if (isset($input['s3texthcr'])) { $settings['s3texthcr'] = sanitize_text_field($input['s3texthcr']); }
    if (isset($input['s3trokehcr'])) { $settings['s3trokehcr'] = sanitize_text_field($input['s3trokehcr']); }
    if (isset($input['s3strailhcr'])) { $settings['s3strailhcr'] = sanitize_text_field($input['s3strailhcr']); }
    if (isset($input['s2daytextdcr'])) { $settings['s2daytextdcr'] = sanitize_text_field($input['s2daytextdcr']); }
    if (isset($input['s2daytextdbrs'])) { $settings['s2daytextdbrs'] = $input['s2daytextdbrs']; }
    if (isset($input['s2hoursnumberncr'])) { $settings['s2hoursnumberncr'] = sanitize_text_field($input['s2hoursnumberncr']); }
    if (isset($input['s2daytexttbrs'])) { $settings['s2daytexttbrs'] = $input['s2daytexttbrs']; }
    if (isset($input['s2minutesnumberncr'])) { $settings['s2minutesnumberncr'] = sanitize_text_field($input['s2minutesnumberncr']); }
    if (isset($input['s2daytextmbrs'])) { $settings['s2daytextmbrs'] = $input['s2daytextmbrs']; }
    if (isset($input['s2secondnumberncr'])) { $settings['s2secondnumberncr'] = sanitize_text_field($input['s2secondnumberncr']); }
    if (isset($input['s2daytextsbrs'])) { $settings['s2daytextsbrs'] = $input['s2daytextsbrs']; }
    if (isset($input['s2darktopncr'])) { $settings['s2darktopncr'] = sanitize_text_field($input['s2darktopncr']); }
    if (isset($input['s2darkbottomncr'])) { $settings['s2darkbottomncr'] = sanitize_text_field($input['s2darkbottomncr']); }
    if (isset($input['s2darktophcr'])) { $settings['s2darktophcr'] = sanitize_text_field($input['s2darktophcr']); }
    if (isset($input['s2darkbottomhcr'])) { $settings['s2darkbottomhcr'] = sanitize_text_field($input['s2darkbottomhcr']); }
    if (isset($input['bgpad'])) { $settings['bgpad'] = $input['bgpad']; }
    if (isset($input['bgmar'])) { $settings['bgmar'] = $input['bgmar']; }
    if (isset($input['bgnbr'])) { $settings['bgnbr'] = $input['bgnbr']; }
    if (isset($input['bghbr'])) { $settings['bghbr'] = $input['bghbr']; }
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
