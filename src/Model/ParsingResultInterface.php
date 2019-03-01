<?php

namespace App\Model;

/**
 * Interface ParsingResultInterface
 * @package App\Model
 */
interface ParsingResultInterface
{
    /**
     * @return string[]
     */
    public function toArray() : array;

    /**
     * @return string[]
     */
    public function getFileHeaders() : array;
}