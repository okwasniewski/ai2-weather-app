<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WeatherApiController extends AbstractController
{
    #[Route('/weather/api/', name: 'weather_in_city_api', methods: ['GET', 'POST'])]
    public function apiAction(Request $request, WeatherUtil $weatherUtil): Response
    {

        $payload = $request->toArray();
        $result = $weatherUtil->getWeatherForCountryAndCity($payload['city']);

        $res = [];
        if ($payload['type'] == 'json') {
            foreach ($result as $weather) {
                $res = [
                    "celsius" => $weather->getCelsius(),
                    "fahrenheit" => $weather->getFahrenheit(),
                ];
            }
            return new JsonResponse($res);
        }

        if ($payload['type'] == 'csv') {
            $csv = "";
            foreach ($result as $weather) {
                $res = [
                    "celsius" => $weather->getCelsius(),
                    "fahrenheit" => $weather->getFahrenheit(),
                ];
                $csv .= implode(',', $res) . "\n";
            }
            return new Response($csv);
        }
    }

    public function weatherApiAction(WeatherUtil $weatherUtil, $type, $city): Response
    {
        $result = $weatherUtil->getWeatherForCountryAndCity($city);

        return $this->render("weather_api/weather.{$type}.twig", [
            "city" => $city,
            "measurements" => $result['measurements'],
        ]);
    }
}
