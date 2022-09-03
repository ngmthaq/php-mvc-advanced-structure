<?php

namespace Core\App;

use Core\Request\Request;
use Core\Response\Response;
use Dotenv\Dotenv;

class App
{
    protected $routes = [];

    public function __construct()
    {
        $this->define();
        $this->env();
    }

    public function define()
    {
        define("__ROOT__", str_replace("\core\App", "", __DIR__));
    }

    public function env()
    {
        $dotenv = Dotenv::createImmutable(__ROOT__);
        $dotenv->load();
    }

    public function get(string $uri, array $action)
    {
        $this->routes = array_merge($this->routes, [$uri => ["method" => "GET", "action" => $action]]);
    }

    public function post(string $uri, array $action)
    {
        $this->routes = array_merge($this->routes, [$uri => ["method" => "POST", "action" => $action]]);
    }

    public function run()
    {
        if (array_key_exists($uri = $_SERVER["REQUEST_URI"], $this->routes)) {
            $req = new Request($this->routes[$uri]);
            $res = new Response();
            $isSuccess = $this->runGlobalMiddlewares($req, $res);
            if ($isSuccess) {
                $this->runController($uri, $req, $res);
            } else {
                return 0;
            }
        } else {
            $this->runNotFoundResponse(new Response());
        }
    }

    private function runController(string $uri, Request $req, Response $res)
    {
        $action = $this->routes[$uri]["action"];
        $controller = $action[0];
        $callable = $action[1];
        call_user_func_array([new $controller($req, $res), $callable], []);
    }

    private function runGlobalMiddlewares(Request $req, Response $res)
    {
        $middlewaresDir = __ROOT__ . "\\configs\\middlewares.php";
        $middlewares = include_once($middlewaresDir);
        $globalMiddlewares = $middlewares["global"];

        foreach ($globalMiddlewares as $middleware) {
            $isSuccess = call_user_func_array([new $middleware($req, $res), "handle"], []);
            if (!$isSuccess) {
                return false;
            }
        }

        return true;
    }

    private function runNotFoundResponse(Response $res)
    {
        return $res->json(["error" => "Not Found"], 404);
    }
}
