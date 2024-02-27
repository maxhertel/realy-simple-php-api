<?php
namespace MaxPHPApi\Http;
interface RouterInterface {
    public function addRoute(string $method, string $path, callable $callback):void;
    public function route():mixed;
}