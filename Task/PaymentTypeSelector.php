<?php

namespace Task;

use database\PDOWrapper;
use PDO;
use Task\ButtonFilter\ButtonFilterFactory;
use Task\ButtonSorter\ButtonSorterFactory;
use Task\ButtonSorter\ButtonSorterPositionWrapper;

class PaymentTypeSelector
{
    private InputObject $inputObject;
    private array $buttons = [];
    private array $complexFilters;

    /**
     * PaymentTypeSelector constructor.
     * @param InputObject $inputObject
     */
    public function __construct(InputObject $inputObject)
    {
        $this->inputObject = $inputObject;

        $this->complexFilters = include(__DIR__ . '/../app.config.php');
        $this->complexFilters = $this->complexFilters['ComplexFilters'];
    }

    public function getButtons(): array
    {
        $this->defineAllButtons();
        $this->simpleFilterButtons();
        $this->complexFilterButtons();
        $this->sortButtons();
        return $this->buttons;
    }

    private function defineAllButtons()
    {
        $this->buttons = PDOWrapper::getPDO()->query('
                SELECT pm.id as id, pm.name as name, pm.percent as comission, pm.image_url as imageUrl, pm.payment_url as paymentUrl
                FROM payment_method pm JOIN payment_system ps ON pm.payment_system_id = ps.id
                WHERE ps.active = 1 AND pm.active = 1;
        ')
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    private function simpleFilterButtons()
    {
        $filters = PDOWrapper::getPDO()->query('
            SELECT payrule.name as filterName, parameter_value as filterValue, payment_method_id as paymentMethodId
            FROM payment_show_rule payrule
            JOIN payment_show_filters payfilter ON payrule.id = payfilter.payment_show_rule_id;
        ')
            ->fetchAll(PDO::FETCH_ASSOC);

        $buttonFilterFactory = new ButtonFilterFactory();

        foreach ($filters as $filter) {
            $this->buttons = $buttonFilterFactory->createSimpleFilter($filter['filterName'])
                ->setFilterValue($filter['filterValue'])
                ->setPaymentMethodId($filter['paymentMethodId'])
                ->filter($this->inputObject, $this->buttons);
        }
    }

    private function sortButtons()
    {
        $sortedButtons = [];

        foreach ($this->buttons as $button) {
            $sortedButtons[$button['id']] = (new ButtonSorterPositionWrapper())->setInternalData($button);
        }

        $sorters = PDOWrapper::getPDO()->query('
            SELECT name
            FROM priority_order_type;
        ')
            ->fetchAll(PDO::FETCH_COLUMN);

        $buttonSortedFactory = new ButtonSorterFactory();

        foreach ($sorters as $sorter) {
            $sortedButtons = $buttonSortedFactory->createSorter($sorter)->addPositionWeights($this->inputObject,
                $sortedButtons);
        }

        usort($sortedButtons,
            function (ButtonSorterPositionWrapper $firstButton, ButtonSorterPositionWrapper $secondButton) {
                return ($secondButton->getPositionWeight() <=> $firstButton->getPositionWeight());
            });

        $this->buttons = [];
        foreach ($sortedButtons as $key => $button) {
            $this->buttons[] = $button->getInternalData();
        }
    }

    private function complexFilterButtons()
    {
        $buttonFilterFactory = new ButtonFilterFactory();

        foreach ($this->complexFilters as $filterName => $filterParam) {
            $this->buttons = $buttonFilterFactory->createComplexFilter($filterName)
                ->setComplexParams($filterParam)
                ->filter($this->inputObject, $this->buttons);
        }
    }
}