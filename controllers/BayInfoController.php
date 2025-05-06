<?php
class BayInfoController extends BayController {
    public $template = "thebayofnaples_info.twig";
    public $title = "Неаполитанский залив";
    public $tab1_url = "/thebayofnaples/image";
    public $tab2_url = "/thebayofnaples/info";
    public $tab1_text = "Картинка";
    public $tab2_text = "Информация";
       public $image_src = "/images/thebayofnaples.jpg";
       public $image_alt = "Неаполитанский залив";
       public $image_width = 600;
       public $image_height = 700;
    public function getContext(): array {
        $context = parent::getContext();

        return $context;
    }
}
