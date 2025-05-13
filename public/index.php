<?php
require_once '../vendor/autoload.php';

require_once '../framework/autoload.php';

require_once "../controllers/MainController.php";
require_once "../controllers/ObjectController.php";
require_once "../controllers/ImageController.php";
require_once "../controllers/InfoController.php";
require_once "../controllers/BayController.php";
require_once "../controllers/BayImageController.php";
require_once "../controllers/BayInfoController.php";
require_once "../controllers/WaveInfoController.php";
require_once "../controllers/WaveController.php";
require_once "../controllers/WaveImageController.php";
require_once "../controllers/Controller404.php";
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

//$controller = new Controller404($twig);

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
$router->add("/", MainController::class);
$router->add("/theninth_wave/(?P<id>\d+)/image", ImageController::class);
$router->add("/theninth_wave/(?P<id>\d+)/info", InfoController::class);
$router->add("/theninth_wave/(?P<id>\d+)", ObjectController::class);
$router->get_or_default(Controller404::class);

/*if ($url == "/") {
    $controller = new MainController($twig);
} */

// if ($template) {
//     echo $twig->render($template, array_merge([
//         "title" => $title,
//         "current_url" => $url,
//         'books' => $books
//     ], $tabs, $image_data));
// }

/*if ($controller) {
    $controller->setPDO($pdo);
    $controller->get();
}*/

?>
