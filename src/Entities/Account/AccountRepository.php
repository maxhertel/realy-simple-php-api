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

    public function addAccount(array $account): void
    {
        $data = [
            'balance' => $account['balance'],
            'id' => $account['id']
        ];
        $this->db->insert('accounts', $data);
    }

    public function findAccountById(float $accountId): ?array
    {
        
        $result = $this->db->select('accounts', "id = $accountId", []);
        if (!empty($result)) {
            $accountData = $result[0];
            
            return ["balance" => $accountData['balance'],"id" => $accountData['id']];
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
