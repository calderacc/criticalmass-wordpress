<?php

class CriticalmassWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct('critical-mass-widget',  __('Critical Mass', 'caldera_criticalmass'));
    }

    public function form($instance)
    {
        if( $instance) {
            $title = esc_attr($instance['title']);
            $citySlug = esc_attr($instance['citySlug']);
            $intro = esc_attr($instance['intro']);
        } else {
            $title = '';
            $citySlug = '';
            $intro = '';
        }

        $cityList = $this->buildCitySelectList();

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel', 'caldera_criticalmass_widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('citySlug'); ?>"><?php _e('Stadt:', 'caldera_criticalmass_widget'); ?></label>
            <select id="<?php echo $this->get_field_id('citySlug'); ?>" name="<?php echo $this->get_field_name('citySlug'); ?>" class="widefat" style="width:100%;">
                <?php

                foreach ($cityList as $slug => $city) {
                    echo '<option ' . selected($instance['citySlug'], $citySlug) .' value="' . $slug .'">' . $city . '</option>';
                }

                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('intro'); ?>"><?php _e('Intro:', 'caldera_criticalmass_widget'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('intro'); ?>" name="<?php echo $this->get_field_name('intro'); ?>"><?php echo $intro; ?></textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['citySlug'] = strip_tags($new_instance['citySlug']);
        $instance['intro'] = strip_tags($new_instance['intro']);
        return $instance;
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $intro = apply_filters('widget_title', $instance['intro']);
        $citySlug = $instance['citySlug'];

        $rideData = $this->fetchRideData($citySlug);

        if (!$rideData) {
            return;
        }

        $rideDateTime = new \DateTime(sprintf('@%d', $rideData->dateTime));
        $rideDateTime->setTimezone($rideData->city->timezone);

        $rideLink = sprintf('https://criticalmass.in/%s/%s', $citySlug, $rideDateTime->format('Y-m-d'));

        echo $before_widget;

        if ($title) {
            echo $before_title . $title . $after_title;
        }

        echo '<div class="widget-text wp_widget_plugin_box">';

        if ($intro) {
            echo sprintf('<p class="widget-text">%s</p>', $intro);
        }

        echo '<p><a href="'.$rideLink.'"><strong>'.$rideData->title.'</strong></a><br /><strong>Datum:</strong> '.$rideDateTime->format('d.m.Y H:i').' Uhr<br /><strong>Treffpunkt:</strong> '.$rideData->location.'</p>';

        echo '</div>';

        echo $after_widget;
    }

    protected function fetchRideData(string $citySlug): ?\stdClass
    {
        $apiUrl = sprintf('https://criticalmass.in/api/%s/current', $citySlug);
        $response = wp_remote_get($apiUrl);
        $responseCode = $response['response']['code'];

        if (200 !== $responseCode) {
            return null;
        }

        $data = json_decode($response['body']);

        return $data;
    }

    protected function fetchCityList(): ?array
    {
        $apiUrl = sprintf('https://criticalmass.in/api/city');
        $response = wp_remote_get($apiUrl);
        $responseCode = $response['response']['code'];

        if (200 !== $responseCode) {
            return null;
        }

        $data = json_decode($response['body']);

        return $data;
    }

    protected function buildCitySelectList(): array
    {
        $cityList = $this->fetchCityList();
        $selectList = [];

        foreach ($cityList as $city) {
            $citySlug = $city->slug;
            $city = $city->name;

            $selectList[$citySlug] = $city;
        }

        return $selectList;
    }
}
