<?php

namespace App\Parser;

use App\Model\PharmacyModel;
use App\Dictionary\TargetFieldsDictionary;
use simple_html_dom;

/**
 * Class CityPharmaciesFetcher
 */
class CityPharmaciesFetcher
{
    const CITY_PHARMACIES_BASE_URL = 'https://waptek.pl/miasto/';

    const SINGLE_PHARMACY_BASE_URL = 'https://waptek.pl/';

    const PHARMACIES_LIST_TABLE_SELECTOR = '[class="table top-ten"] tr td';

    const PHARMACY_INFO_DIV_SELECTOR = '[class="col-md-6 col-sm-12 col-xs-12"]';

    const PHARMACY_INFO_TABLE_SELECTOR = '[class="table"] tr td';

    /**
     * @var SimpleHtmlDomWrapper
     */
    private $simpleHtmlDomWrapper;

    /**
     * CityPharmaciesFetcher constructor.
     * @param SimpleHtmlDomWrapper $simpleHtmlDomWrapper
     */
    public function __construct(SimpleHtmlDomWrapper $simpleHtmlDomWrapper)
    {
        $this->simpleHtmlDomWrapper = $simpleHtmlDomWrapper;
    }

    /**
     * @param string $city
     * @return PharmacyModel[]
     */
    public function fetchPharmaciesByCity(string $city): array
    {
        $url = self::CITY_PHARMACIES_BASE_URL . $city;
        $pharmaciesListPageHtml = $this->simpleHtmlDomWrapper->getHtmlDomFromFile($url);
        $pharmaciesIds = $this->fetchPharmaciesIds($pharmaciesListPageHtml);
        $pharmacyModels = [];
        foreach ($pharmaciesIds as $pharmacyId) {
            $pharmacyModel =  $this->fetchPharmacyDetails($pharmacyId);
            $pharmacyModels[] = $pharmacyModel;
        }
        return $pharmacyModels;
    }

    /**
     * @param simple_html_dom $pharmaciesListPageHtml
     * @return string[]
     */
    public function fetchPharmaciesIds(simple_html_dom $pharmaciesListPageHtml): array
    {
        $pharmaciesListTable = $pharmaciesListPageHtml->find(self::PHARMACIES_LIST_TABLE_SELECTOR);
        $pharmaciesIds = [];

        foreach ($pharmaciesListTable as $key => $pharmacy) {
            if ($key % 2 === 0 ) {
                $trimmed = substr($pharmacy, 4);
                $matches = [];
                preg_match('/(?<=href=\/)(.*?)(?=>)/', $trimmed, $matches);

                if (count($matches) > 0) {
                    $pharmacyId = $matches[0];
                    $pharmaciesIds[] = $pharmacyId;
                }

            }
        }
        return $pharmaciesIds;
    }

    /**
     * @param string $pharmacyId
     * @return PharmacyModel
     */
    public function fetchPharmacyDetails(string $pharmacyId): PharmacyModel
    {
        $url = self::SINGLE_PHARMACY_BASE_URL . $pharmacyId;
        $pharmacyHtml = $this->simpleHtmlDomWrapper->getHtmlDomFromFile($url);
        $pharmacyHtmlData = $pharmacyHtml->find(self::PHARMACY_INFO_TABLE_SELECTOR);
        $parsedPharmacyData = $this->pharmacyHtmlDataToArray($pharmacyHtmlData);

        $pharmacyModel = new PharmacyModel();
        $pharmacyModel->setPharmacyId($pharmacyId);

        foreach ($parsedPharmacyData as $key => $field) {
            $match = array_intersect(TargetFieldsDictionary::getTargetFields(), [$field]);
            if (count($match) === 0) {
                continue;
            }

            $match = array_shift($match);
            $targetValueIndex = $key + 1;

            switch ($match) {
                case TargetFieldsDictionary::KEY_NAME:
                    $pharmacyModel->setPharmacyName($parsedPharmacyData[$targetValueIndex]);
                    break;
                case TargetFieldsDictionary::KEY_ADDRESS:
                    $pharmacyModel->setPharmacyAddress($parsedPharmacyData[$targetValueIndex]);
                    break;
                case TargetFieldsDictionary::KEY_REGON:
                    $pharmacyModel->setRegon($parsedPharmacyData[$targetValueIndex]);
                    break;
                case TargetFieldsDictionary::KEY_NIP:
                    $pharmacyModel->setNip($parsedPharmacyData[$targetValueIndex]);
                    break;
                case TargetFieldsDictionary::KEY_KRS:
                    $pharmacyModel->setKrs($parsedPharmacyData[$targetValueIndex]);
                    break;
            }
        }
        return $pharmacyModel;
    }

    /**
     * @param array $pharmacyHtmlData
     * @return string[]
     */
    private function pharmacyHtmlDataToArray(array $pharmacyHtmlData): array
    {
        $parsedPharmacyInfo = [];
        foreach ($pharmacyHtmlData as $field) {
            $parsedPharmacyInfo[] = $field->plaintext;
        }
        return $parsedPharmacyInfo;
    }
}