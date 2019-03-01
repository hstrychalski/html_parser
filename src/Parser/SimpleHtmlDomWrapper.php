<?php

namespace App\Parser;

use simple_html_dom;

/**
 * Class SimpleHtmlDomWrapper
 */
class SimpleHtmlDomWrapper
{
    /**
     * @param $url
     * @param int $offset
     * @return bool|simple_html_dom
     */
    public function getHtmlDomFromFile($url, $offset = 0)
    {
        return file_get_html($url, false, null, $offset);
    }
}