<?php

namespace App;

class Operation
{
    private $date;
    private $user;
    private $type;
    private $amount;
    private $currency;

    public function __construct($date, User $user, $type, $amount, $currency)
    {
        $this->date = $date;
        $this->user = $user;
        $this->type = $type;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}
