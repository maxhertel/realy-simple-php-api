<?php
namespace Entities\Account;

interface AccountInterface {
    public function getBalance(): float;
    public function deposit(float $amount): void;
    public function withdraw(float $amount): void;
    public function transfer(float $amount,int $account_id): void;
    public function event(string $action, float $amount): void;
}