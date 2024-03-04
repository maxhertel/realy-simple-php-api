<?php

require_once 'vendor/autoload.php';

use MaxPHPApi\Entities\Account\AccountService;
use MaxPHPApi\Http\Router;

$router = new Router($_SERVER);

//TODO:segrate responsibilite   
$router->addRoute('GET','/reset', function() {
    echo AccountService::reset();
});
$router->addRoute('GET','/balance', function() {
    $account_id = $_GET['account_id'];
    echo AccountService::findAccountByIdWithDefault($account_id);
});
$router->addRoute('POST','/event', function($json) {
   echo  AccountService::event($json);
});


$router->route();