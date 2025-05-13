<?php

/class InfoController extends TwigBaseController {
    public $template = "info.twig"; // шаблон для описания
    public $books = [];       // даже если не используется
    public $tabs = [];
    public $image_data = [];
    public $tab1_url = "";
    public $tab2_url = "";
    public $tab1_text = "";
    public $tab2_text = "";

    public function getContext(): array {
        $context = parent::getContext();

        $id = $this->params[1];
        $query = $this->pdo->prepare("SELECT * FROM theninth_wave WHERE id = ?");
        $query->execute([$id]);
        $painting = $query->fetch();

        if ($painting) {
            $context["painting"] = $painting;
        }

        return $context;
    }*/
}
