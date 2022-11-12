<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CityAndCountryCommand extends Command
{
    private WeatherUtil $weatherUtil;
    protected static $defaultName = 'CityAndCountryCommand';
    protected static $defaultDescription = 'Get a city!';

    public function __construct(WeatherUtil $weatherUtil)
    {
        $this->weatherUtil = $weatherUtil;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('city', null, InputOption::VALUE_REQUIRED, 'City name')
            ->addArgument('country', null, InputOption::VALUE_REQUIRED, 'country code');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $cityArg = $input->getArgument('city');
        $countryArg = $input->getArgument('country');

        if (!$cityArg) {
            $io->error("Need city name");
            return -1;
        }

        if (!$countryArg) {
            $io->error("Need country code");
            return -1;
        }

        $results = $this->weatherUtil->getWeatherForCountryAndCity($cityArg);

        if (count($results) == 0) {
            $io->error("No results");
            return -1;
        }
        $data = array();
        foreach ($results as $result) {
            $returnObj = [
                'id' => $result->getId(),
                'date' => $result->getDate(),
                'celsius' => $result->getCelsius(),
            ];
            array_push($data, $returnObj);
        }

        $output->writeln(json_encode($data));

        $io->success('Success :)');

        return Command::SUCCESS;
    }
}
