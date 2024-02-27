<?php
spl_autoload_register(function ($class) {
    // Converte o namespace em caminho de arquivo
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';

    // Verifica se o arquivo existe
    if (file_exists($file)) {
        require $file;
    }
});