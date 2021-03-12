<?php


namespace Task\ButtonSorter;


use database\PDOWrapper;
use PDO;
use Task\InputObject;

class CountryButtonSorter implements ButtonSorter
{
    public function addPositionWeights(InputObject $inputObject, array $buttons): array
    {
        $weights = PDOWrapper::getPDO()->query("
            SELECT payment_method_id as paymentId, priority_weight as weight
            FROM priority_order_weights
            WHERE priority_order_type_id = 2 AND priority_param = '{$inputObject->getCountryCode()}';
        ")
            ->fetchAll(PDO::FETCH_ASSOC);

        foreach ($weights as $weight) {
            ($buttons[$weight['paymentId']])->increasePositionWeight($weight['weight']);
        }

        return $buttons;
    }
}