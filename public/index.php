<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"  rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
    <a class="navbar-brand" href="/"><i class="fa-solid fa-book-tanakh"></i></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Главная</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/tot">Книга Тота</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/gigas">Кодекс Гигас</a>
            </li>
        </ul>
        </div>
    </div>
</nav>
<div class="container">
<?php 
    $url = $_SERVER["REQUEST_URI"];

    #echo "Вы на странице: $url, будьте внимательны!<br>";

    if ($url == "/") {
        require __DIR__ . "/../views/main.php";
    } elseif ($url == "/tot") {
        require __DIR__ . "/../views/tot.php";
    } elseif ($url == "/gigas") {
        require __DIR__ . "/../views/gigas.php";
    }

    if ($url == "/gigas/image") {
        require __DIR__ . "/../views/gigas_image.php";
    } elseif ($url == "/gigas/info") {
        require __DIR__ . "/../views/gigas_info.php";
    }

    if ($url == "/tot/image") {
        require __DIR__ . "/../views/tot_image.php";
    } elseif ($url == "/tot/info") {
        require __DIR__ . "/../views/tot_info.php";
    }
?>
</div>
</body>
</html>