<?php

require_once __DIR__.'/AbstractListShortcode.php';
require_once __DIR__.'/../Util/LinkUtil.php';
require_once __DIR__.'/../Exception/InvalidParameterException.php';

class RideListShortcode extends AbstractListShortcode
{
    /** @var array $atts */
    protected $atts = [];

    public function rideList($attributeList = [], $content = null, $tag = '')
    {
        try {
            $attributeList = array_change_key_case((array)$attributeList, CASE_LOWER);

            $this->atts = $this->validateAttributes($attributeList, $tag);

            $o = '<table>';

            $o .= $this->createTableHeader();

            $rideList = $this->getRideList();

            /** @var Ride $ride */
            foreach ($rideList as $ride) {
                $o .= $this->createTableRow($ride);
            }

            $o .= '</table>';
        } catch (\Exception $exception) {
            $o = sprintf('<code>Fehler beim Rendern der Critical-Mass-Tourenliste: %s</code>', $exception->getMessage());
        }

        return $o;
    }

    protected function createTableHeader(): string
    {
        $headerRow = '<tr>';

        if ($this->showColumn('city')) {
            $headerRow .= '<th>Stadt</th>';
        }

        if ($this->showColumn('datetime')) {
            $headerRow .= '<th>Datum</th>';
        }

        if ($this->showColumn('location')) {
            $headerRow .= '<th>Treffpunkt</th>';
        }

        if ($this->showColumn('estimation')) {
            $headerRow .= '<th>Teilnehmer</th>';
        }

        $headerRow .= '</tr>';

        return $headerRow;

    }

    protected function createTableRow(Ride $ride): string
    {
        $timezone = new \DateTimeZone($this->atts['timezone']);

        $row = '<tr>';

        if ($this->showColumn('city')) {
            $row .= sprintf('<td><a href="%s">%s</a></td>', LinkUtil::createLinkForCity($ride->getCity()), $ride->getCity()->getName());
        }

        if ($this->showColumn('datetime')) {
            $row .= sprintf('<td><a href="%s">%s</a></td>', LinkUtil::createLinkForRide($ride), $ride->getDateTime()->setTimezone($timezone)->format($this->atts['date-format']));
        }

        if ($this->showColumn('location')) {
            $row .= sprintf('<td>%s</td>', $ride->getLocation());
        }

        if ($this->showColumn('estimation')) {
            if ($ride->getEstimatedParticipants()) {
                $row .= sprintf('<td>%s</td>', $ride->getEstimatedParticipants());
            } else {
                $row .= sprintf('<td><a class="criticalmass-estimate-link" href="%s">ergänzen</a></td>', LinkUtil::createLinkForRideEstimate($ride));
            }
        }

        $row .= '</tr>';

        return $row;
    }

    protected function showColumn(string $col): bool
    {
        $value = $this->atts[sprintf('col-%s', $col)];

        return $value === 'true' || $value === true;
    }

    protected function getRideList(): array
    {
        $rideList = $this->rideFactory->fetchRideData($this->atts['year'], $this->atts['month'], $this->atts['day'], $this->atts['city'], $this->atts['region']);

        $rideList = $this->rideFactory->sortRideList($rideList, $this->atts['sort']);

        return $rideList;
    }

    protected function validateAttributes(array $attributeList = [], string $tag = ''): array
    {
        $atts = shortcode_atts([
            'year' => null,
            'month' => null,
            'day' => null,
            'city' => null,
            'region' => null,
            'sort' => 'city',
            'timezone' => get_option('timezone_string'),
            'col-estimation' => false,
            'col-location' => true,
            'col-datetime' => true,
            'col-city' => true,
            'date-format' => 'd.m.Y H:i',
        ], $attributeList, $tag);

        if (!is_integer($atts['year']) && !is_null($atts['year'])) {
            throw new InvalidParameterException(sprintf('Ungültige Jahresangabe: %s', $atts['year']));
        }

        if (!is_integer($atts['month']) && !is_null($atts['month'])) {
            throw new InvalidParameterException(sprintf('Ungültige Monatssangabe: %s', $atts['month']));
        }

        if (!is_integer($atts['day']) && !is_null($atts['day'])) {
            throw new InvalidParameterException(sprintf('Ungültige Tagesangabe: %s', $atts['day']));
        }

        try {
            $timezone = new \DateTimeZone($atts['timezone']);
        } catch (\Exception $e) {
            throw new InvalidParameterException(sprintf('Ungültige Zeitzone: %s', $atts['timezone']));
        }

        return $atts;
    }
}
