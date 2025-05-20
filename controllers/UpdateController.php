<?php

class UpdateController extends BaseController
{
    public $templateList = "edit_list.twig";
    public $templateEditForm = "edit_form.twig";

  public function get(array $context = []): void {
    $id = $this->params['id'] ?? null; // Используйте параметр из роутера

    if (!$id) {
        // Показываем список объектов
        $sql = "SELECT id, title FROM theninth_wave";
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $context['objects'] = $query->fetchAll(\PDO::FETCH_ASSOC);
        $this->render($this->templateList, $context);
    } else {
        // Показываем форму редактирования
        $sql = "SELECT * FROM theninth_wave WHERE id = :id";
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":id", $id, \PDO::PARAM_INT);
        $query->execute();
        $context['object'] = $query->fetch(\PDO::FETCH_ASSOC);

        $sqlTypes = "SELECT id, name FROM object_types";
        $queryTypes = $this->pdo->prepare($sqlTypes);
        $queryTypes->execute();
        $context['object_types'] = $queryTypes->fetchAll(\PDO::FETCH_ASSOC);

        $this->render($this->templateEditForm, $context);
    }
}

    public function post(array $context = []): void
    {
        $id = $this->params['id'] ?? null;

        if ($id) {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $period = $_POST['period'] ?? '';
            $info = $_POST['info'] ?? '';
            $object_type_id = $_POST['object_type_id'] ?? null;
            $current_image = $_POST['current_image'] ?? '';
            $image_url = $current_image;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // ... (код обработки загрузки изображения) ...
            } elseif (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                // ... (код обработки ошибки загрузки изображения) ...
            }

            $sql = "UPDATE theninth_wave SET title = :title, image = :image, description = :description, period = :period, /*info = :info,*/ object_type_id = :object_type_id WHERE id = :id";
            $query = $this->pdo->prepare($sql);
            $query->bindValue(":title", $title);
            $query->bindValue(":image", $image_url);
            $query->bindValue(":description", $description);
            $query->bindValue(":period", $period);
           // $query->bindValue(":info", $info);
            $query->bindValue(":object_type_id", $object_type_id, \PDO::PARAM_INT);
            $query->bindValue(":id", $id, \PDO::PARAM_INT);

            if ($query->execute()) {
                $context['message'] = 'Объект успешно обновлен.';
            } else {
                $context['error'] = 'Ошибка при обновлении объекта.';
                $context['db_error'] = $query->errorInfo();
            }

            // После обновления снова показываем форму с сообщением
            $this->get($context);
        } else {
            header("Location: /edit");
            exit;
        }
    }

    protected function render(string $template, array $context = []): void
    {
        echo $this->twig->render($template, $context);
    }
}