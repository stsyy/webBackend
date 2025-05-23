<?php
class LogoutController extends BaseController {
   public function get(array $context): void {
    $_SESSION['is_logged'] = false;
    header("Location: /login");
    exit;
}

    public function post(array $context): void {
        $this->get($context); // выход возможен и по POST
    }
}
