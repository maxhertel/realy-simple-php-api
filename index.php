<?php
require_once 'autoload.php';

use Entities\Account\Account;



$account = new Account(100);
echo $account->getBalance();

