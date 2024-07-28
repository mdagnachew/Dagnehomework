<?php

require __DIR__ . '/vendor/autoload.php';

use App\CommissionCalculator;
use App\ExchangeRateProvider;
use App\Operation;
use App\User;

// Load exchange rates (hardcoded for simplicity)
$exchangeRates = [
    'USD' => 1.1497,
    'JPY' => 129.53
];

$exchangeRateProvider = new ExchangeRateProvider($exchangeRates);
$calculator = new CommissionCalculator($exchangeRateProvider);

// Read input data
$inputFile = 'input.csv';
$handle = fopen($inputFile, 'r');
if ($handle !== false) {
    while (($data = fgetcsv($handle)) !== false) {
        $operationDate = $data[0];
        $userId = (int)$data[1];
        $userType = $data[2];
        $operationType = $data[3];
        $amount = (float)$data[4];
        $currency = $data[5];

        $user = new User($userId, $userType);
        $operation = new Operation($operationDate, $user, $operationType, $amount, $currency);

        $commission = $calculator->calculateCommission($operation);
        echo $commission . PHP_EOL;
    }
    fclose($handle);
}
