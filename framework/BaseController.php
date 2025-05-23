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

        // Передаём is_logged и session в шаблоны
        $context['is_logged'] = $_SESSION['is_logged'] ?? false;
        $context['session'] = $_SESSION;
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
        session_start(); // <-- Сессия должна стартовать ПЕРВОЙ!
    }

        // Обработка истории просмотров
        $uri = $_SERVER['REQUEST_URI'];

        if (!preg_match('/\.(css|js|jpg|jpeg|png|gif|ico|svg)$/i', $uri)) {
            if (!isset($_SESSION['page_history'])) {
                $_SESSION['page_history'] = [];
            }

            if (!empty($_SESSION['page_history']) && is_string($_SESSION['page_history'][0])) {
                $_SESSION['page_history'] = []; // сбрасываем старый формат
            }

            $entry = ['url' => $uri, 'title' => $uri];
            if (empty($_SESSION['page_history']) || !isset($_SESSION['page_history'][0]['url']) || $_SESSION['page_history'][0]['url'] !== $uri) {
                array_unshift($_SESSION['page_history'], $entry);
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

    abstract public function get(array $context): void;
    abstract public function post(array $context): void;
}
