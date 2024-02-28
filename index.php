<?php

require_once 'vendor/autoload.php';

use MaxPHPApi\Database\DBBuilder;
use MaxPHPApi\Entities\Account\Account;
use MaxPHPApi\Entities\Account\AccountRepository;
use MaxPHPApi\Http\Router;

$router = new Router($_SERVER);

//TODO:segrate responsibilite   
$router->addRoute('GET','/balance', function() {
    $account_id = $_GET['account_id'];
    echo Account::findAccountByIdWithDefault($account_id);
});
$router->addRoute('POST','/event', function() {
    $account = new Account(1);
    $account->deposit(100);
});


$router->route();