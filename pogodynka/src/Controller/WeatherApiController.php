<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use App\Service\WeatherUtil;
use App\Entity\Measurement;
use Symfony\Component\HttpFoundation\Response;

class WeatherApiController extends AbstractController
{
    public function __construct(private WeatherUtil $WeatherUtil)
    {
    }

    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(#[MapQueryParameter] string $city,#[MapQueryParameter] string $country,#[MapQueryParameter] string $format, #[MapQueryParameter] bool $twig = false,): Response
    {
        $measurements = $this->WeatherUtil->getWeatherForCountryAndCity($country, $city);
        
        if ($format === 'json') {
            if($twig){
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements[1],
                ]);
                
            }

            return $this->json([
                'city' => $city,
                'country' => $country,
                'measurements' => array_map(fn(Measurement $m) => [
                    'date' => $m->getDate()->format('Y-m-d'),
                    'celsius' => $m->getCelsius(),
                    'fahrenheit' => $m->getFahrenheit()
                ], $measurements[1]),
            ]);
        }

        if ($format === 'csv') {
            if($twig){
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements[1],
                ]);
                
            }

            $csv = 'city,country,date,celcius,fahrenheit';
            foreach ($measurements[1] as $measurement) {
                $csv .= sprintf(
                    '%s,%s,%s,%s,%s',
                    $city,
                    $country,
                    $measurement->getDate()->format('Y-m-d'),
                    $measurement->getCelsius(),
                    $measurement->getFahrenheit()
                ) . '<br>';
            }

            return new Response($csv);
        }

    }
}
