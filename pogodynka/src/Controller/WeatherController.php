<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\WeatherUtil;

class WeatherController extends AbstractController
{
    #[Route('/weather/{Country}/{City}', name: 'app_weather')]
    public function city(string $Country, string $City, WeatherUtil $util): Response
    {
        $locationMesurementArray = $util->getWeatherForCountryAndCity($Country, $City);
        $location = $locationMesurementArray[0];
        $measurements = $locationMesurementArray[1];

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);

    }
}
