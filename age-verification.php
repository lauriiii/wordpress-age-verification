<?php
/**
 * Plugin Name: Simple Age Verification
 * Plugin URI: http://lauriliimatta.com
 * Description: This plugin adds a simple age verification check.
 * Version: 1.0.0
 * Author: Lauri Liimatta
 * Author URI: http://lauriliimatta.com
 * License: GPL2
 */

function age_verification_popup() {
    if(!isset($_COOKIE['age_verification'])) { ?>
        <div class="age-verification-overlay">
            <div class="age-verification-popup">
                <p class="age-verification-q"><?php _e('Are you 18 or older?', 'age-verification'); ?></p>
                <p>
                    <a class="age-verification-btn age-verification-btn-no" href="https://google.com"><?php _e('No', 'age-verification'); ?></a>
                    <a class="age-verification-btn age-verification-btn-yes" href="#"><?php _e('Yes', 'age-verification'); ?></a>
                </p>
            </div>
        </div>
    <?php }
}
add_action('wp_footer', 'age_verification_popup');

function age_verification_assets() {
    wp_enqueue_script( 'age-verification', plugins_url( '/age-verification.js', __FILE__ ), array('jquery'));
    wp_enqueue_style( 'age-verification', plugins_url( '/age-verification.css', __FILE__) );

    $nonce = wp_create_nonce( 'age-verification' );
    wp_localize_script( 'age-verification', 'my_ajax_obj', array(
       'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => $nonce,
    ) );
}
add_action('init', 'age_verification_assets');

function set_age_verification_cookie() {
    check_ajax_referer( 'age-verification' );

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { 
        setcookie('age_verification', true, time()+(3600*12), COOKIEPATH, COOKIE_DOMAIN );
    }
    die();
}
add_action('wp_ajax_set_age_verification_cookie', 'set_age_verification_cookie');
add_action('wp_ajax_nopriv_set_age_verification_cookie', 'set_age_verification_cookie');
?>