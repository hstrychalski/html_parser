<?php

namespace App\Exception;

/**
 * Class InvalidFieldException
 */
class InvalidFieldException extends \Exception
{
    /**
     * @var array|string[]
     */
    private $invalidFields = [];

    /**
     * @var string
     */
    private $pharmacyId;


    /**
     * InvalidFieldException constructor.
     * @param string $message
     * @param string[] $invalidFields
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message, array $invalidFields, string $pharmacyId, int $code = 0, Throwable $previous = null)
    {
        $this->pharmacyId = $pharmacyId;
        $this->invalidFields = $invalidFields;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string[]
     */
    public function getInvalidFields(): array
    {
        return $this->invalidFields;
    }

    /**
     * @return string
     */
    public function getPharmacyId(): string
    {
        return $this->pharmacyId;
    }
}