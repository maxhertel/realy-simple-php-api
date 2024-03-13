<?php

namespace MaxPHPApi\Entities\Account;


class AccountService {

    public static function findAccountByIdWithDefault(int $accountId): mixed
    {
        $accountRepository = new AccountRepository();
        $accountData = $accountRepository->findAccountById($accountId);
        if($accountData){
            $account = new Account($accountData);
            $balance = $account->getBalance();
            return "200 $balance";
        }else{
            return "404 0";
        }
    }
    public static function event(array $data): void 
    {
        if (version_compare(PHP_VERSION, '8.0.0', '<')) {
            switch ($data['type']) {
                case 'deposit':
                    echo self::despositWithAcccontCreate($data['amount'], $data['destination']);
                    break;
                case 'withdraw':
                    echo self::withdraw($data['amount'], $data['origin']);
                    break;
                case 'transfer':
                    echo self::transfer($data['amount'], $data['origin'], $data['destination']);
                    break;
                default:
                    throw new \InvalidArgumentException("Ação inválida");
            }
        } else {
            // try {
            //     echo match ($data['type']) {
            //         'deposit' => self::despositWithAcccontCreate($data['amount'], $data['destination']),
            //         'withdraw' => self::withdraw($data['amount'], $data['origin']),
            //         'transfer' => self::transfer($data['amount'],$data['origin'],$data['destination']),
            //         default => throw new \InvalidArgumentException("Ação inválida"),
            //     };
            // } catch (\Throwable $th) {
            //     //throw $th;
            // }
           
        }
       
    }

    private static function  despositWithAcccontCreate(float $amount,int $destination) : mixed {

        $accountRepository = new AccountRepository();
        $account = new Account($accountRepository->findAccountById($destination));
        if($account->getId() != 0){
            $account->deposit($amount);
        }else{
            var_dump(["id"=>$destination,"balance"=>$amount]);
            $accountRepository->addAccount(["id"=>$destination,"balance"=>$amount]);
        }
        //TODO: improve, create a deafult response class
        return "201 {\"destination\": {\"id\":\"".$account->getId()."\", \"balance\":".$account->getBalance()."}}";
    }
    private static function withdraw(float $amount,int $origin) : mixed {
        $accountRepository = new AccountRepository();
        $account = new Account($accountRepository->findAccountById($origin));
        $newBalance = $account->withdraw($amount);
        
        if($newBalance){
            return "201 {\"origin\": {\"id\":\"".$account->getId()."\", \"balance\":".$account->getBalance()."}}";
        }else{
            return "404 0";
        }
        
    }
    private static function transfer(float $amount,int $origin,int $destination) : mixed {

        $accountRepository = new AccountRepository();
        $account = new Account($accountRepository->findAccountById($origin));
        
        if($account->getId() != 0){
            $account->withdraw($amount);
            self::despositWithAcccontCreate($amount, $destination);
            $accountReciver = new Account($accountRepository->findAccountById($destination));
            return "201 {\"origin\": {\"id\":\"".$account->getId()."\", \"balance\":".$account->getBalance()."},
            \"destination\": {\"id\":\"".$accountReciver->getId()."\", \"balance\":".$accountReciver->getBalance()."}}";
        }else{
            return "404 0";
        }
        
    }
    public static function reset() : void {

        $accountRepository = new AccountRepository();
        $account = $accountRepository->reset();
        
    }
}
