<?php

// сначала создадим класс под один маршрут
class Route {
    public string $route_regexp; // тут получается шаблона url
    public $controller; // а это класс контроллера
    public string $method; // добавляем поле для метода запроса

    // ну и просто конструктор
    public function __construct($route_regexp, $controller, $method = 'GET')
    {
        $this->route_regexp = $route_regexp;
        $this->controller = $controller;
        $this->method = strtoupper($method); // приводим метод к верхнему регистру для единообразия
    }
}
class Router {
    /**
     * @var Route[]
     */
    protected $routes = []; // создаем поле -- список под маршруты и привязанные к ним контроллеры

    protected $twig; // переменные под twig и pdo
    protected $pdo;

    // конструктор
    public function __construct($twig, $pdo)
    {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    // функция с помощью которой добавляем маршрут
    public function add($route_regexp, $controller, $method = 'GET') {
        // по сути просто пихает маршрут с привязанным контроллером в $routes
        $this->routes[] = new Route("#^$route_regexp$#", $controller, $method);
    }

    // shortcuts for adding GET and POST routes
    public function get($route_regexp, $controller) {
        $this->add($route_regexp, $controller, 'GET');
    }

    public function post($route_regexp, $controller) {
        $this->add($route_regexp, $controller, 'POST');
    }

    // функция которая должна по url и методу найти маршрут и вызывать соответствующий метод контроллера
    // если маршрут не найден, то будет использоваться контроллер по умолчанию
    public function get_or_default($default_controller) {
        $url = $_SERVER["REQUEST_URI"];
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $path = parse_url($url, PHP_URL_PATH);
        $matches = [];
        $controllerToUse = $default_controller;
        $methodToCall = 'get';
    
        foreach ($this->routes as $route) {
            if ($route->method === $method && preg_match($route->route_regexp, $path, $matches)) {
                $controllerToUse = $route->controller;
                $methodToCall = strtolower($method);
                break;
            }
        }
    
        $controllerInstance = new $controllerToUse($this->twig, $this->pdo);
        $controllerInstance->setParams($matches);
    
        if (method_exists($controllerInstance, $methodToCall)) {
            return $controllerInstance->$methodToCall([]); // Передаем пустой массив контекста
        } else {
            return $controllerInstance->get([]); // Передаем пустой массив контекста и для запасного варианта
        }
    }
}