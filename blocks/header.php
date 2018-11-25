<div class="position-static ml-0">

    <div class="bg-light" style="height: 140px;">
        <div class="text-lg-left ">
            <h1 class="display-4">Nepogoda.by</h1>
            <p class="lead">Прогноз погоды в каждом населенном пункте Беларуси</p>
        </div>
    </div>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark mt-0">
        <a class="navbar-brand text-warning" href="/">Nepogoda.by</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Сегодня <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">5 дней</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Подробный на 5 дней</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="#">Список городов</a>
                </li>
            </ul>

            <form class="form-inline mt-2 mt-md-0" method="post" action="/prognoz.php">

                <div class="dropdown mr-2 mb-2">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Выбрать город
                    </a>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <input type="submit" class="dropdown-item" name="Минск" value="Минск" id="Минск">
                        <input type="submit" class="dropdown-item" name="Брест" value="Брест" id="Брест">
                        <input type="submit" class="dropdown-item" name="Гомель" value="Гомель" id="Гомель">
                        <input type="submit" class="dropdown-item" name="Витебск" value="Витебск" id="Витебск">
                        <input type="submit" class="dropdown-item" name="Гродно" value="Гродно" id="Гродно">
                        <input type="submit" class="dropdown-item" name="Могилев" value="Могилев" id="Могилев">
                        <input type="submit" class="dropdown-item" name="Барановичи" value="Барановичи" id="Барановичи">
                        <input type="submit" class="dropdown-item" name="Пинск" value="Пинск" id="Пинск">
                        <input type="submit" class="dropdown-item" name="Лида" value="Лида" id="Лида">
                        <input type="submit" class="dropdown-item" name="Пружаны" value="Пружаны" id="Пружаны">
                    </div>
                </div>

                <input class="form-control mr-sm-2" type="text" placeholder="Название города" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
            </form>



            <?php
                //тут определяем переменную для получения данных о выбранном городе
            ?>



        </div>
    </nav>




</div>




