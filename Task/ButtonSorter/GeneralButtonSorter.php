<?php

namespace Task\ButtonSorter;

use database\PDOWrapper;
use PDO;
use Task\InputObject;

class GeneralButtonSorter implements ButtonSorter
{
    public function addPositionWeights(InputObject $inputObject, array $buttons): array
    {
        $weights = PDOWrapper::getPDO()->query('
            SELECT payment_method_id as paymentId, priority_weight as weight
            FROM priority_order_weights
            WHERE priority_order_type_id = 1;
        ')
            ->fetchAll(PDO::FETCH_ASSOC);

        foreach ($weights as $weight) {
            if(empty($buttons[$weight['paymentId']])) {
                continue;
            }
            ($buttons[$weight['paymentId']])->increasePositionWeight($weight['weight']);
        }

        return $buttons;
    }
}