<?php
//require_once "TwigBaseController.php"; 
class WaveController extends TwigBaseController {
    public $template = "object_layout.twig";
    public $title = "Девятый вал";

    public $books = []; // даже если не используешь — просто чтобы не было ошибки
    public $tabs = [];
    public $image_data = [];
    public $tab1_url = "/theninthwave/image";
    public $tab2_url = "/theninthwave/info";
    public $tab1_text = "Картинка";
    public $tab2_text = "Информация";

    public function getContext(): array {
        $context = parent::getContext();

        return $context;
    }
}
