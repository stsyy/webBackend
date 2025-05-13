<?php

class BaseSpaceTwigController extends TwigBaseController{
    public function getContext(): array
    {
        $context = parent::getContext();

        $query = $this->pdo->query("SELECT DISTINCT period FROM theninth_wave ORDER BY 1");
        $periods = $query->fetchAll();
        $context['periods']=$periods;
        return $context;
    }
}