<?php

require_once __DIR__ . '/../Factory/CityFactory.php';
require_once __DIR__ . '/../Factory/RideFactory.php';

class CriticalmassWidget extends WP_Widget
{
    protected $cityFactory;
    protected $rideFactory;

    public function __construct()
    {
        $this->cityFactory = new CityFactory();
        $this->rideFactory = new RideFactory();

        parent::__construct('critical-mass-widget',  __('Critical Mass', 'caldera_criticalmass'));
    }

    public function form($instance)
    {
        if( $instance) {
            $title = esc_attr($instance['title']);
            $intro = esc_attr($instance['intro']);
        } else {
            $title = '';
            $intro = '';
        }

        $cityList = $this->buildCitySelectList();

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel', 'caldera_criticalmass_widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('intro'); ?>"><?php _e('Intro:', 'caldera_criticalmass_widget'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('intro'); ?>" name="<?php echo $this->get_field_name('intro'); ?>"><?php echo $intro; ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('citySlug'); ?>"><?php _e('Stadt:', 'caldera_criticalmass_widget'); ?></label>
            <select id="<?php echo $this->get_field_id('citySlug'); ?>" name="<?php echo $this->get_field_name('citySlug'); ?>" class="widefat" style="width:100%;">
                <?php

                foreach ($cityList as $slug => $city) {
                    echo '<option ' . selected($instance['citySlug'], $slug) .' value="' . $slug .'">' . $city . '</option>';
                }

                ?>
            </select>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['useMap'], 'on'); ?> id="<?php echo $this->get_field_id('useMap'); ?>" name="<?php echo $this->get_field_name('useMap'); ?>" />
            <label for="<?php echo $this->get_field_id('useMap'); ?>"><?php _e('Karte anzeigen', 'caldera_criticalmass_widget'); ?></label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['citySlug'] = strip_tags($new_instance['citySlug']);
        $instance['intro'] = strip_tags($new_instance['intro']);
        $instance['useMap'] = strip_tags($new_instance['useMap']);

        return $instance;
    }

    function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        $intro = apply_filters('widget_title', $instance['intro']);
        $citySlug = $instance['citySlug'];
        $useMap = $instance['useMap'] ? true : false;

        $ride = $this->rideFactory->getCurrentRideForCitySlug($citySlug);

        if (!$ride) {
            return;
        }

        $output = $args['before_widget'];

        if ($title) {
            $output .= sprintf('%s%s%s', $args['before_title'], $title, $args['after_title']);
        }

        $output .= '<div class="widget-text wp_widget_plugin_box">';

        if ($intro) {
            $output .= sprintf('<p class="widget-text">%s</p>', $intro);
        }

        if ($useMap) {
            $output.= '<div id="criticalmass-widget-map" style="height: 225px;" data-title="' .$ride->getTitle() .'" data-city-slug="' .$citySlug .'" data-location="'.$ride->getLocation().'" data-date-time="'. $ride->getDateTime()->format('U').'" data-latitude="'.$ride->getLatitude().'" data-longitude="'.$ride->getLongitude().'"></div>';
        } else {
            $output .= '<p><a href="'.LinkUtil::createLinkForRide($ride).'"><strong>'.$ride->getTitle().'</strong></a><br /><strong>Datum:</strong> '.$ride->getDateTime()->format('d.m.Y H:i').' Uhr<br /><strong>Treffpunkt:</strong> '.$ride->getLocation().'</p>';
        }

        $output .= '</div>';

        $output .= $args['after_widget'];

        echo $output;
    }

    protected function buildCitySelectList(): array
    {
        $cityList = $this->cityFactory->getCityList();
        $selectList = [];

        foreach ($cityList as $city) {
            $citySlug = $city->slug;
            $city = $city->name;

            $selectList[$citySlug] = $city;
        }

        return $selectList;
    }
}