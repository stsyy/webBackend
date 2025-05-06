<?php
require_once __DIR__ . '/WaveController.php';
class WaveInfoController extends WaveController {
    public $template = "theninthwave_info.twig";
    public $title = "Девятый вал";
    public $tab1_url = "/theninthwave/image";
    public $tab2_url = "/theninthwave/info";
    public $tab1_text = "Картинка";
    public $tab2_text = "Информация";
       public $image_src = "/images/ninthval.jpg";
       public $image_alt = "Девятый вал";
       public $image_width = 600;
       public $image_height = 700;
    public function getContext(): array {
        $context = parent::getContext();

        return $context;
    }
}