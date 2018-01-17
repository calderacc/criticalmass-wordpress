<?php

require_once __DIR__.'/AbstractListShortcode.php';

class RideListShortcode extends AbstractListShortcode
{
    public function rideList($attributeList = [], $content = null, $tag = '')
    {
        $attributeList = array_change_key_case((array)$attributeList, CASE_LOWER);

        $atts = shortcode_atts([
            'title' => 'WordPress.org',
            'year' => date('Y'),
            'month' => date('m'),
            'day' => null,
            'city' => null,
            'region' => null,
            'sort' => 'city',
            'timezone' => get_option('timezone_string'),
        ], $attributeList, $tag);

        // start output
        $o = '<table>';

        // start box
        $o .= '<tr><th>Datum</th><th>Stadt</th><th>Treffpunkt</th></tr>';

        // enclosing tags
        if (!is_null($content)) {
            // secure output by executing the_content filter hook on $content
            $o .= apply_filters('the_content', $content);

            // run shortcode parser recursively
            $o .= do_shortcode($content);
        }

        $rideList = $this->fetchRideData($atts['year'], $atts['month'], $atts['day'], $atts['city'], $atts['region']);

        $rideList = $this->sortRideList($rideList, $atts['sort']);

        $timezone = new \DateTimeZone($atts['timezone']);

        foreach ($rideList as $ride) {
            $dateTime = new \DateTime(sprintf('@%d', $ride->dateTime));

            $dateTime->setTimezone($timezone);

            $cityLink = sprintf('https://criticalmass.in/%s', $ride->city->mainSlug->slug);
            $rideLink = sprintf('https://criticalmass.in/%s/%s', $ride->city->mainSlug->slug, $dateTime->format('Y-m-d'));

            $row = sprintf(
                '<tr><td><a href="%s">%s</a></td><td><a href="%s">%s Uhr</a></td><td>%s</td></tr>',
                $cityLink,
                $ride->city->name,
                $rideLink,
                $dateTime->format('d.m.Y H:i'),
                $ride->location
            );

            $o .= $row;
        }

        $o .= '</table>';

        return $o;
    }
}
