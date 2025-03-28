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
    <a class="navbar-brand" href="#"><i class="fa-solid fa-book-tanakh"></i></a>
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
<?php if ($_SERVER["REQUEST_URI"] == "/") { ?>
            Вы на главной странице! =)
        <?php } elseif ($_SERVER["REQUEST_URI"] == "/tot") { ?>
            Загадочная, страшная книжка
        <?php } elseif ($_SERVER["REQUEST_URI"] == "/gigas") { ?>
            Ну у ребят даже кодекс есть
        <?php } ?>
</div>
</body>
</html>