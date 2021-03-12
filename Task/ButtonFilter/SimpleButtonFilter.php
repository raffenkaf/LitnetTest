<?php

namespace Task\ButtonFilter;

use Task\InputObject;

interface SimpleButtonFilter
{
    public function setFilterValue(mixed $filterValue): self;
    public function setPaymentMethodId(mixed $paymentMethodId): self;
    public function filter(InputObject $inputObject, array $buttons): array;
}