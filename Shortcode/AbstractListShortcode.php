<?php

abstract class AbstractListShortcode
{
    public function fetchRideData(int $year, int $month, int $day = null, string $citySlug = null, string $regionSlug = null): ?array
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

    public function sortRideList(array $rideList, $sortFunction): array
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
}
