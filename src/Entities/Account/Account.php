<?php

namespace MaxPHPApi\Entities\Account;


class Account implements AccountInterface {
    private int $id = 0;
    private float $balance  = 0.0;
    protected AccountRepository $repository;

    public function __construct(array $data = null) {
        $this->repository = new AccountRepository();
        if ($data['id'] !== null) {
            $this->loadAccountData($data);
        }
       
    }

    protected function loadAccountData(array $data): void {
        $accountRepository = new AccountRepository();
        $accountData = $accountRepository->findAccountById($data['id']);

        if ($accountData) {
            $this->id = $accountData['id'];
            $this->balance = $accountData['balance'];
        }
    }


    public function getId(): float {
        return $this->id;
    }
    public function getBalance(): float {
        return $this->balance;
    }

    public function deposit(float $amount): void {
        $this->balance += $amount;
        $this->repository->updateAccountBalance($this->id, $this->balance);

    }

    public function withdraw(float $amount): ?float {
        if ($amount > $this->balance) {
            return null;
        }
        $this->balance -= $amount;
        $this->repository->updateAccountBalance($this->id, $this->balance);
        return $this->balance;
    }

    public function transfer(float $amount, $account_id): void
    {   
        $this->withdraw($amount);
        $accountReciver = new Account($account_id);
        $accountReciver->deposit($amount);
    }

}
