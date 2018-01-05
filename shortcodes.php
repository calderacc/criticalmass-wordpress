<?php

function criticalmassRideList($attributeList = [], $content = null, $tag = '')
{
    $attributeList = array_change_key_case((array)$attributeList, CASE_LOWER);

    $atts = shortcode_atts([
        'title' => 'WordPress.org',
        'month' => date('m'),
        'year' => date('Y'),
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

    $rideList = fetchRideData($atts['year'], $atts['month']);

    foreach ($rideList as $ride) {
        $o .= sprintf('<tr><td>%s</td><td>%s Uhr</td><td>%s</td></tr>', $ride->city->name, date('d.m.Y H:i', $ride->dateTime), $ride->location);
    }

    $o .= '</table>';

    return $o;
}

function fetchRideData(int $year, int $month): ?array
{
    $apiUrl = sprintf('https://criticalmass.in/api/ride/list');

    $response = wp_remote_get($apiUrl);

    $responseCode = $response['response']['code'];

    if (200 !== $responseCode) {
        return null;
    }

    $data = json_decode($response['body']);

    return $data;
}
