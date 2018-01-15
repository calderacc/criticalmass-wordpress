<?php

function criticalmassRideList($attributeList = [], $content = null, $tag = '')
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

    $rideList = fetchRideData($atts['year'], $atts['month'], $atts['day'], $atts['city'], $atts['region']);

    $rideList = sortRideList($rideList, $atts['sort']);

    $timezone = new \DateTimeZone($atts['timezone']);

    foreach ($rideList as $ride) {
        $dateTime = new \DateTime(sprintf('@%d', $ride->dateTime));
        $dateTime->setTimezone($timezone);

        $cityLink = sprintf('https://criticalmass.in/%s', $ride->city->mainSlug->slug);
        $rideLink = sprintf('https://criticalmass.in/%s/%s', $ride->city->mainSlug->slug, $dateTime->format('Y-m-d'));

        $o .= sprintf(
            '<tr><td><a href="%s">%s</a></td><td><a href="%s">%s Uhr</a></td><td>%s</td><td>%s</td></tr>',
            $cityLink,
            $ride->city->name,
            $rideLink,
            $dateTime->format('d.m.Y H:i'),
            $ride->location
        );
    }

    $o .= '</table>';

    return $o;
}

function criticalmassEstimateList($attributeList = [], $content = null, $tag = '')
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

    $rideList = fetchRideData($atts['year'], $atts['month'], $atts['day'], $atts['city'], $atts['region']);

    $rideList = sortRideList($rideList, $atts['sort']);

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

function fetchRideData(int $year, int $month, int $day = null, string $citySlug = null, string $regionSlug = null): ?array
{
    $parameters = [
        'year' => $year,
        'month' => $month,
        'day' => $day,
        'city' => $citySlug,
        'region' => $regionSlug,
    ];

    $apiUrl = sprintf('https://criticalmass.in/api/ride/?%s', http_build_query($parameters));

    $response = wp_remote_get($apiUrl);

    $responseCode = $response['response']['code'];

    if (200 !== $responseCode) {
        return null;
    }

    $data = json_decode($response['body']);

    return $data;
}

function sortRideList(array $rideList, $sortFunction): array
{
    $sortFunctionList = [
        'city' => function($a, $b) {
            return $a->city->name > $b->city->name;
        },
        'date' => function($a, $b) {
            return $a->dateTime > $b->dateTime;
        }
    ];

    if (array_key_exists($sortFunction, $sortFunctionList)) {
        usort($rideList, $sortFunctionList[$sortFunction]);
    }

    return $rideList;
}
