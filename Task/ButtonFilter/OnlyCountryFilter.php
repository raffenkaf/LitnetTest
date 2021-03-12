<?php

namespace Task\ButtonFilter;

use Task\InputObject;

class OnlyCountryFilter implements SimpleButtonFilter
{
    private string $filterValue;
    private int $paymentMethodId;

    public function setFilterValue(mixed $filterValue): self
    {
        $this->filterValue = $filterValue;
        return $this;
    }

    public function setPaymentMethodId(mixed $paymentMethodId): self
    {
        $this->paymentMethodId = $paymentMethodId;
        return $this;
    }

    public function filter(InputObject $inputObject, array $buttons): array
    {
        return array_filter($buttons, function($button, $key) use ($inputObject) {
            if (
                $button['id']*1 === $this->paymentMethodId
                && !str_contains($this->filterValue, $inputObject->getCountryCode())
            ) {
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_BOTH);
    }
}