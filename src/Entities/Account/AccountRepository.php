<?php

namespace MaxPHPApi\Entities\Account;

class AccountRepository
{
    protected array $accounts = [];

    public function addAccount(Account $account): void
    {
        $this->accounts[] = $account;
    }

    public function findAccountById(float $accountId): ?Account
    {
        foreach ($this->accounts as $account) {
            if ($account->getId() === $accountId) {
                return $account;
            }
        }
        return null;
    }

    public function getAccounts(): array
    {
        return $this->accounts;
    }

}
