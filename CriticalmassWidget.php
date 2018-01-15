<?php

class CriticalmassWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(false,  __('Critical Mass', 'caldera_criticalmass'));
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
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'caldera_luft_widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('citySlug'); ?>"><?php _e('City:', 'caldera_luft_widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('citySlug'); ?>" name="<?php echo $this->get_field_name('citySlug'); ?>" type="text" value="<?php echo $citySlug; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('intro'); ?>"><?php _e('Intro:', 'caldera_luft_widget'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('intro'); ?>" name="<?php echo $this->get_field_name('intro'); ?>"><?php echo $intro; ?></textarea>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['citySlug'] = strip_tags($new_instance['citySlug']);
        $instance['station'] = strip_tags($new_instance['station']);
        return $instance;
    }

    function widget($args, $instance)
    {
        echo "LALALALA";
        die;
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $intro = $instance['intro'];
        $station = $instance['station'];
        $luftData = $this->fetchData($station);
        if (!$luftData) {
            return;
        }
        echo $before_widget;
        if ($title) {
            echo $before_title . $title . $after_title;
        }
        echo '<div class="widget-text wp_widget_plugin_box">';
        if ($intro) {
            echo sprintf('<p class="widget-text">%s</p>', $intro);
        }
        echo '<table>';
        foreach ($luftData as $data) {
            $pollutionLevelClass = sprintf('pollutant pollution-level-%d', $data->pollution_level);
            $row = '<tr class="%s"><td>%s</td><td ><a href="https://luft.jetzt/%s">%s %s</a></td></tr>';
            echo sprintf($row, $pollutionLevelClass, $data->pollutant->name, $station, $data->data->value, $data->pollutant->unit_html);
        }
        echo '</table>';
        echo '<p style="text-align: center;"><small>Luftdaten vom <a href="https://www.umweltbundesamt.de/daten/luftbelastung/aktuelle-luftdaten" title="Umweltbundesamt">Umweltbundesamt</a>, aufbereitet von <a href="https://luft.jetzt/">Luft<sup>jetzt</sup></a></small>';
        echo '</div>';
        echo $after_widget;
    }
    protected function fetchData(string $stationCode): ?array
    {
        $apiUrl = sprintf('https://luft.jetzt/api/%s', $stationCode);
        $response = wp_remote_get($apiUrl);
        $responseCode = $response['response']['code'];
        if (200 !== $responseCode) {
            return null;
        }
        $data = json_decode($response['body']);
        return $data;
    }
}
