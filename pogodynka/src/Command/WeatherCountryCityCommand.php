<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;
use App\Repository\LocationRepository;

#[AsCommand(
    name: 'weather:CountryCity',
    description: 'Add a short description for your command',
)]
class WeatherCountryCityCommand extends Command
{
    private $weatherUtil;
    private $locationRepository;

    public function __construct(WeatherUtil $util, LocationRepository $locationRepository)
    {
        $this->weatherUtil = $util;
        $this->locationRepository = $locationRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('Country', InputArgument::REQUIRED, 'Country code')
            ->addArgument('City', InputArgument::REQUIRED, 'City name')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $Country = $input->getArgument('Country');
        $City =$input->getArgument('City');

        $LocationMeasurementsArray = $this->weatherUtil->getWeatherForCountryAndCity($Country, $City);
        $location = $LocationMeasurementsArray[0];
        $measurements = $LocationMeasurementsArray[1];

        $io->writeln(sprintf("\t%s: %s ; %s: %s",
            $location->getCity(),
            $location->getCountry(),
            $location->getLatitude(),
            $location->getLongitude()
        ));

        return Command::SUCCESS;

    }
}
