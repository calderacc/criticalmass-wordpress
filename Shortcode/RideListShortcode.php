<?php

require_once __DIR__.'/AbstractListShortcode.php';
require_once __DIR__.'/../Util/LinkUtil.php';

class RideListShortcode extends AbstractListShortcode
{
    public function rideList($attributeList = [], $content = null, $tag = '')
    {
        $attributeList = array_change_key_case((array)$attributeList, CASE_LOWER);

        $atts = shortcode_atts([
            'year' => date('Y'),
            'month' => date('m'),
            'day' => null,
            'city' => null,
            'region' => null,
            'sort' => 'city',
            'timezone' => get_option('timezone_string'),
            'col-estimation' => false,
            'col-location' => true,
            'col-datetime' => true,
            'col-city' => true,
        ], $attributeList, $tag);

        $o = '<table>';

        $o .= $this->createTableHeader($atts);

        if (!is_null($content)) {
            $o .= apply_filters('the_content', $content);
            $o .= do_shortcode($content);
        }

        $rideList = $this->rideFactory->fetchRideData($atts['year'], $atts['month'], $atts['day'], $atts['city'], $atts['region']);

        $rideList = $this->rideFactory->sortRideList($rideList, $atts['sort']);

        /** @var Ride $ride */
        foreach ($rideList as $ride) {
            $o .= $this->createTableRow($ride, $atts);
        }

        $o .= '</table>';

        return $o;
    }

    protected function createTableHeader(array $atts = []): string
    {
        $headerRow = '<tr>';

        if ($atts['col-city']) {
            $headerRow .= '<th>Stadt</th>';
        }

        if ($atts['col-datetime']) {
            $headerRow .= '<th>Datum</th>';
        }

        if ($atts['col-location']) {
            $headerRow .= '<th>Treffpunkt</th>';
        }

        if ($atts['col-estimation']) {
            $headerRow .= '<th>Teilnehmer</th>';
        }

        $headerRow .= '</tr>';

        return $headerRow;

    }

    protected function createTableRow(Ride $ride, array $atts = []): string
    {
        $timezone = new \DateTimeZone($atts['timezone']);

        $row = '<tr>';

        if ($atts['col-city']) {
            $row .= sprintf('<td><a href="%s">%s</a></td>', LinkUtil::createLinkForCity($ride->getCity()), $ride->getCity()->getName());
        }

        if ($atts['col-datetime']) {
            $row .= sprintf('<td><a href="%s">%s Uhr</a></td>', LinkUtil::createLinkForRide($ride), $ride->getDateTime()->setTimezone($timezone)->format('d.m.Y H:i'));
        }

        if ($atts['col-location']) {
            $row .= sprintf('<td>%s</td>', $ride->getLocation());
        }

        if ($atts['col-estimation']) {
            if ($ride->getEstimatedParticipants()) {
                $row .= sprintf('<td>%s</td>', $ride->getEstimatedParticipants());
            } else {
                $row .= sprintf('<td><a class="criticalmass-estimate-link" href="%s">ergänzen</a></td>', LinkUtil::createLinkForRideEstimate($ride));
            }

        }

        $row .= '</tr>';

        return $row;
    }
}
