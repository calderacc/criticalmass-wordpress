<?php
/*
Plugin Name: Caldera Critical Mass
Plugin URI: https://criticalmass.in/
Description: Show critical mass related stuff in your blog
Version: 1.1
Author: Malte Hübner
Author URI: https://maltehuebner.de
License: GPL2+
License URI: https://www.gnu.org/licenses/gpl-2.0.txt
*/

use Caldera\CriticalmassWordpress\Autoloader;
use Caldera\CriticalmassWordpress\Shortcode\RideListShortcode;
use Caldera\CriticalmassWordpress\Widget\CriticalmassWidget;

require_once __DIR__.'/Autoloader.php';

spl_autoload_register([new Autoloader(), 'autoload']);

add_action('init', function() {
    add_shortcode('criticalmass-ride-list', [new RideListShortcode(), 'rideList']);

    wp_enqueue_script('criticalmass-script',  sprintf('%s/js/criticalmass.js', plugin_dir_url( __FILE__ )), ['jquery'], '0.1', true);
    wp_enqueue_script( 'leaflet-script', sprintf('%s/js/leaflet.js', plugin_dir_url( __FILE__ )), [], '1.3.1', false);
    wp_enqueue_style('leaflet-style', sprintf('%s/css/leaflet.css', plugin_dir_url( __FILE__ )), [], '1.3.1');
});

add_action('widgets_init', function() {
    register_widget(CriticalmassWidget::class);
});
