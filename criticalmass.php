<?php
/*
Plugin Name: Critical Mass
Plugin URI: https://criticalmass.one/
Description: Show critical mass related stuff in your blog
Version: 0.1
Author: Malte Hübner
Author URI: https://maltehuebner.de
License: MIT
*/

require_once __DIR__.'/shortcodes.php';
require_once __DIR__.'/CriticalmassWidget.php';

add_action('init', function() {
    add_shortcode('criticalmass-ride-list', 'criticalmassRideList');
    add_shortcode('criticalmass-estimate-list', 'criticalmassEstimateList');
    wp_enqueue_script('criticalmass-script',  plugin_dir_url( __FILE__ ) . '/js/criticalmass.js', ['jquery'], 0.1, true);
});

add_action('widgets_init', function() {
    register_widget('CriticalmassWidget');
});
