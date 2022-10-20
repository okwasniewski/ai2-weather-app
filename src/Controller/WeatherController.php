<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WeatherController extends AbstractController
{
    public function cityAction(Location $city, MeasurementRepository $measurementRepository): Response
    {
        $measurements = $measurementRepository->findByLocation($city);

        return $this->render('weather/city.html.twig', [
            'location' => $city,
            'measurements' => $measurements,
        ]);
    }
}
