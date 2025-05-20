<?php

class LoginRequiredMiddleware extends BaseMiddleware
{
    public function apply(BaseController $controller, array $context): void
    {
        // Если уже авторизован — пропускаем
        if (isset($_SESSION['user_id'])) {
            return;
        }

        // Если форма логина отправлена
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $controller->pdo->prepare("SELECT id, password FROM users WHERE username = :username");
            $stmt->bindValue(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $user['password'] === $password) {
                // Пароль совпадает — логиним
                $_SESSION['user_id'] = $user['id'];
                return;
            } else {
                // Неверный логин/пароль
                echo "❌ Неверный логин или пароль";
                exit;
            }
        }

        // Если не авторизован и форма не отправлена — показываем форму
        echo '<form method="POST">
                <input type="text" name="username" placeholder="Логин"><br>
                <input type="password" name="password" placeholder="Пароль"><br>
                <button type="submit">Войти</button>
              </form>';
        exit;
    }
}

/*class LoginRequiredMiddleware extends BaseMiddleware {
  public function apply(BaseController $controller, array $context)
  {

   // echo "Авторизуйтесь пожалуйста";

      // заводим переменные под правильный пароль
      $valid_user = "admin";
      $valid_password = "123";
      
      // берем значения которые введет пользователь
      $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
      $password = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
      
      // сверяем с корректными
      if ($valid_user != $user || $valid_password != $password) {
          // если не совпали, надо указать такой заголовок
          // именно по нему браузер поймет что надо показать окно для ввода юзера/пароля
          header('WWW-Authenticate: Basic realm="Space objects"');
          http_response_code(401); // ну и статус 401 -- Unauthorized, то есть неавторизован
          exit; // прерываем выполнение скрипта
      }
  }
}*/