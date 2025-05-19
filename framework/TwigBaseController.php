<?php
require_once "BaseController.php";
//use PDO;

class TwigBaseController extends BaseController {
    public $title = "";
    public $template = "";
    protected \Twig\Environment $twig;

    public function setTwig(\Twig\Environment $twig): void
    {
        $this->twig = $twig;
    }

    public \PDO $pdo;

    public function __construct(\PDO $pdo, \Twig\Environment $twig)
    {
        $this->pdo = $pdo;
        $this->twig = $twig;
    }

    public function getContext(): array
    {
        $context = parent::getContext();
        // $context['books'] = $this->books;
        // $context['tabs'] = $this->tabs;
        // $context['tab1_url'] = $this->tab1_url;
        // $context['tab2_url'] = $this->tab2_url;
        // $context['tab1_text'] = $this->tab1_text;
        // $context['tab2_text'] = $this->tab2_text;
        // $context = array_merge($context, $this->image_data ?? []);
        return $context;
    }

    public function get(array $context): void // добавил аргумент в get и указал тип возвращаемого значения
    {
        echo $this->twig->render($this->template, $this->getContext() + $context); // тут объединяем базовый контекст с переданным
    }

    public function post(array $context): void // добавил аргумент в post и указал тип возвращаемого значения
    {
        echo $this->twig->render($this->template, $this->getContext() + $context); // тут объединяем базовый контекст с переданным
    }
}