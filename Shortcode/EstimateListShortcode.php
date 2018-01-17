<?php

require_once __DIR__.'/AbstractListShortcode.php';

class EstimateListShortcode extends AbstractListShortcode
{
    public function estimateList($attributeList = [], $content = null, $tag = '')
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
        $o .= '<tr><th>Stadt</th><th>Datum</th><th>Teilnehmer</th></tr>';

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

            $rideDate = $dateTime->format('Y-m-d');
            $citySlug = $ride->city->mainSlug->slug;

            $cityLink = sprintf('https://criticalmass.in/%s', $citySlug);
            $rideLink = sprintf('https://criticalmass.in/%s/%s', $citySlug, $rideDate);
            $estimateLink = sprintf('https://criticalmass.in/%s/%s/anonymousestimate', $citySlug, $rideDate);

            $estimateLink = sprintf('<a class="criticalmass-estimate-link" href="%s" data-city-slug="%s" data-ride-date="%s">ergänzen</a>', $estimateLink, $citySlug, $rideDate);

            $o .= sprintf(
                '<tr><td><a href="%s">%s</a></td><td><a href="%s">%s</a></td><td>%s</td></tr>',
                $cityLink,
                $ride->city->name,
                $rideLink,
                $dateTime->format('d.m.Y'),
                $ride->estimatedParticipants ? $ride->estimatedParticipants : $estimateLink
            );
        }

        $o .= '</table>';

        return $o;
    }
}
