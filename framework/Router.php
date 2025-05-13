<?php

// сначала создадим класс под один маршрут
class Route {
    public string $route_regexp; // тут получается шаблона url
    public $controller; // а это класс контроллера

    // ну и просто конструктор
    public function __construct($route_regexp, $controller)
    {
        $this->route_regexp = $route_regexp;
        $this->controller = $controller;
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
    public function add($route_regexp, $controller) {
        // по сути просто пихает маршрут с привязанным контроллером в $routes
        array_push($this->routes, new Route("#^$route_regexp$#", $controller));
    }

    // функция которая должна по url найти маршрут и вызывать его функцию get
    // если маршрут не найден, то будет использоваться контроллер по умолчанию
    public function get_or_default($default_controller) {
        $url = $_SERVER["REQUEST_URI"];
       
    $path = parse_url($url, PHP_URL_PATH); // вытаскиваем адрес
    echo $path; // выводим

   // echo "<pre>"; // чтобы красивее выводил
   // print_r($_GET); // выведем содержимое $_GET
   // echo "</pre>";

        $controller = $default_controller;
        $matches = [];
    
        foreach ($this->routes as $route) {
            if (preg_match($route->route_regexp, $path, $matches)) {
                $controller = $route->controller;
                break;
            }
        }
    
        // ✅ Передаем $twig в конструктор контроллера
        $controllerInstance = new $controller($this->twig, $this->pdo);
        //$controllerInstance->setPDO($this->pdo);
        $controllerInstance->setParams($matches);
    
       // if ($controllerInstance instanceof TwigBaseController) {
         //   $controllerInstance->setTwig($this->twig); // Дополнительно, если используется setTwig
        //}
    
        return $controllerInstance->get();
    }
}