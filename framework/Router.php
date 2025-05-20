<?php

class Route {
    public string $route_regexp;
    public $controller;
    public string $method;

    public function __construct($route_regexp, $controller, $method = 'GET')
    {
        $this->route_regexp = $route_regexp;
        $this->controller = $controller;
        $this->method = strtoupper($method);
    }
}

class Router {
    /**
     * @var Route[]
     */
    protected $routes = [];

    protected $twig;
    protected $pdo;

    public function __construct($twig, $pdo)
    {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    public function add($route_regexp, $controller, $method = 'GET') {
        $this->routes[] = new Route("#^$route_regexp$#", $controller, $method);
    }

    public function get($route_regexp, $controller) {
        $this->add($route_regexp, $controller, 'GET');
    }

    public function post($route_regexp, $controller) {
        $this->add($route_regexp, $controller, 'POST');
    }

    public function get_or_default($default_controller) {
        $url = $_SERVER["REQUEST_URI"];
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $path = parse_url($url, PHP_URL_PATH);
        $matches = [];
        $controllerToUse = $default_controller;
        $methodToCall = 'get';
        $params = [];

        foreach ($this->routes as $route) {
            if ($route->method === $method && preg_match($route->route_regexp, $path, $matches)) {
                // Извлекаем только именованные параметры
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = $value;
                    }
                }

                $controllerToUse = $route->controller;
                $methodToCall = strtolower($method);
                break;
            }
        }

        $controllerInstance = new $controllerToUse($this->pdo, $this->twig);
        $controllerInstance->setParams($params);

        if (method_exists($controllerInstance, $methodToCall)) {
            return $controllerInstance->$methodToCall([]);
        } else {
            return $controllerInstance->get([]);
        }
    }
}
