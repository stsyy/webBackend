<?php
class  WaveImageController extends WaveController {
    public $template = "image.twig";
    public $title = "Девятый вал";

    // public $books = []; // даже если не используешь — просто чтобы не было ошибки
    // public $tabs = [];
    // public $image_data = [];
    // public $tab1_url = "/gigas/image";
    // public $tab2_url = "/gigas/info";
    // public $tab1_text = "Картинка";
    // public $tab2_text = "Информация";
       public $image_src = "/images/ninthval.jpg";
       public $image_alt = "Девятый вал";
       public $image_width = 600;
       public $image_height = 700;
    public function getContext(): array {
        $context = parent::getContext();
        $context["image_alt"] = $this->image_alt;
        $context["image_src"] = $this->image_src;
        $context["image_width"] = $this->image_width;
        $context["image_height"] = $this->image_height;

        return $context;
    }
}