<?php

namespace MaxPHPApi\Entities\Account;


class Account implements AccountInterface {
    private int $id = 0;
    private float $balance  = 0.0;
    protected AccountRepository $repository;

    public function __construct(int $id = null) {
        if ($id !== null) {
            $this->loadAccountData($id);
        }
    }

    protected function loadAccountData(float $id): void {
        $accountRepository = new AccountRepository();
        $accountData = $accountRepository->findAccountById($id);
        if ($accountData) {
            $this->id = $accountData['id'];
            $this->balance = $accountData['balance'];
        }
    }

    public static function findAccountByIdWithDefault(float $accountId): mixed
    {
        $accountRepository = new AccountRepository();
        $account = $accountRepository->findAccountById($accountId);

        if ($account) {
            return json_encode([
                'id' => $account['id'],
                'balance' => $account['balance']
            ]);
        } else {
            return json_encode([
                'id' => null,
                'balance' => 0
            ]);
        }
    }


    public function getId(): float {
        return $this->id;
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

    public function event(string $action,array $data, ?Account $accountReciver): void 
    {
        match ($action) {
            'deposit' => $this->deposit($data),
            'withdraw' => $this->withdraw($data),
            'transfer' => $this->transfer($action,$accountReciver->id) ,
            default => throw new \InvalidArgumentException("Ação inválida: $action"),
        };
    }
}
