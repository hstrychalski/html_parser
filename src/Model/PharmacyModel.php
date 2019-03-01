<?php

namespace App\Model;

class PharmacyModel implements ParsingResultInterface
{
    /**
     * @var string
     */
    private $pharmacyId;

    /**
     * @var string
     */
    private $pharmacyName;

    /**
     * @var string
     */
    private $pharmacyAddress;

    /**
     * @var string
     */
    private $krs;

    /**
     * @var string
     */
    private $regon;

    /**
     * @var string
     */
    private $nip;

    /**
     * @return string|null
     */
    public function getPharmacyId(): ?string
    {
        return $this->pharmacyId;
    }

    /**
     * @param string $pharmacyId
     */
    public function setPharmacyId(?string $pharmacyId): void
    {
        $this->pharmacyId = $pharmacyId;
    }

    /**
     * @return string
     */
    public function getPharmacyName(): ?string
    {
        return $this->pharmacyName;
    }

    /**
     * @param string|null $pharmacyName
     */
    public function setPharmacyName(?string $pharmacyName): void
    {
        $this->pharmacyName = $pharmacyName;
    }

    /**
     * @return string|null
     */
    public function getPharmacyAddress(): ?string
    {
        return $this->pharmacyAddress;
    }

    /**
     * @param string|null $pharmacyAddress
     */
    public function setPharmacyAddress(?string $pharmacyAddress): void
    {
        $this->pharmacyAddress = $pharmacyAddress;
    }

    /**
     * @return string|null
     */
    public function getKrs(): ?string
    {
        return $this->krs;
    }

    /**
     * @param string $krs
     */
    public function setKrs(?string $krs): void
    {
        $this->krs = $krs;
    }

    /**
     * @return string|null
     */
    public function getRegon(): ?string
    {
        return $this->regon;
    }

    /**
     * @param string|null $regon
     */
    public function setRegon(?string $regon): void
    {
        $this->regon = $regon;
    }

    /**
     * @return string|null
     */
    public function getNip(): ?string
    {
        return $this->nip;
    }

    /**
     * @param string|null $nip
     */
    public function setNip(?string $nip): void
    {
        $this->nip = $nip;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return array (
            'id' => $this->getPharmacyId(),
            'name' => $this->getPharmacyName(),
            'address' => $this->getPharmacyAddress(),
            'regon' => $this->getRegon(),
            'nip' => $this->getNip(),
            'krs' => $this->getKrs(),
        );
    }

    /**
     * @return string[]
     */
    public function getFileHeaders(): array
    {
        $modelAsArray = $this->toArray();
        return array_keys($modelAsArray);
    }
}