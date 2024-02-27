<?php

namespace MaxPHPApi\Entities\Account;


class Account implements AccountInterface {
    protected float $balance;

    public function __construct(float $initialBalance) {
        $this->balance = $initialBalance;
    }

    public function getBalance(): float {
        return $this->balance;
    }

    public function deposit(float $amount): void {
        $this->balance += $amount;
    }

    public function withdraw(float $amount): void {
        if ($amount > $this->balance) {
            throw new \Exception("Insufficient funds");
        }
        $this->balance -= $amount;
    }

    public function transfer(float $amount, $account_id): void
    {
        
    }

    public function event(string $action, float $amount): void 
    {
    }
}
