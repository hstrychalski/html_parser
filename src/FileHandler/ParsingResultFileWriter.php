<?php

namespace App\FileHandler;

use App\Model\ParsingResultInterface;

/**
 * Class ParsingResultFileWriter
 * @package App\Parser
 */
class ParsingResultFileWriter
{
    const RESULT_FILE_EXTENSION = '.csv';

    /**
     * @param ParsingResultInterface[] $parsingResults
     * @param string $fileName
     */
    public function writeParsingResultsToCsvFile(array $parsingResults, string $fileName)
    {
        $csvFile = fopen(PARSING_RESULTS_PATH . $fileName . self::RESULT_FILE_EXTENSION, 'w');
        foreach ($parsingResults as $key => $parsingResult) {
            if ($key === 0) {
                fputcsv($csvFile, $parsingResult->getFileHeaders());
            }
            fputcsv($csvFile, $parsingResult->toArray());
        }
        fclose($csvFile);
    }
}