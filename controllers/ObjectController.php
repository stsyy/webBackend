<?php
require_once "BaseSpaceTwigController.php";

class ObjectController extends BaseSpaceTwigController {
    public $template = "__object.twig";
    public $books = [];
    public $tabs = [];
    public $tab1_url = "";
    public $tab2_url = "";
    public $tab1_text = "";
    public $tab2_text = "";

    public function getContext(): array {
        $context = parent::getContext();

        $id = $this->params['id'] ?? null;

        if (!$id) {
            $context['painting'] = [
                'title' => 'Картина не найдена',
                'image' => '',
                'description' => ''
            ];
            return $context;
        }

        // Загружаем данные из БД
        $query = $this->pdo->prepare("SELECT * FROM theninth_wave WHERE id = :id");
        $query->execute(["id" => $id]);
        $painting = $query->fetch();

        $context['painting'] = $painting ?: [
            'title' => 'Картина не найдена',
            'image' => '',
            'description' => ''
        ];

        // Передаём параметр "show" в шаблон
        $context['show'] = $_GET['show'] ?? null;
      $context["my_session_message"] = isset($_SESSION['welcome_message']) ? $_SESSION['welcome_message'] : "";
        return $context;
    }

}
