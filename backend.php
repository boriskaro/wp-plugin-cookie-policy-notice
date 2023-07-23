<?php
add_action('admin_menu', 'cookie_policy_notice_menu');

function cookie_policy_notice_menu() {
    add_menu_page(
        'Cookie Policy Notice Settings',
        'Cookie Policy Notice',
        'manage_options',
        'cookie-policy-notice',
        'cookie_policy_notice_settings_page'
    );
}

function cookie_policy_notice_settings_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bk_cookie_policy_notice';

    if (!current_user_can('manage_options'))  {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $settings = array(
            'notice_title' => sanitize_text_field($_POST['cookie_policy_notice_notice_title']),
            'notice_msg' => sanitize_text_field($_POST['cookie_policy_notice_notice_msg']),
            'cookie_policy_url' => sanitize_text_field($_POST['cookie_policy_notice_cookie_policy_url']),
            'bg_color' => isset($_POST['cookie_policy_notice_bg_color']) ? sanitize_hex_color($_POST['cookie_policy_notice_bg_color']) : '#000000',
            'font_color' => isset($_POST['cookie_policy_notice_font_color']) ? sanitize_hex_color($_POST['cookie_policy_notice_font_color']) : '#ffffff',
            'accept_button_color' => isset($_POST['cookie_policy_notice_accept_button_color']) ? sanitize_hex_color($_POST['cookie_policy_notice_accept_button_color']) : '#ffffff',
            'deny_button_color' => isset($_POST['cookie_policy_notice_deny_button_color']) ? sanitize_hex_color($_POST['cookie_policy_notice_deny_button_color']) : '#ffffff',
            'button_style' => sanitize_text_field($_POST['cookie_policy_notice_button_style']),
        );

        foreach($settings as $name => $value) {
            $existing_setting = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE setting_name = %s", $name));

            if($existing_setting) {
                $wpdb->update(
                    $table_name,
                    array('setting_value' => $value),
                    array('setting_name' => $name),
                    array('%s'),
                    array('%s')
                );
            } else {
                $wpdb->insert(
                    $table_name,
                    array(
                        'setting_name' => $name,
                        'setting_value' => $value
                    ),
                    array(
                        '%s',
                        '%s'
                    )
                );
            }
        }
    }

    $settings = [
        'notice_title' => 'Cookie Policy Notice',
        'notice_msg' => 'We employ cookies to enhance the functionality of our website, examine patterns of web traffic, and customize our site\'s content. For further understanding of how we leverage cookies or to choose to decline certain categories of cookies, we invite you to review our cookies policy.',
        'cookie_policy_url' => '',
        'bg_color' => '#ffffff',
        'font_color' => '#000000',
        'accept_button_color' => '#ffffff',
        'deny_button_color' => '#ffffff',
        'button_style' => 'Light',
    ];

    foreach ($settings as $name => &$value) {
        $setting_value = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_name = %s", $name));
        if ($setting_value !== null) {
            $value = esc_attr($setting_value);
        }
    }

    ?>
    <div class="wrap">
        <h1>Cookie Policy Notice Settings</h1>
        <form method="post" action="">
            <p>This plugin is hassle-free way to create and manage cookie notices on your WordPress website. Cookie Policy Notice by Boris Karo is here to make it as easy as pie. This powerful plugin provides you with a customizable dashboard within WordPress, where you can create a personalized cookie notice to ensure your website is compliant with data privacy regulations.
            <br>
            Version: $version
            <br>
            For support <a href="https://www.boriskaro.com/contact/" target="_blank" rel="noopener">contact Boris Karo</a>
            </P>
            <h3>Details</h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Notice Title</th>
                    <td><input type="text" name="cookie_policy_notice_notice_title" value="<?php echo $settings['notice_title']; ?>" /></td>
                </tr>
                <tr valign="top">
                <th scope="row">Notice Message</th>
                    <td>
                        <textarea name="cookie_policy_notice_notice_msg"><?php echo $settings['notice_msg']; ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Cookie Policy URL</th>
                    <td><input type="text" name="cookie_policy_notice_cookie_policy_url" value="<?php echo $settings['cookie_policy_url']; ?>" /></td>
                </tr>
            </table>
            <h3>Frontend settings</h3>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Background color</th>
                        <td><input type="color" name="cookie_policy_notice_bg_color" value="<?php echo $settings['bg_color']; ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Font color</th>
                        <td><input type="color" name="cookie_policy_notice_font_color" value="<?php echo $settings['font_color']; ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Accept button color</th>
                        <td><input type="color" name="cookie_policy_notice_accept_button_color" value="<?php echo $settings['accept_button_color']; ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Deny button color</th>
                        <td><input type="color" name="cookie_policy_notice_deny_button_color" value="<?php echo $settings['deny_button_color']; ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Button Style</th>
                        <td>
                            <select name="cookie_policy_notice_button_style">
                                <option value="Light" <?php echo $settings['button_style'] == 'Light' ? 'selected' : ''; ?>>Light</option>
                                <option value="Dark" <?php echo $settings['button_style'] == 'Dark' ? 'selected' : ''; ?>>Dark</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php
}
?>