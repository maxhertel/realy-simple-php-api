<?php

namespace MaxPHPApi\Entities\Account;


use MaxPHPApi\Entities\Account\Account;
use MaxPHPApi\Database\DBBuilder;

class AccountRepository
{
    protected array $accounts = [];
    protected DBBuilder $db;

    public function __construct()
    {
        $db = new DBBuilder();
        $this->db = $db;
    }

    public function addAccount(Account $account): void
    {
        $data = [
            'balance' => $account->getBalance(),
            'id' => $account->getId()
        ];
        $this->db->insert('accounts', $data);
    }

    public function findAccountById(float $accountId): ?Account
    {
        
        $result = $this->db->select('accounts', "id = $accountId", []);
        if (!empty($result)) {
            $accountData = $result[0];
            return new Account($accountData['balance'], $accountData['id']);
        }
        
        return null;
    }
    
    public function updateAccountBalance(float $accountId, float $newBalance): void
    {
        $data = ['balance' => $newBalance];
        $where = 'id = '.$accountId;
        $this->db->update('accounts', $data, $where, [$accountId]);
    }
}
