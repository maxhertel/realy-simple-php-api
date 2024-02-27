<?php

require_once 'autoload.php';

use Entities\Account\Account;
use  Http\Router;


$router = new Router($_SERVER);

//TODO:segrate responsibilite
$router->addRoute('GET','/balance', function() {
    $account = new Account(100);
    echo $account->getBalance();
});


$router->route();