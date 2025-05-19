<?php

class DeleteController extends BaseController {

 public function __construct(\PDO $pdo, \Twig\Environment $twig) {
        parent::__construct($pdo, $twig);
    }

    public function get(array $context): void {
        // Перенаправление, если кто-то случайно зайдёт по GET
        header("Location: /");
        exit;
    }

    public function post(array $context): void {
        $id = $_POST['id'] ?? null;

        if ($id) {
            $sql = "DELETE FROM theninth_wave WHERE id = :id";
            $query = $this->pdo->prepare($sql);
            $query->bindValue(":id", $id);
            $query->execute();
        }

        header("Location: /");
        exit;
    }
}

