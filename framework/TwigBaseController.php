<?php
require_once "BaseController.php";
//use PDO;

class TwigBaseController extends BaseController {
    public $title = "";
    public $template = "";
    protected \Twig\Environment $twig;

    public function setTwig($twig) {
        $this->twig = $twig;
    }

    public \PDO $pdo;

    public function __construct(\Twig\Environment $twig, \PDO $pdo) {
        $this->twig = $twig;
        $this->pdo = $pdo;
    }

    public function getContext(): array {
        $context = parent::getContext();
        $context['books'] = $this->books;
        $context['tabs'] = $this->tabs;
        $context['tab1_url'] = $this->tab1_url;
        $context['tab2_url'] = $this->tab2_url;
        $context['tab1_text'] = $this->tab1_text;
        $context['tab2_text'] = $this->tab2_text;
        $context = array_merge($context, $this->image_data ?? []);
        return $context;
    }

    public function get() {
        echo $this->twig->render($this->template, $this->getContext());
    }
}