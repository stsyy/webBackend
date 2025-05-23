<?php

class SetWelcomeController extends BaseController
{
    public function get(array $context): void {
$message = $_GET['message'] ?? '';
$_SESSION['welcome_message'] = $message;

if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}
array_push($_SESSION['messages'], $_GET['message']);


        $url = $_SERVER['HTTP_REFERER'];
        header("Location: $url");
        exit;
    }

    public function post(array $context): void {
        // Метод обязателен, даже если он не используется
    }
}
