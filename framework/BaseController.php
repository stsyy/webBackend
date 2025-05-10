<?php

abstract class BaseController {

    public PDO $pdo; // добавил поле
    public array $params;

       // добавил сеттер
       public function setParams(array $params) {
        $this->params = $params;
    }


    public function setPDO(PDO $pdo) { // и сеттер для него
        $this->pdo = $pdo;
    }
    
    public function getContext(): array {
        return []; 
    }
    public function setTabs($tab1_url, $tab2_url, $tab1_text, $tab2_text) {
        return [
            "tab1_url" => $tab1_url,
            "tab2_url" => $tab2_url,
            "tab1_text" => $tab1_text,
            "tab2_text" => $tab2_text,
        ];
    }
 
    abstract public function get();
}