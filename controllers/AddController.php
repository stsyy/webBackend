<?php
require_once "BaseSpaceTwigController.php";

class AddController extends BaseSpaceTwigController
{
    public $template = "add.twig";
    public $title = "Добавить картину";

    public function getContext(): array
    {
        $context = parent::getContext();

        $context['current_page'] = 'add';

        $sql = "SELECT id, name FROM object_types";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $context['object_types'] = $query->fetchAll();

        return $context;
    }

    public function get(array $context = []): void
    {
        if (isset($_SESSION['message'])) {
            $context['message'] = $_SESSION['message'];
            unset($_SESSION['message']); // Очищаем сообщение из сессии после отображения
        }
        parent::get($context);
    }

    public function post(array $context = []): void
    {
        // получаем значения полей с формы
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $period = $_POST['period'] ?? '';
        $info = $_POST['info'] ?? ''; // Вы также получаете полное описание
        $object_type_id = $_POST['object_type_id'] ?? null;
        // Инициализируем переменную для URL изображения
        $image_url = '';
    
        // Обработка загрузки изображения
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmp_name = $_FILES['image']['tmp_name'];
            $name = $_FILES['image']['name'];
            $uploadDir = "../public/media/";
            $destination = $uploadDir . $name;
    
            if (move_uploaded_file($tmp_name, $destination)) {
                // Формируем URL к загруженному изображению (относительно public)
                $image_url = "/media/" . $name;
            } else {
                $context['error'] = 'Ошибка при загрузке изображения.';
            }
        } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $context['error'] = 'Ошибка при загрузке изображения: ' . $_FILES['image']['error'];
        }
    
        // создаем текст запроса
        $sql = <<<EOL
INSERT INTO theninth_wave(title, image, description, period, object_type_id)
VALUES(:title, :image, :description, :period, :object_type_id)
EOL;
    
        // подготавливаем запрос к БД
        $query = $this->pdo->prepare($sql);
        // привязываем параметры
        $query->bindValue("title", $title);
        $query->bindValue("image", $image_url); // Привязываем URL изображения
        $query->bindValue("description", $description);
        $query->bindValue("period", $period);
        $query->bindValue("object_type_id", $object_type_id, PDO::PARAM_INT); // Явно указываем тип параметра

    
        // выполняем запрос
        if ($query->execute()) {
            $context['message'] = 'Вы успешно создали объект';
            $context['id'] = $this->pdo->lastInsertId();
        } else {
            $context['error'] = 'Ошибка при добавлении объекта в базу данных.';
            $context['db_error'] = $query->errorInfo(); // Для отладки
        }
    
        $this->get($context);
    }
}