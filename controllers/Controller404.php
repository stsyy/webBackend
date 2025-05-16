<?php
//require_once "TwigBaseController.php";
require_once "BaseSpaceTwigController.php";
class Controller404 extends BaseSpaceTwigController {
    public $template = "404.twig";
    public $title = "Страница не найдена";
    // public $books = []; // Эти свойства наследуются от BaseSpaceTwigController
    // public $tabs = [];
    // public $image_data = [];
    // public $tab1_url = "/thebayofnaples/image";
    // public $tab2_url = "/thebayofnaples/info";
    // public $tab1_text = "Картинка";
    // public $tab2_text = "Информация";
    // public $tab11_url = "/ninthval/image";
    // public $tab22_url = "/ninthval/info";
    // public $tab11_text = "Картинка";
    // public $tab22_text = "Информация";

    public function getContext(): array
    {
        $context = parent::getContext();
        $context['tab1_url'] = "/thebayofnaples/image";
        $context['tab2_url'] = "/thebayofnaples/info";
        $context['tab1_text'] = "Картинка";
        $context['tab2_text'] = "Информация";
        $context['tab11_url'] = "/ninthval/image";
        $context['tab22_url'] = "/ninthval/info";
        $context['tab11_text'] = "Картинка";
        $context['tab22_text'] = "Информация";
        return $context;
    }

    public function get(array $context = []): void
    {
        http_response_code(404);
        parent::get($context);
    }
}