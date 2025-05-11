<?php
//require_once "TwigBaseController.php"; // импортим TwigBaseController
require_once "BaseSpaceTwigController.php";
class MainController extends BaseSpaceTwigController {
    public $template = "main.twig";
    public $title = "Главная";

       // добавим метод getContext()
       public function getContext(): array
       {
           $context = parent::getContext();
           
           // подготавливаем запрос SELECT * FROM space_objects
           // вообще звездочку не рекомендуется использовать, но на первый раз пойдет
           $query = $this->pdo->query("SELECT * FROM theninth_wave");
           
           // стягиваем данные через fetchAll() и сохраняем результат в контекст
           $context['theninth_wave'] = $query->fetchAll();
   
           return $context;
       }

    public $books = [
        [
            'name' => 'Девятый вал','base_url' => '/ninthval',
            'tabs' => [
                ['url' => '/ninthval/image', 'text' => 'Картинка'],
                ['url' => '/ninthval/info', 'text' => 'Описание']
            ]
        ],
        [
            'name' => 'Неаполитанский залив', 'base_url' => '/thebayofnaples',
            'tabs' => [
                ['url' => '/thebayofnaples/image', 'text' => 'Картинка'],
                ['url' => '/thebayofnaples/info', 'text' => 'Описание']
            ]
        ]
    ];
    public $tabs = [];
    public $image_data = [];
    public $tab1_url = "";
    public $tab2_url = "";
    public $tab1_text = "";
    public $tab2_text = "";
}