<?php

class BaseSpaceTwigController extends TwigBaseController
{
    public function getContext(): array
    {
        $context = parent::getContext();

        // Получаем список периодов
        $queryPeriods = $this->pdo->query("SELECT DISTINCT period FROM theninth_wave ORDER BY 1");
        $periods = $queryPeriods->fetchAll();
        $context['periods'] = $periods;

        // Получаем список типов объектов
        $queryObjectTypes = $this->pdo->query("SELECT id, name FROM object_types ORDER BY name");
        $objectTypes = $queryObjectTypes->fetchAll();
        $context['object_types'] = $objectTypes;

        return $context;
    }
}