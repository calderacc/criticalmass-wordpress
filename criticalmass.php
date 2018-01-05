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

add_action('init', function() {
    add_shortcode('criticalmass-ride-list', 'criticalmassRideList');
});
