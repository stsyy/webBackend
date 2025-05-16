<?php

abstract class BaseController {

    public PDO $pdo; // добавил поле
    public array $params;

        // добавил сеттер
        public function setParams(array $params): void
        {
         $this->params = $params;
    }


    public function setPDO(PDO $pdo): void
    { // и сеттер для него
        $this->pdo = $pdo;
    }

    public function getContext(): array
    {
        return [];
    }
    public function setTabs($tab1_url, $tab2_url, $tab1_text, $tab2_text): array
    {
        return [
            "tab1_url" => $tab1_url,
            "tab2_url" => $tab2_url,
            "tab1_text" => $tab1_text,
            "tab2_text" => $tab2_text,
        ];
    }

    public function process_response(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $context = $this->getContext(); // вызываю context тут
        if ($method == 'GET') {
            $this->get($context); // а тут просто его пробрасываю внутрь
        } elseif ($method == 'POST') {
            $this->post($context); // и здесь
        }
    }

    abstract public function get(array $context): void; // ну и сюда добавил в качестве параметра и сделал абстрактным
    abstract public function post(array $context): void; // и сюда и сделал абстрактным
}