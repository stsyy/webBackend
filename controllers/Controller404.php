<?php
//require_once "TwigBaseController.php";

class Controller404 extends TwigBaseController {
    public $template = "404.twig";
    public $title = "Страница не найдена";
    public $books = []; // даже если не используешь — просто чтобы не было ошибки
    public $tabs = [];
    public $image_data = [];
    public $tab1_url = "/thebayofnaples/image";
    public $tab2_url = "/thebayofnaples/info";
    public $tab1_text = "Картинка";
    public $tab2_text = "Информация";
    public $tab11_url = "/ninthval/image";
    public $tab22_url = "/ninthval/info";
    public $tab11_text = "Картинка";
    public $tab22_text = "Информация";
    public function get()
    {
        http_response_code(404); 
        parent::get(); 
    }
}