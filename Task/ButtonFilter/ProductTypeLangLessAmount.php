<?php

namespace Task\ButtonFilter;

use Task\InputObject;

class ProductTypeLangLessAmount implements ComplexButtonFilter
{
    private array $params;

    public function setComplexParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function filter(InputObject $inputObject, array $buttons): array
    {
        if ($inputObject->getAmount() < $this->params['amount']
            && $inputObject->getLanguage() === $this->params['lang']
            && $inputObject->getProductType() === $this->params['productType']
        ) {

            return array_filter($buttons, function($button, $key) use ($inputObject) {
                if ($this->params['paymentMethod'] === $button['name']) {
                    return true;
                }
                return false;
            }, ARRAY_FILTER_USE_BOTH);

        }

        return $buttons;
    }
}