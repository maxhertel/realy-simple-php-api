<?php

namespace MaxPHPApi\Entities\Account;


class Account implements AccountInterface {
    private int $id = 0;
    private float $balance  = 0.0;
    protected AccountRepository $repository;

    public function __construct(array $data = null) {
        if ($data['id'] !== null) {
            $this->loadAccountData($data);
        }
        $this->repository = new AccountRepository();
    }

    protected function loadAccountData(array $data): void {
        $accountRepository = new AccountRepository();
        $accountData = $accountRepository->findAccountById($data['id']);
        if ($accountData) {
            $this->id = $accountData['id'];
            $this->balance = $accountData['balance'];
        }else{
            $this->id = $data['id'];
            $this->balance = $data['balance'];
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

    public function withdraw(float $amount): void {
        if ($amount > $this->balance) {
            throw new \Exception("Insufficient funds");
        }
        $this->balance -= $amount;
        $this->repository->updateAccountBalance($this->id, $this->balance);
    }

    public function transfer(float $amount, $account_id): void
    {   
        $this->withdraw($amount);
        $accountReciver = new Account($account_id);
        $accountReciver->deposit($amount);
    }

}
