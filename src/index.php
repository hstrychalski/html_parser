<?php

require __DIR__ . '/../vendor/autoload.php';
require_once '../vendor/simple-html-dom/simple-html-dom/simple_html_dom.php';

$config = include '../config.php';
define('PARSING_RESULTS_PATH', $config['parsing_results_path']);

use App\Parser\CityPharmaciesFetcher;
use App\Parser\SimpleHtmlDomWrapper;
use App\FileHandler\ParsingResultFileWriter;

$fetcher = new CityPharmaciesFetcher(new SimpleHtmlDomWrapper());
$cityPharmacies =  $fetcher->fetchPharmaciesByCity($config['city_name']);
$fileWriter = new ParsingResultFileWriter();
$fileWriter->writeParsingResultsToCsvFile($cityPharmacies, 'test_numer_1');
