<h1>Кодекс Гигаса</h1>


<?php
    $is_image = $url == "/gigas/image"; 
?>

<ul class="nav nav-pills">
  <li class="nav-item">
    <a class="nav-link <?php if ($is_image) { echo "active"; } ?>" href="/gigas/image">
        Картинка
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link <?php if ($is_image==false) { echo "active"; } ?>" href="/gigas/info">
        Описание
    </a>
  </li>
</ul>

<ul class="list-group" style="margin-top: 20px; ">
  <li class="list-group-item"><img src="/images/gigas2.jpg" alt="Кодекс Гигаса" width="600" height="700" ></li>
</ul>
