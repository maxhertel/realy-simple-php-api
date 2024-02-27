<?php

require_once 'vendor/autoload.php';

use MaxPHPApi\Database\DBBuilder;
use MaxPHPApi\Entities\Account\Account;
use MaxPHPApi\Entities\Account\AccountRepository;
use MaxPHPApi\Http\Router;

// Cria uma instância do repositório
$accountRepository = new AccountRepository();

// Cria uma nova conta e adiciona ao repositório
$account1 = new Account(100);
$accountRepository->addAccount($account1);

// Cria uma instância da classe DBBuilder com as configurações padrão obtidas do ambiente
$db = new DBBuilder();

$router = new Router($_SERVER);

//TODO:segrate responsibilite
$router->addRoute('GET','/balance', function() {
    $account = new Account(100);
    echo $account->getBalance();
});


$router->route();