<?php

namespace Task;

use InvalidArgumentException;
use League\ISO3166\ISO3166;

class InputObject
{
    const ALLOWED_PRODUCT_LIST = ['book', 'reward', 'walletRefill'];
    const ALLOWED_LANGUAGES = ['ru', 'en', 'es', 'uk'];
    const ALLOWED_OS = ['android', 'ios', 'windows'];

    private string $productType;
    private float $amount;
    private string $language;
    private string $countryCode;
    private string $userOs;

    /**
     * @return string
     */
    public function getProductType(): string
    {
        return $this->productType;
    }

    /**
     * @param string $productType
     */
    public function setProductType(string $productType): void
    {
        if (!in_array($productType, self::ALLOWED_PRODUCT_LIST)) {
            throw new InvalidArgumentException('Product type should be one of the allowed list');
        }

        $this->productType = $productType;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Amount should be bigger then 0');
        }

        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        if (!in_array($language, self::ALLOWED_LANGUAGES)) {
            throw new InvalidArgumentException('Language should be one of the allowed list');
        }

        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        (new ISO3166)->alpha2($countryCode);

        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getUserOs(): string
    {
        return $this->userOs;
    }

    /**
     * @param string $userOs
     */
    public function setUserOs(string $userOs): void
    {
        if (!in_array($userOs, self::ALLOWED_OS)) {
            throw new InvalidArgumentException('User OS should be one of the allowed list');
        }

        $this->userOs = $userOs;
    }
}