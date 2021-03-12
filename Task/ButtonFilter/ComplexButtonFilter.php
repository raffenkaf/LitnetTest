<?php

namespace Task\ButtonFilter;

use Task\InputObject;

interface ComplexButtonFilter
{
    public function setComplexParams(array $params): self;
    public function filter(InputObject $inputObject, array $buttons): array;
}