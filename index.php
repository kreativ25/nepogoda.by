<!doctype html>
<html lang="ru">
<head>

    <?php
    $website_title = 'NEPOGODA.BY';
    require 'blocks/head.php';
    ?>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require 'blocks/header.php'; ?>

    <main class="container mt-3 container-main">
        <div class="row">
            <div class="col-md-9 mb-3">

                <div class="jumbotron bg-transparent text-center" style="background: #f5c6cb">
                    <h1 class="display-4 text-center">nepogoda.by</h1>
                    <p class="lead text-center">Прогноз погоды в 458 населенных пунктах Беларуси! Самый большой охват территории страны!</p>

                    <a class="btn btn-primary btn-dark" href="spisok.php" role="button">Найти свой город...</a>
                </div>

                <?php
                //выбираем из базы прогноз на 6 областных городов
                require_once 'mysql_connect.php';
                $minsk = 625143;
                $brest = 629634;
                $gomel = 627907;
                $vitebsk = 620127;
                $mogilev = 625665;
                $grodno = 627904;

                //----------МИНСК---------------

                $sql = 'SELECT city_id, data_prognoza, time_prognoza, temp, usloviya, skorost_vetra   
                        FROM prognoz
                        WHERE city_id = ? 
                        ORDER BY data_prognoza ASC, time_prognoza ASC 
                        LIMIT 1';
                $query = $pdo->prepare($sql);
                $query->execute([$minsk]);
                $gorod_id = $query->fetchAll(); // возвращает массив, который состоит из всех строк

                $gorod_id_COUNT = count($gorod_id); //определяем количество строк в массиве

                //блок правильного присвоения картинок и значений температуры
                require 'mysql_cards.php';


                echo '
                <div class="card mb-4 shadow">
                        <div class="card-header bg-transparent">
                            <h4 class="my-0 font-weight-normal"> <a href="spisok_prognoz.php?gorod_poisk=Минск" class="text-decoration-none">Минск</a></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"> '. $temp_card .' <small class="text-muted">/ <img src=' . $linck . ' alt="Условия погоды"></small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>'. $gorod_id[0][4] .'</li>
                                <li>Ветер '. $gorod_id[0][5] .' м/с</li>
                            </ul>
                        </div>
                    </div>
                ';
                //---------Конец МИНСК--------------







                ?>

                <div class="card-deck text-center ">
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-transparent">
                            <h4 class="my-0 font-weight-normal"> <a href="spisok_prognoz.php?gorod_poisk=Минск" class="text-decoration-none">Минск</a></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"> +5 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Небольшой снег</li>
                                <li>Ветер 5 м/с</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-transparent">
                            <h4 class="my-0 font-weight-normal"><a href="spisok_prognoz.php?gorod_poisk=Брест" class="text-decoration-none">Брест</a></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"> +5 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Небольшой снег</li>
                                <li>Ветер 5 м/с</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-transparent">
                            <h4 class="my-0 font-weight-normal"><a href="spisok_prognoz.php?gorod_poisk=Гомель" class="text-decoration-none">Гомель</a></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"> +5 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Небольшой снег</li>
                                <li>Ветер 5 м/с</li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="card-deck  text-center">
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-transparent">
                            <h4 class="my-0 font-weight-normal"><a href="spisok_prognoz.php?gorod_poisk=Витебск" class="text-decoration-none">Витебск</a></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"> +5 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Небольшой снег</li>
                                <li>Ветер 5 м/с</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-transparent">
                            <h4 class="my-0 font-weight-normal"><a href="spisok_prognoz.php?gorod_poisk=Могилев" class="text-decoration-none">Могилев</a></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"> +5 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Небольшой снег</li>
                                <li>Ветер 5 м/с</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-transparent">
                            <h4 class="my-0 font-weight-normal"><a href="spisok_prognoz.php?gorod_poisk=Гродно" class="text-decoration-none">Гродно</a></h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"> +5 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Небольшой снег</li>
                                <li>Ветер 5 м/с</li>
                            </ul>
                        </div>
                    </div>
                </div>


            </div>
            <?php require 'blocks/aside.php' ?>
        </div>
    </main>
    <?php require 'blocks/footer.php' ?>
</body>
</html>