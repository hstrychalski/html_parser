<?php

namespace App\Dictionary;

/**
 * Class TargetFieldsDictionary
 * @package App\Dictionary
 */
class TargetFieldsDictionary
{
    const KEY_NAME = 'Nazwa';

    const KEY_ADDRESS = 'Adres';

    const KEY_KRS = 'KRS';

    const KEY_REGON = 'REGON';

    const KEY_NIP = 'NIP';

    /**
     * @return array
     */
    static function getTargetFields(): array
    {
        return array (
            self::KEY_NAME,
            self::KEY_ADDRESS,
            self::KEY_REGON,
            self::KEY_KRS,
            self::KEY_NIP
        );
    }
}