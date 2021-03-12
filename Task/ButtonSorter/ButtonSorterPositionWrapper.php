<?php

namespace Task\ButtonSorter;

class ButtonSorterPositionWrapper
{
    private int $positionWeight = 0;
    private mixed $internalData;

    /**
     * @return int
     */
    public function getPositionWeight(): int
    {
        return $this->positionWeight;
    }

    /**
     * @param int $increaseValue
     * @return ButtonSorterPositionWrapper
     */
    public function increasePositionWeight(int $increaseValue): ButtonSorterPositionWrapper
    {
        $this->positionWeight += $increaseValue;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInternalData(): mixed
    {
        return $this->internalData;
    }

    /**
     * @param mixed $internalData
     * @return ButtonSorterPositionWrapper
     */
    public function setInternalData(mixed $internalData): ButtonSorterPositionWrapper
    {
        $this->internalData = $internalData;
        return $this;
    }
}