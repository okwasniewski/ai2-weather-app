<?php

namespace App\Service;

use App\Entity\Location;
use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;

class WeatherUtil
{
    private $locationRepository;
    private $measurementRepository;

    public function __construct(LocationRepository $locationRepository, MeasurementRepository $measurementRepository)
    {
        $this->locationRepository = $locationRepository;
        $this->measurementRepository = $measurementRepository;
    }

    public function getWeatherForCountryAndCity($city)
    {
        $location = $this->locationRepository->findByLocation($city);
        $measurements = $this->getWeatherForLocation($location);
        $result = [
            "location" => $city,
            "measurements" => $measurements
        ];
        return $result;
    }

    public function getWeatherForLocation($location)
    {
        $measurements = $this->measurementRepository->findByLocation($location);
        return $measurements;
    }
}
