<?php

namespace Task\ButtonSorter;

use Task\InputObject;

interface ButtonSorter
{
    public function addPositionWeights(InputObject $inputObject, array $buttons):array;
}