<?php
require_once "BaseSpaceTwigController.php";

class ObjectController extends BaseSpaceTwigController {
    public $template = "__object.twig"; // базовый шаблон

    public function getContext(): array {
        $context = parent::getContext();

        $id = $this->params[1]; // вытаскиваем id из URL

        // Загружаем данные из БД
        $query = $this->pdo->prepare("SELECT * FROM theninth_wave WHERE id = :id");
        $query->execute(["id" => $id]);
        $painting = $query->fetch();

        if ($painting) {
            $context['painting'] = $painting;
        } else {
            $context['painting'] = [
                'title' => 'Картина не найдена',
                'image' => '',
                'description' => ''
            ];
        }

        // Смотрим, какой режим отображения выбран
        $show = $_GET['show'] ?? 'default';

        switch ($show) {
            case 'image':
                $this->template = "image.twig";
                break;
            case 'info':
                $this->template = "info.twig";
                break;
            default:
                $this->template = "__object.twig"; // шаблон по умолчанию
                break;
        }

        return $context;
    }
}
