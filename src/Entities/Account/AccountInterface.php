<?php
namespace MaxPHPApi\Entities\Account;

interface AccountInterface {
    public function getBalance(): float;
    public function deposit(float $amount): void;
    public function withdraw(float $amount): ?float;
    public function transfer(float $amount,int $account_id): void;
}