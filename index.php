<?php

require __DIR__.'/vendor/autoload.php';

use Task\InputObject;
use Task\PaymentTypeSelector;

$options = getopt(null, ["productType:", "amount:", "lang:", "countryCode:", "userOs:"]);

$inputObject = new InputObject();
$inputObject->setProductType($options['productType']);
$inputObject->setAmount($options['amount']);
$inputObject->setLanguage($options['lang']);
$inputObject->setCountryCode($options['countryCode']);
$inputObject->setUserOs($options['userOs']);

$paymentTypeSelector = new PaymentTypeSelector($inputObject);
$paymentButtons = $paymentTypeSelector->getButtons();

var_dump($paymentButtons);