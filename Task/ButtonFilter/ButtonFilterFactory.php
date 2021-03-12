<?php

namespace Task\ButtonFilter;

use InvalidArgumentException;

class ButtonFilterFactory
{
    private array $paymentSimpleRuleClassMapping;
    private array $paymentComplexRuleClassMapping;

    public function __construct()
    {
        $this->paymentSimpleRuleClassMapping = [
            'OnlyCountry' => new OnlyCountryFilter(),
            'NotCountry' => new NotCountryFilter(),
            'OnlyOs' => new OnlyOsFilter()
        ];
        $this->paymentComplexRuleClassMapping = [
            'LangLessAmount' => new LangLessAmountFilter(),
            'ProductTypeLangLessAmount' => new ProductTypeLangLessAmount()
        ];
    }

    public function createSimpleFilter(string $filterType): SimpleButtonFilter
    {
        if (isset($this->paymentSimpleRuleClassMapping[$filterType])) {
            return $this->paymentSimpleRuleClassMapping[$filterType];
        }

        throw new InvalidArgumentException();
    }

    public function createComplexFilter(string $filterType): ComplexButtonFilter
    {
        if (isset($this->paymentComplexRuleClassMapping[$filterType])) {
            return $this->paymentComplexRuleClassMapping[$filterType];
        }

        throw new InvalidArgumentException();
    }
}