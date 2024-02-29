<?php

namespace MaxPHPApi\Entities\Account;


class AccountService {

    public static function findAccountByIdWithDefault(int $accountId): mixed
    {
        $account = new Account($accountId);
        if ($account) {
            return json_encode([
                'id' => $account->getId(),
                'balance' => $account->getBalance()
            ]);
        } else {
            return json_encode([
                'id' => null,
                'balance' => 0
            ]);
        }
    }
    public static function event(array $data): void 
    {
        match ($data['type']) {
            'deposit' => self::despositWithAcccontCreate($data['amount'], $data['destination']),
            'withdraw' => self::withdraw(),
            'transfer' => "" ,
            default => throw new \InvalidArgumentException("Ação inválida"),
        };
    }

    private static function despositWithAcccontCreate(float $amount,int $destination) : mixed {

        $accountRepository = new AccountRepository();
        $account = $accountRepository->findAccountById($destination);
        if(!empty($account)){
            $account->deposit($amount);
        }else{
            $account = new Account(["id"=>$destination,"balance"=>$amount]);
            $accountRepository->addAccount($account);
        }
        
        
    }
    private static function withdraw() : mixed {
        
    }
    private function transfer() : mixed {
        
    }
}
