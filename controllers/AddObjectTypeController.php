<?php
require_once "BaseSpaceTwigController.php";

class AddObjectTypeController extends BaseSpaceTwigController {
    public $template = "add_object_type.twig";
    public $title = "Добавить объект";
    public function post(array $context = []): void {
        $name = $_POST['name'] ?? '';
        $image_url = '';
        
        // Обработка файла
        if (isset($_FILES['image'])) {
            $allowed_types = ['image/jpeg', 'image/png'];
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                if (!in_array($_FILES['image']['type'], $allowed_types)) {
                    $_SESSION['error'] = 'Только JPG/PNG файлы!';
                    header("Location: /add_object_type");
                    exit;
                }
                
                $uploadDir = "../public/media/object_types/";
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                $destination = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    $image_url = "/media/object_types/" . $filename;
                }
            }
        }

        // Валидация названия
        if (empty($name)) {
            $_SESSION['error'] = 'Название обязательно!';
            header("Location: /add_object_type");
            exit;
        }

        // SQL-запрос
        try {
            $sql = "INSERT INTO object_types (name, image) VALUES (:name, :image)";
            $query = $this->pdo->prepare($sql);
            $query->execute([
                'name' => $name,
                'image' => $image_url
            ]);
            
            $_SESSION['message'] = 'Тип успешно добавлен!';
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Ошибка: ' . $e->getMessage();
        }
        
        header("Location: /add_object_type");
        exit;
    }
}