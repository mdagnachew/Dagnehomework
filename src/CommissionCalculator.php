<?php

namespace App;

class CommissionCalculator
{
    private $exchangeRateProvider;
    private $weeklyWithdrawalLimits = [];

    public function __construct(ExchangeRateProvider $exchangeRateProvider)
    {
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    public function calculateCommission(Operation $operation): string
    {
        $amountInOperationCurrency = $operation->getAmount();
        $amountInEur = $this->convertToEur($operation);

        $commission = 0.0;

        if ($operation->getType() === 'deposit') {
            $commission = $this->calculateDepositCommission($amountInEur);
        } elseif ($operation->getType() === 'withdraw') {
            $commission = $this->calculateWithdrawCommission($operation, $amountInEur);
        }

        return $this->roundUp($commission, $operation->getCurrency());
    }

    private function convertToEur(Operation $operation): float
    {
        if ($operation->getCurrency() === 'EUR') {
            return $operation->getAmount();
        }

        $rate = $this->exchangeRateProvider->getRate($operation->getCurrency());
        return $operation->getAmount() / $rate;
    }

    private function convertFromEur(float $amount, string $currency): float
    {
        if ($currency === 'EUR') {
            return $amount;
        }

        $rate = $this->exchangeRateProvider->getRate($currency);
        return $amount * $rate;
    }

    private function calculateDepositCommission(float $amountInEur): float
    {
        return $amountInEur * 0.0003; // 0.03%
    }

    private function calculateWithdrawCommission(Operation $operation, float $amountInEur): float
    {
        $user = $operation->getUser();
        $commission = 0.0;

        if ($user->getType() === 'private') {
            $commission = $this->calculatePrivateWithdrawCommission($operation, $amountInEur);
        } elseif ($user->getType() === 'business') {
            $commission = $amountInEur * 0.005; // 0.5%
        }

        return $commission;
    }

    private function calculatePrivateWithdrawCommission(Operation $operation, float $amountInEur): float
    {
        $userId = $operation->getUser()->getId();
        $weekNumber = date('oW', strtotime($operation->getDate()));
        $key = $userId . '_' . $weekNumber;

        if (!isset($this->weeklyWithdrawalLimits[$key])) {
            $this->weeklyWithdrawalLimits[$key] = [
                'amount' => 0.0,
                'count' => 0
            ];
        }

        $freeLimit = 1000.00;
        $freeWithdrawalsCount = 3;

        $weekData = &$this->weeklyWithdrawalLimits[$key];
        $freeAmountRemaining = max($freeLimit - $weekData['amount'], 0);

        if ($weekData['count'] < $freeWithdrawalsCount && $freeAmountRemaining > 0) {
            if ($amountInEur <= $freeAmountRemaining) {
                $weekData['amount'] += $amountInEur;
                $weekData['count']++;
                return 0.0;
            } else {
                $commissionableAmount = $amountInEur - $freeAmountRemaining;
                $weekData['amount'] = $freeLimit;
                $weekData['count']++;
                return $commissionableAmount * 0.003; // 0.3%
            }
        } else {
            return $amountInEur * 0.003; // 0.3%
        }
    }

    private function roundUp(float $amount, string $currency): string
    {
        $decimalPlaces = $this->getDecimalPlaces($currency);
        $factor = pow(10, $decimalPlaces);
        return number_format(ceil($amount * $factor) / $factor, $decimalPlaces, '.', '');
    }

    private function getDecimalPlaces(string $currency): int
    {
        $decimalPlaces = [
            'JPY' => 0,
            'EUR' => 2,
            'USD' => 2,
        ];

        return $decimalPlaces[$currency] ?? 2;
    }
}
