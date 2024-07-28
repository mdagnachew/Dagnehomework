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
