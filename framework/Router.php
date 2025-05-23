<?php

class Route {
    public string $route_regexp;
    public $controller;
    public string $method;
    public array $middlewareList = [];

    public function middleware(BaseMiddleware $m): Route {
        array_push($this->middlewareList, $m);
        return $this;
    }

    public function __construct($route_regexp, $controller, $method = 'GET') {
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

    public function __construct($twig, $pdo) {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    public function add($route_regexp, $controller, $method = 'GET'): Route {
        $route = new Route("#^$route_regexp$#", $controller, $method);
        array_push($this->routes, $route);
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
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $path = parse_url($url, PHP_URL_PATH);
        $matches = [];
        $controllerToUse = $default_controller;
        $methodToCall = 'get';
        $params = [];
        $selectedRoute = null;

        foreach ($this->routes as $route) {
            if ($route->method === $method && preg_match($route->route_regexp, $path, $matches)) {
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $params[$key] = $value;
                    }
                }

                $controllerToUse = $route->controller;
                $methodToCall = strtolower($method);
                $selectedRoute = $route;
                break;
            }
        }

        $controllerInstance = new $controllerToUse($this->pdo, $this->twig);
        $controllerInstance->setParams($params);

        // ⬇️ MIDDLEWARE ДОЛЖЕН ВЫЗЫВАТЬСЯ ДО метода контроллера
        if ($selectedRoute) {
            foreach ($selectedRoute->middlewareList as $m) {
                $m->apply($controllerInstance, []);
            }
        }
return $controllerInstance->process_response();

        /*if (method_exists($controllerInstance, $methodToCall)) {
            return $controllerInstance->$methodToCall([]);
        } else {
            return $controllerInstance->get([]);
        }*/
    }
}
