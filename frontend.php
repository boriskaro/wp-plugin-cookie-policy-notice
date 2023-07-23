<?php
function enqueue_bootstrap() {
    wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );
    wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), null, true );
}
add_action( 'wp_enqueue_scripts', 'enqueue_bootstrap' );

function add_cookie_warning_html() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'bk_cookie_policy_notice';
    
    $notice_title = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_name = %s", 'notice_title'));
    if(!$notice_title){
        $notice_title = 'This website uses cookies';
    }

    $notice_msg = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_name = %s", 'notice_msg'));
    if(!$notice_msg){
        $notice_msg = 'We employ cookies to enhance the functionality of our website, examine patterns of web traffic, and customize our site\'s content. For further understanding of how we leverage cookies or to choose to decline certain categories of cookies, we invite you to review our cookies policy.'; // default value
    }
    
    $cookie_policy_url = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_name = %s", 'cookie_policy_url'));
    
    $font_color = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_name = %s", 'font_color'));
    if(!$font_color){
        $font_color = '#ffffff';
    }

    $bg_color = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_name = %s", 'bg_color'));
    if(!$bg_color){
        $bg_color = '#343a40';
    }
    
    $button_style = $wpdb->get_var($wpdb->prepare("SELECT setting_value FROM $table_name WHERE setting_name = %s", 'button_style'));
    if(!$button_style){
        $button_style = 'Light';
    }

    $btnAccept = $button_style === 'Dark' ? 'btn btn-dark' : 'btn btn-light';
    $btnDeny = $button_style === 'Dark' ? 'btn btn-outline-dark mr-3' : 'btn btn-outline-light mr-3';

    ?>
    <div id="cookie-warning-toast" class="fixed-bottom p-4">
        <div class="fixed-bottom p-4">
            <div class="toast text-white w-100 mw-100" role="alert" data-autohide="false" style="background-color: <?php echo esc_attr($bg_color); ?>;">
                <div class="toast-body p-4 d-flex flex-column cookie-policy-notice">
                    <h4 style="color: <?php echo esc_attr($font_color); ?>;"><?php echo esc_html($notice_title); ?></h4>
                    <p style="color: <?php echo esc_attr($font_color); ?>;">
                        <?php echo esc_html($notice_msg); ?> 
                        <br>
                        <a href="<?php echo esc_url($cookie_policy_url) ?>" target="_blank" style="color: <?php echo esc_attr($font_color); ?>;">Review our cookies policy by clicking here.</a>
                    </p>
                    <div class="ml-auto">
                        <button type="button" class="<?php echo esc_attr($btnDeny); ?>" id="btnDeny">
                            Deny
                        </button>
                        <button type="button" class="<?php echo esc_attr($btnAccept); ?>" id="btnAccept">
                            Accept
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'add_cookie_warning_html');
?>