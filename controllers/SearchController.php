<?php
require_once "BaseSpaceTwigController.php";

class SearchController extends BaseSpaceTwigController
{
    public $template = "search.twig";

    public function getContext(): array
    {
        $context = parent::getContext();

        $period = isset($_GET['period']) ? $_GET['period'] : '';
        $title = isset($_GET['title']) ? $_GET['title'] : '';
        $description = isset($_GET['description']) ? $_GET['description'] : '';

        $sql = <<<EOL
SELECT id, title
FROM theninth_wave
WHERE (:title = '' OR title LIKE CONCAT('%', :title, '%'))
AND (:period = '' OR period = :period)
AND (:description = '' OR description LIKE CONCAT('%', :description, '%'))
EOL;
        $query = $this->pdo->prepare($sql);
        $query->bindValue(":title", $title);
        $query->bindValue(":period", $period);
        $query->bindValue(":description", $description);
        $query->execute();
        $searchResults = $query->fetchAll();

        $context['searchResults'] = $searchResults;
        $context['selectedPeriod'] = $period;
        $context['searchedTitle'] = $title;
        $context['searchedDescription'] = $description;

        return $context;
    }
}