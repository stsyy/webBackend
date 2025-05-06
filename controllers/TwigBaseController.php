<?php
require_once "baseController.php"; // обязательно импортим BaseController

class TwigBaseController extends BaseController {
    public $title = ""; // название страницы
    public $template = ""; // шаблон страницы
    protected \Twig\Environment $twig; // ссылка на экземпляр twig, для рендернига
    
    // теперь пишем конструктор, 
    // передаем в него один параметр
    // собственно ссылка на экземпляр twig
    // это кстати Dependency Injection называется
    // это лучше чем создавать глобальный объект $twig 
    // и быстрее чем создавать персональный $twig обработчик для каждого класс 
    public function __construct($twig)
    {
        $this->twig = $twig; // пробрасываем его внутрь
    }
    
    // переопределяем функцию контекста
    public function getContext() : array
    {
        $context = parent::getContext();
        $context['books'] = $this->books;
        $context['tabs'] = $this->tabs;
        $context['tab1_url'] = $this->tab1_url;
        $context['tab2_url'] = $this->tab2_url;
        $context['tab1_text'] = $this->tab1_text;
        $context['tab2_text'] = $this->tab2_text;

        $context = array_merge($context, $this->image_data); // если понадобится
        return $context;
    }
    
    // функция гет, рендерит результат используя $template в качестве шаблона
    // и вызывает функцию getContext для формирования словаря контекста
    public function get() {
        echo $this->twig->render($this->template, $this->getContext());
    }
}