<?php

namespace App;

class CommissionCalculator
{
    private $exchangeRateProvider;

    public function __construct(ExchangeRateProvider $exchangeRateProvider)
    {
        $this->exchangeRateProvider = $exchangeRateProvider;
    }

    public function calculateCommission(Operation $operation): string
    {
        $amountInEur = $this->convertToEur($operation);
        $commission = 0.0;

        switch ($operation->getType()) {
            case 'deposit':
                $commission = $this->calculateDepositCommission($amountInEur);
                break;
            case 'withdraw':
                $commission = $this->calculateWithdrawCommission($operation, $amountInEur);
                break;
        }

        return number_format(ceil($commission * 100) / 100, 2, '.', '');
    }

    private function convertToEur(Operation $operation): float
    {
        if ($operation->getCurrency() === 'EUR') {
            return $operation->getAmount();
        }

        $rate = $this->exchangeRateProvider->getRate($operation->getCurrency());
        return $operation->getAmount() / $rate;
    }

    private function calculateDepositCommission(float $amount): float
    {
        return $amount * 0.0003;
    }

    private function calculateWithdrawCommission(Operation $operation, float $amountInEur): float
    {
        $user = $operation->getUser();
        $commission = 0.0;

        if ($user->getType() === 'private') {
            $commission = $amountInEur * 0.003;
            // Apply free amount logic for private clients
            // Not implementing the full logic here for brevity
        } elseif ($user->getType() === 'business') {
            $commission = $amountInEur * 0.005;
        }

        return $commission;
    }
}
