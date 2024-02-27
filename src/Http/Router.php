<?php

namespace MaxPHPApi\Http;

class Router implements RouterInterface {
    private array $routes = [];
    private string $requestMethod;
    private array $server;

    public function __construct(array $server) {
        $this->server = $server;
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    public function addRoute(string $method, string $path, callable $callback): void {
        $this->routes[$method][$path] = $callback;
    }

    public function route(): mixed {
        $uri = $this->server['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$this->requestMethod][$path])) {
            $callback = $this->routes[$this->requestMethod][$path];
            return call_user_func($callback);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
