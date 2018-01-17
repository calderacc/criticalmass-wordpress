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

        $rideList = $this->rideFactory->fetchRideData($atts['year'], $atts['month'], $atts['day'], $atts['city'], $atts['region']);

        $rideList = $this->rideFactory->sortRideList($rideList, $atts['sort']);

        $timezone = new \DateTimeZone($atts['timezone']);

        /** @var Ride $ride */
        foreach ($rideList as $ride) {
            $estimateLink = sprintf('<a class="criticalmass-estimate-link" href="%s">ergänzen</a>', LinkUtil::createLinkForRideEstimate($ride));

            $o .= sprintf(
                '<tr><td><a href="%s">%s</a></td><td><a href="%s">%s</a></td><td>%s</td></tr>',
                LinkUtil::createLinkForCity($ride->getCity()),
                $ride->getCity()->getName(),
                LinkUtil::createLinkForRide($ride),
                $ride->getDateTime()->setTimezone($timezone)->format('d.m.Y'),
                $ride->getEstimatedParticipants() ? $ride->getEstimatedParticipants() : $estimateLink
            );
        }

        $o .= '</table>';

        return $o;
    }
}
