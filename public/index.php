<?php

//session_start();
require_once '../vendor/autoload.php';

require_once '../framework/autoload.php';

require_once "../controllers/MainController.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/AddObjectTypeController.php";
require_once "../controllers/BayController.php";
require_once "../controllers/BayImageController.php";
require_once "../controllers/BayInfoController.php";
require_once "../controllers/WaveInfoController.php";
require_once "../controllers/WaveController.php";
require_once "../controllers/WaveImageController.php";
require_once "../controllers/Controller404.php";
require_once "../controllers/AddController.php"; 
require_once "../controllers/UpdateController.php"; 
require_once "../middlewares/LoginRequiredMiddleware.php";
require_once "../controllers/DeleteController.php"; 
require_once "../controllers/SetWelcomeController.php"; 
require_once "../controllers/LoginController.php"; // Подключаем LoginController
require_once "../controllers/LogoutController.php"; // Подключаем LogoutController

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$context = []; 

$controller = null;

//$pdo = new PDO("mysql:host=localhost;dbname=pictures;charset=utf8", "root", "");

$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true // добавляем тут debug режим
]);

//$url = $_SERVER["REQUEST_URI"];

$twig->addExtension(new \Twig\Extension\DebugExtension());

$template = "";
$title = "";
$image_data = [];
$tab1_url = "";
$tab2_url = "";
$tab1_text = "";
$tab2_text = "";

$books = [
    [
        'name' => 'Девятый вал',
        'base_url' => '/ninthval',
        'tabs' => [
            ['url' => '/ninthval/image', 'text' => 'Картинка'],
            ['url' => '/ninthval/info', 'text' => 'Описание']
        ],
        'button_type' => 'dark',
        'button_extra' => 'd-block mb-3 btn btn-lg w-100 btn-outline-dark text-start p-3'
    ],
    [
        'name' => 'Неаполитанский залив',
        'base_url' => '/thebayofnaples',
        'tabs' => [
            ['url' => '/thebayofnaples/image', 'text' => 'Картинка'],
            ['url' => '/thebayofnaples/info', 'text' => 'Описание']
        ],
        'button_type' => 'dark',
        'button_extra' => 'd-block mb-3 btn btn-lg w-100 btn-outline-dark text-start p-3'
    ]
];

$tabs = [];
function setTabs($tab1_url, $tab2_url, $tab1_text, $tab2_text) {
    return [
        "tab1_url" => $tab1_url,
        "tab2_url" => $tab2_url,
        "tab1_text" => $tab1_text,
        "tab2_text" => $tab2_text,
    ];
}
$pdo = new PDO("mysql:host=localhost;dbname=pictures;charset=utf8", "root", "");

$router = new Router($twig, $pdo);

$router->get("/login", LoginController::class);
$router->post("/login", LoginController::class);
$router->get("/logout", LogoutController::class);


$router->add("/", MainController::class);
$router->add("/theninth_wave/(?P<id>\d+)/image", ObjectController::class);
$router->add("/theninth_wave/(?P<id>\d+)/info", ObjectController::class);
$router->add("/theninth_wave/(?P<id>\d+)", ObjectController::class);
$router->add("/search", SearchController::class);
//$router->add("/add", AddController::class);
$router->get("/add", AddController::class) 
       ->middleware(new LoginRequiredMiddleware());
$router->post("/add", AddController::class) 
->middleware(new LoginRequiredMiddleware());
$router->get("/add_object_type", AddObjectTypeController::class) 
->middleware(new LoginRequiredMiddleware());
$router->post("/add_object_type", AddObjectTypeController::class) 
->middleware(new LoginRequiredMiddleware());
$router->post("/theninth_wave/delete", DeleteController::class)
->middleware(new LoginRequiredMiddleware());

// Для списка объектов
$router->get("/edit", UpdateController::class)
->middleware(new LoginRequiredMiddleware());
// Для формы редактирования
$router->get("/edit/(?P<id>\d+)", UpdateController::class)
->middleware(new LoginRequiredMiddleware());
// Для обработки POST-запроса
$router->post("/edit/(?P<id>\d+)", UpdateController::class)
->middleware(new LoginRequiredMiddleware());

$router->add("/set_welcome", SetWelcomeController::class);
$twig->addFilter(new \Twig\TwigFilter('urldecode', function ($string) {
    return urldecode($string);
}));


$router->get_or_default(Controller404::class);

?>
