<?php
declare(strict_types=1);
if (!defined('ABSPATH')) { exit; }

wp_register_ability('tpae/tpae-plus-form', [
    'label' => __('Plus Form', 'tpebl'),
    'description' => __('Adds the The Plus "Plus Form" widget (tp-plus-form) to an Elementor container.', 'tpebl'),
    'category' => 'tpae',
    'input_schema' => [
        'type' => 'object',
        'properties' => [
            'post_id' => ['type' => 'integer', 'description' => 'Elementor page/post ID'],
            'parent_id' => ['type' => 'string', 'description' => 'Target Elementor container ID'],
            'position' => ['type' => 'integer', 'description' => 'Insert position. Use -1 to append.', 'default' => -1],
        'form_title' => ['type' => 'string', 'description' => 'Form Name'],
        'form_fields' => ['type' => 'string', 'description' => 'Type', 'enum' => ['agree_to_terms', 'checkbox', 'cloudflare', 'date', 'dropdown', 'email', 'hidden', 'honeypot', 'number', 'phone_number', 'radio', 'recaptcha', 'text', 'textarea', 'time', 'url']],
        'field_label' => ['type' => 'string', 'description' => 'Label'],
        'dropdown_options' => ['type' => 'string', 'description' => 'Options'],
        'place_holder' => ['type' => 'string', 'description' => 'Placeholder'],
        'required' => ['type' => 'string', 'description' => 'Required', 'enum' => ['yes', 'no']],
        'autofill' => ['type' => 'string', 'description' => 'Autofill', 'enum' => ['yes', 'no']],
        'country_code_detection' => ['type' => 'string', 'description' => 'Country Code Detection', 'enum' => ['form_fields', 'ip']],
        'default_country_code' => ['type' => 'string', 'description' => 'Default Country Code'],
        'enable_link' => ['type' => 'string', 'description' => 'Enable Link', 'enum' => ['yes', 'no']],
        'link_label' => ['type' => 'string', 'description' => 'Link Label'],
        'terms_url' => ['type' => 'object', 'description' => 'URL'],
        'column_width' => ['type' => 'object', 'description' => 'Column Width (Slider/Size Object)'],
        'country_code_width' => ['type' => 'object', 'description' => 'Country Code Width (Slider/Size Object)'],
        'options_direction' => ['type' => 'object', 'description' => 'Position', 'enum' => ['column', 'form_fields', 'icon', 'row', 'toggle', '{{WRAPPER}} {{CURRENT_ITEM}}.tpaep-radio-checkbox']],
        'options_position' => ['type' => 'object', 'description' => 'Option Position', 'enum' => ['center', 'end', 'form_fields', 'icon', 'left', 'toggle', '{{WRAPPER}} {{CURRENT_ITEM}}.tpaep-radio-checkbox']],
        'option_gap' => ['type' => 'object', 'description' => 'Option Gap (Slider/Size Object)'],
        'textarea_rows' => ['type' => 'string', 'description' => 'Rows'],
        'field_default_value' => ['type' => 'string', 'description' => 'Default Value'],
        'field_help' => ['type' => 'string', 'description' => 'Help Text'],
        'field_ad' => ['type' => 'string', 'description' => 'Aria Description'],
        'field_id' => ['type' => 'string', 'description' => 'Unique ID'],
        'field_shortcode' => ['type' => 'string', 'description' => 'Data Shortcode'],
        'tabs' => ['type' => 'array', 'items' => ['type' => 'object'], 'description' => 'tabs'],
        'button_submit' => ['type' => 'string', 'description' => 'Button Text'],
        'button_icon_style' => ['type' => 'string', 'description' => 'Icon Font', 'enum' => ['font_awesome_5', 'none']],
        'icon_fontawesome_5' => ['type' => 'string', 'description' => 'Icon Library'],
        'icon_position' => ['type' => 'string', 'description' => 'Icon Position', 'enum' => ['after', 'before', 'button_icon_style']],
        'inline_button' => ['type' => 'string', 'description' => 'Inline Button', 'enum' => ['yes', 'no']],
        'button_inline_width' => ['type' => 'object', 'description' => 'Button Width (Slider/Size Object)'],
        'button_column_width' => ['type' => 'object', 'description' => 'Button Width (Slider/Size Object)'],
        'button_id' => ['type' => 'string', 'description' => 'Button ID'],
        'add_action' => ['type' => 'string', 'description' => 'Add Action', 'enum' => ['active_campaign', 'auto_respond_email', 'brevo', 'convertkit', 'database_entry', 'discord', 'drip', 'email', 'get_response', 'mailchimp', 'mailerlite', 'multiple', 'redirect', 'slack', 'webhook']],
        'email_to' => ['type' => 'string', 'description' => 'Email Address'],
        'email_cc' => ['type' => 'string', 'description' => 'Email Address'],
        'email_bcc' => ['type' => 'string', 'description' => 'Email Address'],
        'email_subject' => ['type' => 'string', 'description' => 'Subject'],
        'email_heading' => ['type' => 'string', 'description' => 'Email Heading'],
        'email_message' => ['type' => 'string', 'description' => 'Message'],
        'email_from' => ['type' => 'string', 'description' => 'From Email'],
        'email_from_name' => ['type' => 'string', 'description' => 'From Name'],
        'email_reply_to' => ['type' => 'string', 'description' => 'Reply-To'],
        'redirect_to' => ['type' => 'object', 'description' => 'Redirect To'],
        'ar_email_subject' => ['type' => 'string', 'description' => 'Subject'],
        'ar_email_heading' => ['type' => 'string', 'description' => 'Email Heading'],
        'ar_email_message' => ['type' => 'string', 'description' => 'Message'],
        'ar_email_from' => ['type' => 'string', 'description' => 'From Email'],
        'ar_email_from_name' => ['type' => 'string', 'description' => 'From Name'],
        'ar_email_reply_to' => ['type' => 'string', 'description' => 'Reply-To'],
        'ac_custom_key' => ['type' => 'string', 'description' => 'API Key'],
        'ac_custom_url' => ['type' => 'string', 'description' => 'API URL'],
        'brevo_api_key' => ['type' => 'string', 'description' => 'API Key'],
        'brevo_list_id' => ['type' => 'string', 'description' => 'List ID'],
        'convertkey_api_key' => ['type' => 'string', 'description' => 'API Key'],
        'convertkey_form_id' => ['type' => 'string', 'description' => 'Form ID'],
        'getresponse_api_key' => ['type' => 'string', 'description' => 'API Key'],
        'getresponse_list_token' => ['type' => 'string', 'description' => 'List Token'],
        'mailchimp_api_key' => ['type' => 'string', 'description' => 'API Key'],
        'mailchimp_audience_id' => ['type' => 'string', 'description' => 'Audience ID'],
        'mailerlite_api_key' => ['type' => 'string', 'description' => 'API Key'],
        'mailerlite_group_id' => ['type' => 'string', 'description' => 'Group ID'],
        'drip_api_key' => ['type' => 'string', 'description' => 'API Key'],
        'drip_account_id' => ['type' => 'string', 'description' => 'Account ID'],
        'webhook_url' => ['type' => 'string', 'description' => 'URL'],
        'slack_token' => ['type' => 'string', 'description' => 'User OAuth Token'],
        'slack_channel_name' => ['type' => 'string', 'description' => 'Channel Name'],
        'discord_url' => ['type' => 'string', 'description' => 'Discord URL'],
        'discord_username' => ['type' => 'string', 'description' => 'Username'],
        'success_message' => ['type' => 'string', 'description' => 'Success Message'],
        'required_fields' => ['type' => 'string', 'description' => 'Mandatory Fields'],
        'invalid_form' => ['type' => 'string', 'description' => 'Form Validation Error'],
        'form_error' => ['type' => 'string', 'description' => 'Submission Issue'],
        'server_error' => ['type' => 'string', 'description' => 'Server Issue'],
        'form_id' => ['type' => 'string', 'description' => 'Form ID'],
        'form_title_display' => ['type' => 'string', 'description' => 'Show Form Title', 'enum' => ['yes', 'no']],
        'label_display' => ['type' => 'string', 'description' => 'Show Label', 'enum' => ['yes', 'no']],
        'required_mask' => ['type' => 'string', 'description' => 'Required Mark', 'enum' => ['yes', 'no']],
        'form_column_gap' => ['type' => 'object', 'description' => 'Columns Gap (Slider/Size Object)'],
        'form_row_gap' => ['type' => 'object', 'description' => 'Rows Gap (Slider/Size Object)'],
        'form_title_heading' => ['type' => 'string', 'description' => 'Form Title'],
        'form_title_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'form_title_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'form_title_position' => ['type' => 'object', 'description' => 'Text Align', 'enum' => ['center', 'form_title_display', 'icon', 'left', 'right', 'toggle', '{{WRAPPER}} .tpaep-form-name']],
        'form_title_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_title_border_radius_normal' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'form_title_color_hover' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_title_border_radius_hover' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'form_label_heading' => ['type' => 'string', 'description' => 'Label'],
        'form_label_spacing' => ['type' => 'object', 'description' => 'Spacing (Slider/Size Object)'],
        'form_label_position' => ['type' => 'object', 'description' => 'Text Align', 'enum' => ['center', 'icon', 'label_display', 'left', 'right', 'toggle', '{{WRAPPER}} .tpaep-form-label']],
        'form_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_text_color_hover' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_required_mark_color' => ['type' => 'string', 'description' => 'Required Mark Color (Color Hex/RGBA)'],
        'form_field_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'form_field_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'form_placeholder_position' => ['type' => 'object', 'description' => 'Input Text Align', 'enum' => ['center', 'icon', 'left', 'right', 'toggle', '{{WRAPPER}} .tpaep-form-field input::placeholder, {{WRAPPER}} .tpaep-form-field textarea::placeholder, {{WRAPPER}} .tpaep-form-field select']],
        'form_placeholder_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_field_bg_color_normal' => ['type' => 'string', 'description' => 'Background Color (Color Hex/RGBA)'],
        'form_field_border_radius_normal' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'form_placeholder_text_color_hover' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_field_bg_clr_hover' => ['type' => 'string', 'description' => 'Background Color (Color Hex/RGBA)'],
        'form_field_border_radius_hover' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'form_placeholder_text_color_active' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_field_bg_clr_active' => ['type' => 'string', 'description' => 'Background Color (Color Hex/RGBA)'],
        'form_field_border_radius_active' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'dropdown_checkbox_radio' => ['type' => 'string', 'description' => 'Radio'],
        'form_radio_checkbox_padding' => ['type' => 'object', 'description' => 'Option Padding (Dimensions Object)'],
        'cr_input_scale' => ['type' => 'object', 'description' => 'Input Scale (Slider/Size Object)'],
        'radio_cb_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'radio_cb_option_color' => ['type' => 'string', 'description' => 'Option Color (Color Hex/RGBA)'],
        'radio_cb_text_color_hover' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'radio_cb_option_color_hover' => ['type' => 'string', 'description' => 'Option Color (Color Hex/RGBA)'],
        'checkbox_style_heading' => ['type' => 'string', 'description' => 'Checkbox'],
        'form_checkbox_padding' => ['type' => 'object', 'description' => 'Option Padding (Dimensions Object)'],
        'cb_input_scale' => ['type' => 'object', 'description' => 'Input Scale (Slider/Size Object)'],
        'checkbox_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'checkbox_option_color' => ['type' => 'string', 'description' => 'Option Color (Color Hex/RGBA)'],
        'checkbox_text_color_hover' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'checkbox_option_color_hover' => ['type' => 'string', 'description' => 'Option Color (Color Hex/RGBA)'],
        'dropdown_styles' => ['type' => 'string', 'description' => 'Dropdown'],
        'dropdown_option_color' => ['type' => 'string', 'description' => 'Option Color (Color Hex/RGBA)'],
        'att_styles' => ['type' => 'string', 'description' => 'Agree to Terms'],
        'agree_to_terms_link_clr' => ['type' => 'string', 'description' => 'Link Text Color (Color Hex/RGBA)'],
        'agree_to_terms_link_clr_hover' => ['type' => 'string', 'description' => 'Link Text Color (Color Hex/RGBA)'],
        'form_button_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'form_button_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'form_button_position' => ['type' => 'object', 'description' => 'Position', 'enum' => ['center', 'icon', 'left', 'right', 'toggle', '{{WRAPPER}} .tpaep-form-submit-container']],
        'form_button_alignment' => ['type' => 'object', 'description' => 'Alignment', 'enum' => ['center', 'icon', 'left', 'right', 'stretch', 'toggle', '{{WRAPPER}} .tpaep-form .tpaep-form-button.tpaep-form-submit']],
        'form_button_icon_spacing' => ['type' => 'object', 'description' => 'Icon Spacing (Slider/Size Object)'],
        'form_button_icon_size' => ['type' => 'object', 'description' => 'Icon Size (Slider/Size Object)'],
        'form_button_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_button_icon_color' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'icon_fill_color' => ['type' => 'string', 'description' => 'Fill (Color Hex/RGBA)'],
        'icon_stroke_color' => ['type' => 'string', 'description' => 'Stroke (Color Hex/RGBA)'],
        'form_btn_bg_type' => ['type' => 'string', 'description' => 'Background Type', 'enum' => ['gradient', 'icon']],
        'form_button_background_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'form_btn_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'form_btn_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'form_btn_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'form_btn_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'form_btn_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['form_btn_bg_type', 'of_type']],
        'form_btn_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'form_btn_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['form_btn_bg_type', 'form_btn_gradient_style', 'of_type', '{{WRAPPER}} .tpaep-form .tpaep-form-button']],
        'form_button_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'form_button_hover_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_button_icon_hover_color' => ['type' => 'string', 'description' => 'Icon Color (Color Hex/RGBA)'],
        'icon_fill_color_hover' => ['type' => 'string', 'description' => 'Hover Fill (Color Hex/RGBA)'],
        'icon_stroke_color_hover' => ['type' => 'string', 'description' => 'Hover Stroke (Color Hex/RGBA)'],
        'form_btn_hvr_bg_type' => ['type' => 'string', 'description' => 'Background Type', 'enum' => ['gradient', 'icon']],
        'form_button_hover_background_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'form_btn_hvr_gradient_color1' => ['type' => 'string', 'description' => 'Color 1 (Color Hex/RGBA)'],
        'form_btn_hvr_gradient_color1_control' => ['type' => 'object', 'description' => 'Color 1 Location (Slider/Size Object)'],
        'form_btn_hvr_gradient_color2' => ['type' => 'string', 'description' => 'Color 2 (Color Hex/RGBA)'],
        'form_btn_hvr_gradient_color2_control' => ['type' => 'object', 'description' => 'Color 2 Location (Slider/Size Object)'],
        'form_btn_hvr_gradient_style' => ['type' => 'string', 'description' => 'Gradient Style', 'enum' => ['form_btn_hvr_bg_type', 'of_type']],
        'form_btn_hvr_gradient_angle' => ['type' => 'object', 'description' => 'Gradient Angle (Slider/Size Object)'],
        'form_btn_hvr_gradient_position' => ['type' => 'string', 'description' => 'Position', 'enum' => ['form_btn_hvr_bg_type', 'form_btn_hvr_gradient_style', 'of_type', '{{WRAPPER}} .tpaep-form .tpaep-form-button:hover']],
        'form_button_hover_border_radius' => ['type' => 'object', 'description' => 'Border Radius (Dimensions Object)'],
        'button_spinner' => ['type' => 'string', 'description' => 'Spinner'],
        'button_spinner_size' => ['type' => 'object', 'description' => 'Spinner Size (Slider/Size Object)'],
        'button_spinner_thickness' => ['type' => 'object', 'description' => 'Spinner Thickness (Slider/Size Object)'],
        'spinner_inner_color' => ['type' => 'string', 'description' => 'Spinner Inner Color (Color Hex/RGBA)'],
        'spinner_color' => ['type' => 'string', 'description' => 'Spinner Color (Color Hex/RGBA)'],
        'form_help_padding' => ['type' => 'object', 'description' => 'Padding (Dimensions Object)'],
        'form_help_margin' => ['type' => 'object', 'description' => 'Margin (Dimensions Object)'],
        'help_text_color' => ['type' => 'string', 'description' => 'Text Color (Color Hex/RGBA)'],
        'form_msg_align' => ['type' => 'object', 'description' => 'Message Text Align', 'enum' => ['center', 'icon', 'left', 'right', 'toggle', '{{WRAPPER}} .tpaep-form-message']],
        'form_success_message_color' => ['type' => 'string', 'description' => 'Success Message Color (Color Hex/RGBA)'],
        'form_error_message_color' => ['type' => 'string', 'description' => 'Error Message Color (Color Hex/RGBA)'],
        'form_success_msg_bg_clr' => ['type' => 'string', 'description' => 'Success Message Background Color (Color Hex/RGBA)'],
        'form_error_msg_bg_clr' => ['type' => 'string', 'description' => 'Error Message Background Color (Color Hex/RGBA)'],
        'form_inline_message_color' => ['type' => 'string', 'description' => 'Inline Message Color (Color Hex/RGBA)'],
        'form_success_msg_clr_hover' => ['type' => 'string', 'description' => 'Success Message Color (Color Hex/RGBA)'],
        'form_error_msg_clr_hover' => ['type' => 'string', 'description' => 'Error Message Color (Color Hex/RGBA)'],
        'form_success_msg_bg_clr_hover' => ['type' => 'string', 'description' => 'Success Message Background Color (Color Hex/RGBA)'],
        'form_error_msg_bg_clr_hover' => ['type' => 'string', 'description' => 'Error Message Background Color (Color Hex/RGBA)'],
        'form_inline_message_color_hover' => ['type' => 'string', 'description' => 'Inline Message Color (Color Hex/RGBA)'],
        'mandatory_field_message' => ['type' => 'string', 'description' => 'Mandatory Field Message'],
        'mandatory_field_message_color' => ['type' => 'string', 'description' => 'Color (Color Hex/RGBA)'],
        'settings'       => ['type' => 'object',  'description' => 'Raw Elementor control key/value pairs to merge. Supports multi-step styles, reCAPTCHA v3, and Mailchimp/WooCommerce integrations.']
        ],
        'required' => ['post_id', 'parent_id', 'form_title'],
        'additionalProperties' => false,
    ],
    'output_schema' => ['type' => 'object', 'properties' => ['element_id' => ['type' => 'string'], 'widget_type' => ['type' => 'string'], 'post_id' => ['type' => 'integer']]],
    'execute_callback' => 'tpae_mcp_add_theplus_plus_form_ability',
    'permission_callback' => 'tpae_mcp_add_theplus_plus_form_permission',
    'meta' => ['show_in_rest' => true, 'mcp' => ['public' => true, 'type' => 'tool']],
]);

function tpae_mcp_add_theplus_plus_form_permission(?array $input = null): bool {
    if (!current_user_can('edit_posts')) { return false; }
    $post_id = absint($input['post_id'] ?? 0);
    if ($post_id > 0 && !current_user_can('edit_post', $post_id)) { return false; }
    return true;
}

function tpae_mcp_add_theplus_plus_form_ability(array $input) {
    if (!tpae_mcp_has_elementor()) { return new WP_Error('elementor_missing', __('Elementor must be active.', 'tpebl')); }
    $widget_type = 'tp-plus-form';
    if (!tpae_mcp_has_registered_widget($widget_type)) { return new WP_Error('widget_missing', __('The Plus Plus Form widget is not registered on this site.', 'tpebl')); }
    $post_id = absint($input['post_id'] ?? 0);
    $parent_id = sanitize_text_field((string)($input['parent_id'] ?? ''));
    $position = intval($input['position'] ?? -1);
    if ($post_id <= 0 || $parent_id === '') { return new WP_Error('missing_params', __('post_id and parent_id are required.', 'tpebl')); }
    $post = get_post($post_id);
    if (!$post instanceof WP_Post) { return new WP_Error('invalid_post', __('Target post was not found.', 'tpebl')); }
    $page_data = tpae_mcp_get_elementor_page_data($post_id);
    if (is_wp_error($page_data)) { return $page_data; }
    $settings = [];
    if (isset($input['form_title'])) { $settings['form_title'] = sanitize_text_field($input['form_title']); }
    if (isset($input['form_fields'])) { $settings['form_fields'] = sanitize_text_field($input['form_fields']); }
    if (isset($input['field_label'])) { $settings['field_label'] = sanitize_text_field($input['field_label']); }
    if (isset($input['dropdown_options'])) { $settings['dropdown_options'] = sanitize_text_field($input['dropdown_options']); }
    if (isset($input['place_holder'])) { $settings['place_holder'] = sanitize_text_field($input['place_holder']); }
    if (isset($input['required'])) { $settings['required'] = sanitize_text_field($input['required']); }
    if (isset($input['autofill'])) { $settings['autofill'] = sanitize_text_field($input['autofill']); }
    if (isset($input['country_code_detection'])) { $settings['country_code_detection'] = sanitize_text_field($input['country_code_detection']); }
    if (isset($input['default_country_code'])) { $settings['default_country_code'] = sanitize_text_field($input['default_country_code']); }
    if (isset($input['enable_link'])) { $settings['enable_link'] = sanitize_text_field($input['enable_link']); }
    if (isset($input['link_label'])) { $settings['link_label'] = sanitize_text_field($input['link_label']); }
    if (isset($input['terms_url'])) { $settings['terms_url'] = $input['terms_url']; }
    if (isset($input['column_width'])) { $settings['column_width'] = $input['column_width']; }
    if (isset($input['country_code_width'])) { $settings['country_code_width'] = $input['country_code_width']; }
    if (isset($input['options_direction'])) { $settings['options_direction'] = $input['options_direction']; }
    if (isset($input['options_position'])) { $settings['options_position'] = $input['options_position']; }
    if (isset($input['option_gap'])) { $settings['option_gap'] = $input['option_gap']; }
    if (isset($input['textarea_rows'])) { $settings['textarea_rows'] = sanitize_text_field($input['textarea_rows']); }
    if (isset($input['field_default_value'])) { $settings['field_default_value'] = sanitize_text_field($input['field_default_value']); }
    if (isset($input['field_help'])) { $settings['field_help'] = sanitize_text_field($input['field_help']); }
    if (isset($input['field_ad'])) { $settings['field_ad'] = sanitize_text_field($input['field_ad']); }
    if (isset($input['field_id'])) { $settings['field_id'] = sanitize_text_field($input['field_id']); }
    if (isset($input['field_shortcode'])) { $settings['field_shortcode'] = sanitize_text_field($input['field_shortcode']); }
    if (isset($input['tabs'])) { $settings['tabs'] = $input['tabs']; }
    if (isset($input['button_submit'])) { $settings['button_submit'] = sanitize_text_field($input['button_submit']); }
    if (isset($input['button_icon_style'])) { $settings['button_icon_style'] = sanitize_text_field($input['button_icon_style']); }
    if (isset($input['icon_fontawesome_5'])) { $settings['icon_fontawesome_5'] = sanitize_text_field($input['icon_fontawesome_5']); }
    if (isset($input['icon_position'])) { $settings['icon_position'] = sanitize_text_field($input['icon_position']); }
    if (isset($input['inline_button'])) { $settings['inline_button'] = sanitize_text_field($input['inline_button']); }
    if (isset($input['button_inline_width'])) { $settings['button_inline_width'] = $input['button_inline_width']; }
    if (isset($input['button_column_width'])) { $settings['button_column_width'] = $input['button_column_width']; }
    if (isset($input['button_id'])) { $settings['button_id'] = sanitize_text_field($input['button_id']); }
    if (isset($input['add_action'])) { $settings['add_action'] = sanitize_text_field($input['add_action']); }
    if (isset($input['email_to'])) { $settings['email_to'] = sanitize_text_field($input['email_to']); }
    if (isset($input['email_cc'])) { $settings['email_cc'] = sanitize_text_field($input['email_cc']); }
    if (isset($input['email_bcc'])) { $settings['email_bcc'] = sanitize_text_field($input['email_bcc']); }
    if (isset($input['email_subject'])) { $settings['email_subject'] = sanitize_text_field($input['email_subject']); }
    if (isset($input['email_heading'])) { $settings['email_heading'] = sanitize_text_field($input['email_heading']); }
    if (isset($input['email_message'])) { $settings['email_message'] = sanitize_text_field($input['email_message']); }
    if (isset($input['email_from'])) { $settings['email_from'] = sanitize_text_field($input['email_from']); }
    if (isset($input['email_from_name'])) { $settings['email_from_name'] = sanitize_text_field($input['email_from_name']); }
    if (isset($input['email_reply_to'])) { $settings['email_reply_to'] = sanitize_text_field($input['email_reply_to']); }
    if (isset($input['redirect_to'])) { $settings['redirect_to'] = $input['redirect_to']; }
    if (isset($input['ar_email_subject'])) { $settings['ar_email_subject'] = sanitize_text_field($input['ar_email_subject']); }
    if (isset($input['ar_email_heading'])) { $settings['ar_email_heading'] = sanitize_text_field($input['ar_email_heading']); }
    if (isset($input['ar_email_message'])) { $settings['ar_email_message'] = sanitize_text_field($input['ar_email_message']); }
    if (isset($input['ar_email_from'])) { $settings['ar_email_from'] = sanitize_text_field($input['ar_email_from']); }
    if (isset($input['ar_email_from_name'])) { $settings['ar_email_from_name'] = sanitize_text_field($input['ar_email_from_name']); }
    if (isset($input['ar_email_reply_to'])) { $settings['ar_email_reply_to'] = sanitize_text_field($input['ar_email_reply_to']); }
    if (isset($input['ac_custom_key'])) { $settings['ac_custom_key'] = sanitize_text_field($input['ac_custom_key']); }
    if (isset($input['ac_custom_url'])) { $settings['ac_custom_url'] = sanitize_text_field($input['ac_custom_url']); }
    if (isset($input['brevo_api_key'])) { $settings['brevo_api_key'] = sanitize_text_field($input['brevo_api_key']); }
    if (isset($input['brevo_list_id'])) { $settings['brevo_list_id'] = sanitize_text_field($input['brevo_list_id']); }
    if (isset($input['convertkey_api_key'])) { $settings['convertkey_api_key'] = sanitize_text_field($input['convertkey_api_key']); }
    if (isset($input['convertkey_form_id'])) { $settings['convertkey_form_id'] = sanitize_text_field($input['convertkey_form_id']); }
    if (isset($input['getresponse_api_key'])) { $settings['getresponse_api_key'] = sanitize_text_field($input['getresponse_api_key']); }
    if (isset($input['getresponse_list_token'])) { $settings['getresponse_list_token'] = sanitize_text_field($input['getresponse_list_token']); }
    if (isset($input['mailchimp_api_key'])) { $settings['mailchimp_api_key'] = sanitize_text_field($input['mailchimp_api_key']); }
    if (isset($input['mailchimp_audience_id'])) { $settings['mailchimp_audience_id'] = sanitize_text_field($input['mailchimp_audience_id']); }
    if (isset($input['mailerlite_api_key'])) { $settings['mailerlite_api_key'] = sanitize_text_field($input['mailerlite_api_key']); }
    if (isset($input['mailerlite_group_id'])) { $settings['mailerlite_group_id'] = sanitize_text_field($input['mailerlite_group_id']); }
    if (isset($input['drip_api_key'])) { $settings['drip_api_key'] = sanitize_text_field($input['drip_api_key']); }
    if (isset($input['drip_account_id'])) { $settings['drip_account_id'] = sanitize_text_field($input['drip_account_id']); }
    if (isset($input['webhook_url'])) { $settings['webhook_url'] = sanitize_text_field($input['webhook_url']); }
    if (isset($input['slack_token'])) { $settings['slack_token'] = sanitize_text_field($input['slack_token']); }
    if (isset($input['slack_channel_name'])) { $settings['slack_channel_name'] = sanitize_text_field($input['slack_channel_name']); }
    if (isset($input['discord_url'])) { $settings['discord_url'] = sanitize_text_field($input['discord_url']); }
    if (isset($input['discord_username'])) { $settings['discord_username'] = sanitize_text_field($input['discord_username']); }
    if (isset($input['success_message'])) { $settings['success_message'] = sanitize_text_field($input['success_message']); }
    if (isset($input['required_fields'])) { $settings['required_fields'] = sanitize_text_field($input['required_fields']); }
    if (isset($input['invalid_form'])) { $settings['invalid_form'] = sanitize_text_field($input['invalid_form']); }
    if (isset($input['form_error'])) { $settings['form_error'] = sanitize_text_field($input['form_error']); }
    if (isset($input['server_error'])) { $settings['server_error'] = sanitize_text_field($input['server_error']); }
    if (isset($input['form_id'])) { $settings['form_id'] = sanitize_text_field($input['form_id']); }
    if (isset($input['form_title_display'])) { $settings['form_title_display'] = sanitize_text_field($input['form_title_display']); }
    if (isset($input['label_display'])) { $settings['label_display'] = sanitize_text_field($input['label_display']); }
    if (isset($input['required_mask'])) { $settings['required_mask'] = sanitize_text_field($input['required_mask']); }
    if (isset($input['form_column_gap'])) { $settings['form_column_gap'] = $input['form_column_gap']; }
    if (isset($input['form_row_gap'])) { $settings['form_row_gap'] = $input['form_row_gap']; }
    if (isset($input['form_title_heading'])) { $settings['form_title_heading'] = sanitize_text_field($input['form_title_heading']); }
    if (isset($input['form_title_padding'])) { $settings['form_title_padding'] = $input['form_title_padding']; }
    if (isset($input['form_title_margin'])) { $settings['form_title_margin'] = $input['form_title_margin']; }
    if (isset($input['form_title_position'])) { $settings['form_title_position'] = $input['form_title_position']; }
    if (isset($input['form_title_color'])) { $settings['form_title_color'] = sanitize_text_field($input['form_title_color']); }
    if (isset($input['form_title_border_radius_normal'])) { $settings['form_title_border_radius_normal'] = $input['form_title_border_radius_normal']; }
    if (isset($input['form_title_color_hover'])) { $settings['form_title_color_hover'] = sanitize_text_field($input['form_title_color_hover']); }
    if (isset($input['form_title_border_radius_hover'])) { $settings['form_title_border_radius_hover'] = $input['form_title_border_radius_hover']; }
    if (isset($input['form_label_heading'])) { $settings['form_label_heading'] = sanitize_text_field($input['form_label_heading']); }
    if (isset($input['form_label_spacing'])) { $settings['form_label_spacing'] = $input['form_label_spacing']; }
    if (isset($input['form_label_position'])) { $settings['form_label_position'] = $input['form_label_position']; }
    if (isset($input['form_text_color'])) { $settings['form_text_color'] = sanitize_text_field($input['form_text_color']); }
    if (isset($input['form_text_color_hover'])) { $settings['form_text_color_hover'] = sanitize_text_field($input['form_text_color_hover']); }
    if (isset($input['form_required_mark_color'])) { $settings['form_required_mark_color'] = sanitize_text_field($input['form_required_mark_color']); }
    if (isset($input['form_field_padding'])) { $settings['form_field_padding'] = $input['form_field_padding']; }
    if (isset($input['form_field_margin'])) { $settings['form_field_margin'] = $input['form_field_margin']; }
    if (isset($input['form_placeholder_position'])) { $settings['form_placeholder_position'] = $input['form_placeholder_position']; }
    if (isset($input['form_placeholder_text_color'])) { $settings['form_placeholder_text_color'] = sanitize_text_field($input['form_placeholder_text_color']); }
    if (isset($input['form_field_bg_color_normal'])) { $settings['form_field_bg_color_normal'] = sanitize_text_field($input['form_field_bg_color_normal']); }
    if (isset($input['form_field_border_radius_normal'])) { $settings['form_field_border_radius_normal'] = $input['form_field_border_radius_normal']; }
    if (isset($input['form_placeholder_text_color_hover'])) { $settings['form_placeholder_text_color_hover'] = sanitize_text_field($input['form_placeholder_text_color_hover']); }
    if (isset($input['form_field_bg_clr_hover'])) { $settings['form_field_bg_clr_hover'] = sanitize_text_field($input['form_field_bg_clr_hover']); }
    if (isset($input['form_field_border_radius_hover'])) { $settings['form_field_border_radius_hover'] = $input['form_field_border_radius_hover']; }
    if (isset($input['form_placeholder_text_color_active'])) { $settings['form_placeholder_text_color_active'] = sanitize_text_field($input['form_placeholder_text_color_active']); }
    if (isset($input['form_field_bg_clr_active'])) { $settings['form_field_bg_clr_active'] = sanitize_text_field($input['form_field_bg_clr_active']); }
    if (isset($input['form_field_border_radius_active'])) { $settings['form_field_border_radius_active'] = $input['form_field_border_radius_active']; }
    if (isset($input['dropdown_checkbox_radio'])) { $settings['dropdown_checkbox_radio'] = sanitize_text_field($input['dropdown_checkbox_radio']); }
    if (isset($input['form_radio_checkbox_padding'])) { $settings['form_radio_checkbox_padding'] = $input['form_radio_checkbox_padding']; }
    if (isset($input['cr_input_scale'])) { $settings['cr_input_scale'] = $input['cr_input_scale']; }
    if (isset($input['radio_cb_text_color'])) { $settings['radio_cb_text_color'] = sanitize_text_field($input['radio_cb_text_color']); }
    if (isset($input['radio_cb_option_color'])) { $settings['radio_cb_option_color'] = sanitize_text_field($input['radio_cb_option_color']); }
    if (isset($input['radio_cb_text_color_hover'])) { $settings['radio_cb_text_color_hover'] = sanitize_text_field($input['radio_cb_text_color_hover']); }
    if (isset($input['radio_cb_option_color_hover'])) { $settings['radio_cb_option_color_hover'] = sanitize_text_field($input['radio_cb_option_color_hover']); }
    if (isset($input['checkbox_style_heading'])) { $settings['checkbox_style_heading'] = sanitize_text_field($input['checkbox_style_heading']); }
    if (isset($input['form_checkbox_padding'])) { $settings['form_checkbox_padding'] = $input['form_checkbox_padding']; }
    if (isset($input['cb_input_scale'])) { $settings['cb_input_scale'] = $input['cb_input_scale']; }
    if (isset($input['checkbox_text_color'])) { $settings['checkbox_text_color'] = sanitize_text_field($input['checkbox_text_color']); }
    if (isset($input['checkbox_option_color'])) { $settings['checkbox_option_color'] = sanitize_text_field($input['checkbox_option_color']); }
    if (isset($input['checkbox_text_color_hover'])) { $settings['checkbox_text_color_hover'] = sanitize_text_field($input['checkbox_text_color_hover']); }
    if (isset($input['checkbox_option_color_hover'])) { $settings['checkbox_option_color_hover'] = sanitize_text_field($input['checkbox_option_color_hover']); }
    if (isset($input['dropdown_styles'])) { $settings['dropdown_styles'] = sanitize_text_field($input['dropdown_styles']); }
    if (isset($input['dropdown_option_color'])) { $settings['dropdown_option_color'] = sanitize_text_field($input['dropdown_option_color']); }
    if (isset($input['att_styles'])) { $settings['att_styles'] = sanitize_text_field($input['att_styles']); }
    if (isset($input['agree_to_terms_link_clr'])) { $settings['agree_to_terms_link_clr'] = sanitize_text_field($input['agree_to_terms_link_clr']); }
    if (isset($input['agree_to_terms_link_clr_hover'])) { $settings['agree_to_terms_link_clr_hover'] = sanitize_text_field($input['agree_to_terms_link_clr_hover']); }
    if (isset($input['form_button_padding'])) { $settings['form_button_padding'] = $input['form_button_padding']; }
    if (isset($input['form_button_margin'])) { $settings['form_button_margin'] = $input['form_button_margin']; }
    if (isset($input['form_button_position'])) { $settings['form_button_position'] = $input['form_button_position']; }
    if (isset($input['form_button_alignment'])) { $settings['form_button_alignment'] = $input['form_button_alignment']; }
    if (isset($input['form_button_icon_spacing'])) { $settings['form_button_icon_spacing'] = $input['form_button_icon_spacing']; }
    if (isset($input['form_button_icon_size'])) { $settings['form_button_icon_size'] = $input['form_button_icon_size']; }
    if (isset($input['form_button_text_color'])) { $settings['form_button_text_color'] = sanitize_text_field($input['form_button_text_color']); }
    if (isset($input['form_button_icon_color'])) { $settings['form_button_icon_color'] = sanitize_text_field($input['form_button_icon_color']); }
    if (isset($input['icon_fill_color'])) { $settings['icon_fill_color'] = sanitize_text_field($input['icon_fill_color']); }
    if (isset($input['icon_stroke_color'])) { $settings['icon_stroke_color'] = sanitize_text_field($input['icon_stroke_color']); }
    if (isset($input['form_btn_bg_type'])) { $settings['form_btn_bg_type'] = sanitize_text_field($input['form_btn_bg_type']); }
    if (isset($input['form_button_background_color'])) { $settings['form_button_background_color'] = sanitize_text_field($input['form_button_background_color']); }
    if (isset($input['form_btn_gradient_color1'])) { $settings['form_btn_gradient_color1'] = sanitize_text_field($input['form_btn_gradient_color1']); }
    if (isset($input['form_btn_gradient_color1_control'])) { $settings['form_btn_gradient_color1_control'] = $input['form_btn_gradient_color1_control']; }
    if (isset($input['form_btn_gradient_color2'])) { $settings['form_btn_gradient_color2'] = sanitize_text_field($input['form_btn_gradient_color2']); }
    if (isset($input['form_btn_gradient_color2_control'])) { $settings['form_btn_gradient_color2_control'] = $input['form_btn_gradient_color2_control']; }
    if (isset($input['form_btn_gradient_style'])) { $settings['form_btn_gradient_style'] = sanitize_text_field($input['form_btn_gradient_style']); }
    if (isset($input['form_btn_gradient_angle'])) { $settings['form_btn_gradient_angle'] = $input['form_btn_gradient_angle']; }
    if (isset($input['form_btn_gradient_position'])) { $settings['form_btn_gradient_position'] = sanitize_text_field($input['form_btn_gradient_position']); }
    if (isset($input['form_button_border_radius'])) { $settings['form_button_border_radius'] = $input['form_button_border_radius']; }
    if (isset($input['form_button_hover_text_color'])) { $settings['form_button_hover_text_color'] = sanitize_text_field($input['form_button_hover_text_color']); }
    if (isset($input['form_button_icon_hover_color'])) { $settings['form_button_icon_hover_color'] = sanitize_text_field($input['form_button_icon_hover_color']); }
    if (isset($input['icon_fill_color_hover'])) { $settings['icon_fill_color_hover'] = sanitize_text_field($input['icon_fill_color_hover']); }
    if (isset($input['icon_stroke_color_hover'])) { $settings['icon_stroke_color_hover'] = sanitize_text_field($input['icon_stroke_color_hover']); }
    if (isset($input['form_btn_hvr_bg_type'])) { $settings['form_btn_hvr_bg_type'] = sanitize_text_field($input['form_btn_hvr_bg_type']); }
    if (isset($input['form_button_hover_background_color'])) { $settings['form_button_hover_background_color'] = sanitize_text_field($input['form_button_hover_background_color']); }
    if (isset($input['form_btn_hvr_gradient_color1'])) { $settings['form_btn_hvr_gradient_color1'] = sanitize_text_field($input['form_btn_hvr_gradient_color1']); }
    if (isset($input['form_btn_hvr_gradient_color1_control'])) { $settings['form_btn_hvr_gradient_color1_control'] = $input['form_btn_hvr_gradient_color1_control']; }
    if (isset($input['form_btn_hvr_gradient_color2'])) { $settings['form_btn_hvr_gradient_color2'] = sanitize_text_field($input['form_btn_hvr_gradient_color2']); }
    if (isset($input['form_btn_hvr_gradient_color2_control'])) { $settings['form_btn_hvr_gradient_color2_control'] = $input['form_btn_hvr_gradient_color2_control']; }
    if (isset($input['form_btn_hvr_gradient_style'])) { $settings['form_btn_hvr_gradient_style'] = sanitize_text_field($input['form_btn_hvr_gradient_style']); }
    if (isset($input['form_btn_hvr_gradient_angle'])) { $settings['form_btn_hvr_gradient_angle'] = $input['form_btn_hvr_gradient_angle']; }
    if (isset($input['form_btn_hvr_gradient_position'])) { $settings['form_btn_hvr_gradient_position'] = sanitize_text_field($input['form_btn_hvr_gradient_position']); }
    if (isset($input['form_button_hover_border_radius'])) { $settings['form_button_hover_border_radius'] = $input['form_button_hover_border_radius']; }
    if (isset($input['button_spinner'])) { $settings['button_spinner'] = sanitize_text_field($input['button_spinner']); }
    if (isset($input['button_spinner_size'])) { $settings['button_spinner_size'] = $input['button_spinner_size']; }
    if (isset($input['button_spinner_thickness'])) { $settings['button_spinner_thickness'] = $input['button_spinner_thickness']; }
    if (isset($input['spinner_inner_color'])) { $settings['spinner_inner_color'] = sanitize_text_field($input['spinner_inner_color']); }
    if (isset($input['spinner_color'])) { $settings['spinner_color'] = sanitize_text_field($input['spinner_color']); }
    if (isset($input['form_help_padding'])) { $settings['form_help_padding'] = $input['form_help_padding']; }
    if (isset($input['form_help_margin'])) { $settings['form_help_margin'] = $input['form_help_margin']; }
    if (isset($input['help_text_color'])) { $settings['help_text_color'] = sanitize_text_field($input['help_text_color']); }
    if (isset($input['form_msg_align'])) { $settings['form_msg_align'] = $input['form_msg_align']; }
    if (isset($input['form_success_message_color'])) { $settings['form_success_message_color'] = sanitize_text_field($input['form_success_message_color']); }
    if (isset($input['form_error_message_color'])) { $settings['form_error_message_color'] = sanitize_text_field($input['form_error_message_color']); }
    if (isset($input['form_success_msg_bg_clr'])) { $settings['form_success_msg_bg_clr'] = sanitize_text_field($input['form_success_msg_bg_clr']); }
    if (isset($input['form_error_msg_bg_clr'])) { $settings['form_error_msg_bg_clr'] = sanitize_text_field($input['form_error_msg_bg_clr']); }
    if (isset($input['form_inline_message_color'])) { $settings['form_inline_message_color'] = sanitize_text_field($input['form_inline_message_color']); }
    if (isset($input['form_success_msg_clr_hover'])) { $settings['form_success_msg_clr_hover'] = sanitize_text_field($input['form_success_msg_clr_hover']); }
    if (isset($input['form_error_msg_clr_hover'])) { $settings['form_error_msg_clr_hover'] = sanitize_text_field($input['form_error_msg_clr_hover']); }
    if (isset($input['form_success_msg_bg_clr_hover'])) { $settings['form_success_msg_bg_clr_hover'] = sanitize_text_field($input['form_success_msg_bg_clr_hover']); }
    if (isset($input['form_error_msg_bg_clr_hover'])) { $settings['form_error_msg_bg_clr_hover'] = sanitize_text_field($input['form_error_msg_bg_clr_hover']); }
    if (isset($input['form_inline_message_color_hover'])) { $settings['form_inline_message_color_hover'] = sanitize_text_field($input['form_inline_message_color_hover']); }
    if (isset($input['mandatory_field_message'])) { $settings['mandatory_field_message'] = sanitize_text_field($input['mandatory_field_message']); }
    if (isset($input['mandatory_field_message_color'])) { $settings['mandatory_field_message_color'] = sanitize_text_field($input['mandatory_field_message_color']); }
    $settings = tpae_mcp_merge_widget_settings($settings, $input['settings'] ?? []);

    $widget = ['id' => tpae_mcp_generate_elementor_element_id(), 'elType' => 'widget', 'widgetType' => $widget_type, 'isInner' => false, 'settings' => $settings, 'elements' => []];
    if (!tpae_mcp_insert_elementor_element($page_data, $parent_id, $widget, $position)) { return new WP_Error('parent_not_found', __('Parent container not found.', 'tpebl')); }
    $save_result = tpae_mcp_save_elementor_page_data($post_id, $page_data);
    if (is_wp_error($save_result)) { return $save_result; }
    return ['element_id' => $widget['id'], 'widget_type' => $widget_type, 'post_id' => $post_id];
}
