<?php

require_once 'vendor/autoload.php';

use MaxPHPApi\Entities\Account\Account;
use  MaxPHPApi\Http\Router;


$router = new Router($_SERVER);

//TODO:segrate responsibilite
$router->addRoute('GET','/balance', function() {
    $account = new Account(100);
    echo $account->getBalance();
});


$router->route();