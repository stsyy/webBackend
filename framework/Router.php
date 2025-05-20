<?php

class Route {
    public string $route_regexp;
    public $controller;
    public string $method;
    public array $middlewareList = [];

    public function __construct($route_regexp, $controller, $method = 'GET') {
        $this->route_regexp = $route_regexp;
        $this->controller = $controller;
        $this->method = strtoupper($method);
    }

    public function middleware(BaseMiddleware $m): Route {
        $this->middlewareList[] = $m;
        return $this;
    }
}


class Router {
    /**
     * @var Route[]
     */
    protected array $routes = [];

    protected $twig;
    protected $pdo;

    public function __construct($twig, $pdo) {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    public function add($route_regexp, $controller, $method = 'GET'): Route {
        $route = new Route("#^$route_regexp$#", $controller, $method);
        $this->routes[] = $route;
        return $route;
    }

    public function get($route_regexp, $controller): Route {
        return $this->add($route_regexp, $controller, 'GET');
    }

    public function post($route_regexp, $controller): Route {
        return $this->add($route_regexp, $controller, 'POST');
    }

    public function get_or_default($default_controller) {
        $url = $_SERVER["REQUEST_URI"];
        $method = strtoupper($_SERVER["REQUEST_METHOD"]);
        $path = parse_url($url, PHP_URL_PATH);
        $params = [];
        $matchedRoute = null;

        foreach ($this->routes as $route) {
            if ($route->method === $method && preg_match($route->route_regexp, $path, $matches)) {
                $matchedRoute = $route;
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = $value;
                    }
                }
                break;
            }
        }

        $controllerClass = $default_controller;
        $methodToCall = 'get';

        if ($matchedRoute) {
            $controllerClass = $matchedRoute->controller;
            $methodToCall = strtolower($method);
        }

        $controllerInstance = new $controllerClass($this->pdo, $this->twig);
        $controllerInstance->setParams($params);

        // Применяем middleware ДО вызова метода контроллера
        if ($matchedRoute) {
            foreach ($matchedRoute->middlewareList as $middleware) {
                $middleware->apply($controllerInstance, []);
            }
        }

        if (method_exists($controllerInstance, $methodToCall)) {
            return $controllerInstance->$methodToCall([]);
        } else {
            return $controllerInstance->get([]);
        }
    }
}