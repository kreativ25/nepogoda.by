<div class="position-static ml-0">


    <nav class="navbar navbar-expand-md navbar-dark bg-dark mt-0">
        <a class="navbar-brand text-warning" href="/">nepogoda.by</a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarsExampleDefault" style="">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">5 дней</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Подробный на 5 дней</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="../spisok.php">Список городов</a>
                </li>

                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Выбрать</a>
                    <div class="dropdown-menu " aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">Минск</a>
                        <a class="dropdown-item" href="#">Брест</a>
                        <a class="dropdown-item" href="#">Гомель</a>

                        <a class="dropdown-item" href="#">Витебск</a>
                        <a class="dropdown-item" href="#">Гродно</a>
                        <a class="dropdown-item" href="#">Могилев</a>

                        <a class="dropdown-item" href="#">Барановичи</a>
                        <a class="dropdown-item" href="#">Пинск</a>
                        <a class="dropdown-item" href="#">Пружаны</a>

                        <a class="dropdown-item" href="#">Лида</a>
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





