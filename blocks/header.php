<?php
    echo '
    <div class="position-static ml-0">


    <nav class="navbar navbar-expand-md navbar-dark bg-dark mt-0">
        <a class="navbar-brand text-warning" href="/">nepogoda.by</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExampleDefault" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="../5_days.php?gorod_poisk=Минск">5 дней</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../5_days_plus.php?gorod_poisk=Минск">Подробный на 5 дней</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="../spisok.php">Список городов</a>
                </li>

                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать</a>
                    <div class="dropdown-menu " aria-labelledby="dropdown01">
    
    ';

    $spisok_dropdown = array("Минск", "Гомель","Лида", "Витебск", "Гродно",
                             "Брест","Пинск","Барановичи","Бобруйск",
                             "Мозырь","Борисов","Солигорск","Молодечно",
                             "Орша","Жлобин","Слуцк","Новополоцк","Полоцк",
                             "Кобрин","Волковыск");

    for ($d = 0; $d < count($spisok_dropdown); $d++){
        echo '
                 <a class="dropdown-item" href="spisok_prognoz.php?gorod_poisk='. $spisok_dropdown[$d] . '"">'. $spisok_dropdown[$d] . '</a>     
        ';
    }

    echo '
                </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="post" action="../table_hour.php">
                <input class="form-control mr-sm-2" type="text" name="gorod_poisk" id="gorod_poisk" placeholder="Название города" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="gorod_poisk_id">Поиск</button>
            </form>
        </div>
    </nav>
</div>
    ';
?>














