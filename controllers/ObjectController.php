<?php
require_once "BaseSpaceTwigController.php";
class ObjectController extends BaseSpaceTwigController {
    public $template = "__object.twig"; // указываем шаблон
    public $books = [];       // даже если не используется
    public $tabs = [];
    public $image_data = [];
    public $tab1_url = "";
    public $tab2_url = "";
    public $tab1_text = "";
    public $tab2_text = "";

    public function getContext(): array
{
    $context = parent::getContext();

    $id = $this->params[1]; // индекс 1 — потому что в маршруте /theninth_wave/(\d+)
    
    $query = $this->pdo->prepare("SELECT * FROM theninth_wave WHERE id = :id");
    $query->execute(["id" => $id]);
    $painting = $query->fetch();

    if ($painting) {
        $context['painting'] = $painting;
    } else {
        $context['painting'] = [
            'title' => 'Картина не найдена',
            'image' => '',
            'description' => ''
        ];
    }

    return $context;
}

    
    //public function getContext(): array
    //{
       // $context = parent::getContext();
               // добавил вывод params
              // echo "<pre>";
               //print_r($this->params);
              // echo "</pre>";
        
        // готовим запрос к БД, допустим вытащим запись по id=3
        // тут уже указываю конкретные поля, там более грамотно
       // $query = $this->pdo->query("SELECT description, id FROM theninth_wave WHERE id=" . $this->params['id']);
        // стягиваем одну строчку из базы
       // $data = $query->fetch();
        
        // передаем описание из БД в контекст
       // $context['description'] = $data['description'];

       // return $context;
   // }
}