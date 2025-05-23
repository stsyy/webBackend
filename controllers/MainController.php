<?php
require_once "BaseSpaceTwigController.php";

class MainController extends BaseSpaceTwigController {
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array
    {
        error_log("MainController::getContext вызван");

        $context = parent::getContext();

        $period = $_GET['period'] ?? null;
        $type_id = $_GET['type'] ?? null;

        $sql = "SELECT * FROM theninth_wave";
        $conditions = [];
        $params = [];

        if ($period) {
            $conditions[] = "period = :period";
            $params['period'] = $period;
            $context['current_period'] = $period;
        }

        if ($type_id) {
            $conditions[] = "object_type_id = :type_id";
            $params['type_id'] = $type_id;
            $context['current_type'] = $type_id;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        $context['theninth_wave'] = $query->fetchAll();

        // Загружаем список типов объектов для меню
        $type_query = $this->pdo->query("SELECT * FROM object_types");
        $context['object_types'] = $type_query->fetchAll();

        // Загружаем список периодов для меню (если используется)
        $period_query = $this->pdo->query("SELECT DISTINCT period FROM theninth_wave");
        $context['periods'] = $period_query->fetchAll();

        return $context;
    }

    public function get(array $context): void {
    $this->twig->display("main.twig", $this->getContext());
}

public function post(array $context): void {
    // сюда твой код для POST или пусто, если не нужен
}

    // Оставим это, если используешь в шаблоне (но не обязательно)
    public $books = [
        [
            'name' => 'Девятый вал', 'base_url' => '/ninthval',
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
}
