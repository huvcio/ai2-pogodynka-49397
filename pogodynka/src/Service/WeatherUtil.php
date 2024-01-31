<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use Doctrine\ORM\EntityManagerInterface;

class WeatherUtil
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->entityManager->getRepository(Measurement::class)->findByLocation($location);
    }

    /**
     * @return array An array containing multiple values:
    *               - '$location': Location
    *               - 'Measurement[]': Array of measurements
    */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->entityManager->getRepository(Location::class)->findLocationByCountryandCity($countryCode, $city)[0];
        $measurements = $this->getWeatherForLocation($location);
        return [$location, $measurements];
    }
}
