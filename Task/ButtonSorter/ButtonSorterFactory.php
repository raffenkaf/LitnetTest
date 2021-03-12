<?php

namespace Task\ButtonSorter;

use InvalidArgumentException;

class ButtonSorterFactory
{
    private array $paymentRuleClassMapping;

    public function __construct()
    {
        $this->paymentRuleClassMapping = [
            'general' => new GeneralButtonSorter(),
            'country' => new CountryButtonSorter()
        ];
    }

    public function createSorter(string $sortType): ButtonSorter
    {
        if (isset($this->paymentRuleClassMapping[$sortType])) {
            return $this->paymentRuleClassMapping[$sortType];
        }

        throw new InvalidArgumentException();
    }
}