<!doctype html>
<html lang="ru">
<head>

    <?php
    $website_title = 'NEPOGODA.BY | Погода в Минске, Бресте, Гомеле, Могилеве, Витебске, Гродно';

    $website_description = 'Подробный прогноз погоды на сегодня, завтра, неделю, выходные, график погоды, влажность воздуха, скорость ветра, давление. Почасовой прогноз погоды.';

    $website_keywords = 'NEPOGODA.BY';


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

                //доп города
                $Baranovichi = 630428;
                $Lida = 626081;

                //-----------НАЧАЛО --- Прогноз 6 облостынх городов на Главной ------------------------

                //начало блока
                echo '
                <div class="card-deck text-center ">
                ';

                $gorod_connect = array($minsk,$brest,$gomel,$vitebsk, $mogilev, $grodno, $Baranovichi, $Lida);

                //вводим счетчик для проверки городов - в случае отсутствия в БД
                $calc = '';

                for ($h = 0; $h < count($gorod_connect); $h ++){

                    $gorod_for = "";
                    switch ($gorod_connect[$h]){
                        case 625143:
                            $gorod_for = "Минск";
                            break;
                        case 629634:
                            $gorod_for = "Брест";
                            break;
                        case 627907:
                            $gorod_for = "Гомель";
                            break;
                        case 620127:
                            $gorod_for = "Витебск";
                            break;
                        case 625665:
                            $gorod_for = "Могилев";
                            break;
                        case 627904:
                            $gorod_for = "Гродно";
                            break;

                        //доп города
                        case 630428:
                            $gorod_for = "Барановичи";
                            break;
                        case 626081:
                            $gorod_for = "Лида";
                            break;
                    }

                    $gorod_sql = $gorod_connect[$h];

                 //подключаемся к базе
                    $sql = 'SELECT city_id, data_prognoza, time_prognoza, temp, usloviya, skorost_vetra   
                        FROM prognoz
                        WHERE city_id = ? 
                        ORDER BY data_prognoza ASC, time_prognoza ASC 
                        LIMIT 1';
                    $query = $pdo->prepare($sql);
                    $query->execute([$gorod_sql]);
                    $gorod_id = $query->fetchAll(); // возвращает массив, который состоит из всех строк

                    //------НАЧАЛО---делаем проверку----------
                    if ( count($gorod_id) == 0){
                        continue;
                    };

                    if ($calc > 5){
                        break;
                    }
                    //------КОНЕЦ---делаем проверку----------

                    $gorod_id_COUNT = count($gorod_id); //определяем количество строк в массиве

                    //блок правильного присвоения картинок и значений температуры
                    require 'mysql_cards.php';

                    echo '
                <div class="card mb-4 shadow">
                        <div class="card-header bg-transparent">
                            <h4 class="my-0 font-weight-normal"> <a href="spisok_prognoz.php?gorod_poisk='. $gorod_for . '" class="text-decoration-none">'. $gorod_for . '</a></h4>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title pricing-card-title"> '. $temp_card .' <small class="text-muted">/ <img src=' . $linck . ' alt="Условия погоды"></small></h2>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>'. $gorod_id[0][4] .'</li>
                                <li>Ветер '. $gorod_id[0][5] .' м/с</li>
                            </ul>
                        </div>
                    </div>
                ';
                  //разделяем на 3 блока городов
                    if ($calc == 2){
                        echo '
                        </div>
                        <div class="card-deck  text-center">
                        ';
                    }
                    $calc = (int)$calc + 1;
                }
                //закрываем блок
                echo '
                </div>
                ';
                //-----------КОНЕЦ --- Прогноз 6 облостынх городов на Главной ------------------------
                ?>

            </div>
            <?php require 'blocks/aside.php' ?>
        </div>
    </main>
    <?php require 'blocks/footer.php' ?>
</body>
</html>