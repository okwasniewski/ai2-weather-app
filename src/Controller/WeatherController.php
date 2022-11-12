<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{
    public function cityAction(Location $city, WeatherUtil $weatherUtil): Response
    {
        $renderData = $weatherUtil->getWeatherForCountryAndCity($city);
        return $this->render('weather/city.html.twig', $renderData);
    }
}
