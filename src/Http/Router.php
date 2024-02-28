<?php
namespace MaxPHPApi\Http;

class Router implements RouterInterface {
    private array $routes = [];
    private string $requestMethod;
    private array $server;
    private array $postData;

    public function __construct(array $server) {
        $this->server = $server;
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->postData = $_POST; // Captura os dados POST
    }

    public function addRoute(string $method, string $path, callable $callback): void {
        $this->routes[$method][$path] = $callback;
    }

    public function route(): mixed {
        $uri = $this->server['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$this->requestMethod][$path])) {
            // Se for uma requisição POST
            if ($this->requestMethod === 'POST') {
                // Verifica se os dados POST estão no formato JSON
                $jsonPayload = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $this->postData = $jsonPayload;
                }
            }

            $callback = $this->routes[$this->requestMethod][$path];
            return call_user_func($callback, $this->postData); // Passa os dados POST para o callback
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
