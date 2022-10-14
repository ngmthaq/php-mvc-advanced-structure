<?php

namespace Core\App;

use Core\Request\Request;
use Core\Response\Response;
use Core\Helpers\Helper;
use Core\Helpers\Logger;
use Core\Locale\Locale;
use Dotenv\Dotenv;
use Exception;
use ReflectionClass;

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
        // Directory
        define("__ROOT__", str_replace("\core\App", "", __DIR__));

        // HTTP Status Code
        define("STATUS_SUCCESS", 200);
        define("STATUS_BAD_REQUEST", 400);
        define("STATUS_UNAUTHORIZED", 401);
        define("STATUS_FORBIDDEN", 403);
        define("STATUS_NOT_FOUND", 404);
        define("STATUS_METHOD_NOT_ALLOWED", 405);
        define("STATUS_FAILED_VALIDATION", 422);
        define("STATUS_INTERNAL_SERVER_ERROR", 500);
        define("STATUS_SERVICE_UNAVAILABLE", 503);

        // Request mode
        define("USE_QUERY", 0);
        define("USE_PARAMS", 1);

        // Resources return type
        define("BASE64_RESOURCES", 0);
        define("BINARY_RESOURCES", 1);

        // Lang const
        define("LOCALE_KEY", "locale");
        define("DEFAULT_LOCALE_KEY", "default_locale");
        define("AVAILABLE_LOCALES_KEY", "available_locales");
    }

    public function env()
    {
        $dotenv = Dotenv::createImmutable(__ROOT__);
        $dotenv->load();
    }

    public function get(string $uri, array $action, array $middlewares = [])
    {
        $this->routes["GET"][$uri] = ["action" => $action, "middlewares" => $middlewares];
    }

    public function post(string $uri, array $action, array $middlewares = [])
    {
        $this->routes["POST"][$uri] = ["action" => $action, "middlewares" => $middlewares];
    }

    public function configSession()
    {
        if ($_ENV["APP_KEY"] === "") {
            throw new Exception("Missing APP_KEY enviroment variable");
        } else {
            if (empty($_SESSION["APP_KEY"]) || strcmp($_ENV["APP_KEY"], $_SESSION["APP_KEY"]) !== 0) {
                $locale = new Locale();
                session_unset();
                $_SESSION["APP_KEY"] = $_ENV["APP_KEY"];
                $locale->config();
                reload();
            }
        }
    }

    public function run()
    {
        try {
            $this->configSession();
            $method = Helper::server("REQUEST_METHOD");
            if (array_key_exists($method, $this->routes)) {
                $routes = $this->routes[$method];
                $uri = explode("?", Helper::server("REQUEST_URI"))[0];
                if ($uri && array_key_exists($uri, $routes)) {
                    $req = new Request($routes[$uri]);
                    $res = new Response();
                    $isSuccess = $this->runMiddlewares($req, $res);
                    if ($isSuccess) {
                        $this->runController($uri, $req, $res);
                    }
                } else {
                    $this->detectNFOrMNA(new Response());
                }
            } else {
                $this->detectNFOrMNA(new Response());
            }
        } catch (Exception $e) {
            $this->runISEResponse(new Response(), $e);
        }
    }

    private function runController(string $uri, Request $req, Response $res)
    {
        $method = Helper::server("REQUEST_METHOD");
        $action = $this->routes[$method][$uri]["action"];
        $controller = $action[0];
        $callable = $action[1];
        $classConf = new ReflectionClass($controller);
        $classMethods = $classConf->getMethods();
        $classMethods = array_map(function ($method) {
            return $method->name;
        }, $classMethods);

        $errorMsg = "Cannot find method '" . $callable . "' in class '" . $controller . "'";
        in_array($callable, $classMethods)
            ? call_user_func_array([new $controller($req, $res), $callable], [])
            : $this->runISEResponse(new Response(), new Exception($errorMsg));
    }

    private function runMiddlewares(Request $req, Response $res)
    {
        $middlewaresDir = __ROOT__ . "\\configs\\middlewares.php";
        $middlewares = include_once($middlewaresDir);
        $globalMiddlewares = $middlewares["global"];
        $aliasMiddlewares = $middlewares["alias"];
        $configMiddlewares = $req->configs()["middlewares"];
        $routeMiddlewares = array_map(function ($m) use ($aliasMiddlewares) {
            if (array_key_exists($m, $aliasMiddlewares)) {
                return $aliasMiddlewares[$m];
            }

            throw new Exception("Middleware not found: " . $m);
        }, $configMiddlewares);

        $totalMiddlewares = array_merge($globalMiddlewares, $routeMiddlewares);

        foreach ($totalMiddlewares as $middleware) {
            $isSuccess = call_user_func_array([new $middleware($req, $res), "handle"], []);
            if (!$isSuccess) {
                return false;
            }
        }

        return true;
    }

    private function runNotFoundResponse(Response $res)
    {
        return $res->json(["error" => "Not Found"], STATUS_NOT_FOUND);
    }

    private function runMethodNotAllowedResponse(Response $res)
    {
        return $res->json(["error" => "Method Not Allowed"], STATUS_METHOD_NOT_ALLOWED);
    }

    private function detectNFOrMNA(Response $res)
    {
        $get = array_key_exists("GET", $this->routes) ? $this->routes["GET"] : [];
        $post = array_key_exists("POST", $this->routes) ? $this->routes["POST"] : [];
        $uri = explode("?", Helper::server("REQUEST_URI"))[0];

        $isExistedInGet = in_array($uri, array_keys($get));
        $isExistedInPost = in_array($uri, array_keys($post));

        return $isExistedInGet || $isExistedInPost
            ? $this->runMethodNotAllowedResponse($res)
            : $this->runNotFoundResponse($res);
    }

    private function runISEResponse(Response $res, Exception $e)
    {
        Logger::write($e);
        $response = ["error" => "Internal Server Error"];
        if (Helper::env("APP_ENV") === "development") {
            $response = array_merge($response, ["details" => [
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine(),
                "trace" => $e->getTraceAsString(),
            ]]);
        }

        return $res->json($response, STATUS_INTERNAL_SERVER_ERROR);
    }
}
