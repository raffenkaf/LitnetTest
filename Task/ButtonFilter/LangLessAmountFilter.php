<?php

namespace Task\ButtonFilter;

use Task\InputObject;

class LangLessAmountFilter implements ComplexButtonFilter
{
    private array $params;

    public function setComplexParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function filter(InputObject $inputObject, array $buttons): array
    {
        return array_filter($buttons, function($button, $key) use ($inputObject) {
            if (
                $button['name'] === $this->params['paymentMethod']
                && $inputObject->getAmount() < $this->params['amount']
                && $inputObject->getLanguage() === $this->params['lang']
            ) {
                return false;
            }
            return true;
        }, ARRAY_FILTER_USE_BOTH);
    }
}