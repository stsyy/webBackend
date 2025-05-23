<?php

abstract class BaseController {

    public PDO $pdo;
    public array $params = [];
    protected \Twig\Environment $twig;

    public function __construct(\PDO $pdo, \Twig\Environment $twig) {
        $this->pdo = $pdo;
        $this->twig = $twig;
    }

    public function setParams(array $params): void {
        $this->params = $params;
    }

    public function setPDO(PDO $pdo): void {
        $this->pdo = $pdo;
    }

    public function getContext(): array {
        $context = [];

        // История переходов из сессии
        $context['page_history'] = $_SESSION['page_history'] ?? [];

        return $context;
    }

    public function setTabs($tab1_url, $tab2_url, $tab1_text, $tab2_text): array {
        return [
            "tab1_url" => $tab1_url,
            "tab2_url" => $tab2_url,
            "tab1_text" => $tab1_text,
            "tab2_text" => $tab2_text,
        ];
    }

    public function process_response(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_set_cookie_params(60 * 60 * 10);
            session_start();
        }

        // Очистим старый формат истории, если он есть
        if (isset($_SESSION['page_history']) && is_array($_SESSION['page_history'])) {
            if (!empty($_SESSION['page_history']) && is_string($_SESSION['page_history'][0])) {
                $_SESSION['page_history'] = []; // сбрасываем в случае старого формата
            }
        }

        $uri = $_SERVER['REQUEST_URI'];

        if (!preg_match('/\.(css|js|jpg|jpeg|png|gif|ico|svg)$/i', $uri)) {
            if (!isset($_SESSION['page_history'])) {
                $_SESSION['page_history'] = [];
            }

            $page_title = $this->resolveTitleFromURI($uri);
            $new_entry = ['url' => $uri, 'title' => $page_title];

           if (empty($_SESSION['page_history']) || !in_array(['url' => $uri, 'title' => $this->resolveTitleFromURI($uri)], $_SESSION['page_history'])) {
        array_unshift($_SESSION['page_history'], $new_entry);
        $_SESSION['page_history'] = array_slice($_SESSION['page_history'], 0, 10);
    }
        }

        $method = $_SERVER['REQUEST_METHOD'];
        $context = $this->getContext();

        if ($method === 'GET') {
            $this->get($context);
        } elseif ($method === 'POST') {
            $this->post($context);
        }
    }

    protected function resolveTitleFromURI(string $uri): string {
        $path = parse_url($uri, PHP_URL_PATH);

        return match (true) {
            $path === '/' => 'Главная',
            str_starts_with($path, '/search') => 'Поиск',
            str_starts_with($path, '/add_object_type') => 'Добавить тип',
            str_starts_with($path, '/add') => 'Добавить объект',
            str_starts_with($path, '/edit') => 'Редактирование',
            str_starts_with($path, '/theninth_wave/') && str_ends_with($path, '/image') => 'Картина — Картинка',
            str_starts_with($path, '/theninth_wave/') && str_ends_with($path, '/info') => 'Картина — Описание',
            str_starts_with($path, '/theninth_wave/') => 'Картина',
            default => 'Страница: ' . $uri,
        };
    }

    abstract public function get(array $context): void;
    abstract public function post(array $context): void;
}
