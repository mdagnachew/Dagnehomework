<?php

use PHPUnit\Framework\TestCase;
use App\CommissionCalculator;
use App\ExchangeRateProvider;
use App\Operation;
use App\User;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculateCommission()
    {
        $exchangeRates = [
            'USD' => 1.1497,
            'JPY' => 129.53
        ];

        $exchangeRateProvider = new ExchangeRateProvider($exchangeRates);
        $calculator = new CommissionCalculator($exchangeRateProvider);

        $user = new User(1, 'private');
        $operation = new Operation('2016-01-05', $user, 'withdraw', 1000.00, 'EUR');
        $this->assertEquals('3.00', $calculator->calculateCommission($operation));

        $user = new User(2, 'business');
        $operation = new Operation('2016-01-06', $user, 'withdraw', 300.00, 'EUR');
        $this->assertEquals('1.50', $calculator->calculateCommission($operation));
    }
}
use PHPUnit\Framework\TestCase;
use App\CommissionCalculator;
use App\ExchangeRateProvider;
use App\Operation;
use App\User;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculateCommission()
    {
        $exchangeRates = [
            'USD' => 1.1497,
            'JPY' => 129.53
        ];

        $exchangeRateProvider = new ExchangeRateProvider($exchangeRates);
        $calculator = new CommissionCalculator($exchangeRateProvider);

        $user = new User(1, 'private');
        $operation = new Operation('2016-01-05', $user, 'withdraw', 1000.00, 'EUR');
        $this->assertEquals('3.00', $calculator->calculateCommission($operation));

        $user = new User(2, 'business');
        $operation = new Operation('2016-01-06', $user, 'withdraw', 300.00, 'EUR');
        $this->assertEquals('1.50', $calculator->calculateCommission($operation));
    }
}public function testConvertToEur()
{
    $exchangeRates = [
        'USD' => 1.1497,
        'JPY' => 129.53
    ];

    $exchangeRateProvider = new ExchangeRateProvider($exchangeRates);
    $calculator = new CommissionCalculator($exchangeRateProvider);

    $user = new User(1, 'private');
    $operation = new Operation('2016-01-05', $user, 'withdraw', 1000.00, 'USD');
    $this->assertEquals(869.57, $calculator->convertToEur($operation));

    $user = new User(2, 'business');
    $operation = new Operation('2016-01-06', $user, 'withdraw', 5000.00, 'JPY');
    $this->assertEquals(38.61, $calculator->convertToEur($operation));
}public function testCalculateCommissionForDeposit()
{
    $exchangeRates = [
        'USD' => 1.1497,
        'JPY' => 129.53
    ];

    $exchangeRateProvider = new ExchangeRateProvider($exchangeRates);
    $calculator = new CommissionCalculator($exchangeRateProvider);

    $user = new User(1, 'private');
    $operation = new Operation('2016-01-05', $user, 'deposit', 1000.00, 'EUR');
    $this->assertEquals('0.30', $calculator->calculateCommission($operation));

    $user = new User(2, 'business');
    $operation = new Operation('2016-01-06', $user, 'deposit', 500.00, 'EUR');
    $this->assertEquals('0.15', $calculator->calculateCommission($operation));
}

public function testCalculateCommissionForWithdraw()
{
    $exchangeRates = [
        'USD' => 1.1497,
        'JPY' => 129.53
    ];

    $exchangeRateProvider = new ExchangeRateProvider($exchangeRates);
    $calculator = new CommissionCalculator($exchangeRateProvider);

    $user = new User(1, 'private');
    $operation = new Operation('2016-01-05', $user, 'withdraw', 1000.00, 'EUR');
    $this->assertEquals('3.00', $calculator->calculateCommission($operation));

    $user = new User(2, 'business');
    $operation = new Operation('2016-01-06', $user, 'withdraw', 300.00, 'EUR');
    $this->assertEquals('1.50', $calculator->calculateCommission($operation));
}

public function testConvertToEur()
{
    $exchangeRates = [
        'USD' => 1.1497,
        'JPY' => 129.53
    ];

    $exchangeRateProvider = new ExchangeRateProvider($exchangeRates);
    $calculator = new CommissionCalculator($exchangeRateProvider);

    $user = new User(1, 'private');
    $operation = new Operation('2016-01-05', $user, 'withdraw', 1000.00, 'USD');
    $this->assertEquals(869.57, $calculator->convertToEur($operation));

    $user = new User(2, 'business');
    $operation = new Operation('2016-01-06', $user, 'withdraw', 5000.00, 'JPY');
    $this->assertEquals(38.61, $calculator->convertToEur($operation));
}