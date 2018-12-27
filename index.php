<!doctype html>
<html lang="ru">
<head>

    <?php
    $website_title = 'NEPOGODA.BY';
    require 'blocks/head.php';
    ?>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <?php require 'blocks/header.php'; ?>

    <main class="container mt-3 container-main">
        <div class="row">
            <div class="col-md-9 mb-3">


                <div class="pricing-header px-3 py-3 pt-md-3 pb-md-4 mx-auto text-center">
                    <h1 class="display-4">nepogoda.by</h1>
                    <p class="lead">Прогноз погоды в 458 населенных пунктах Беларуси! Самый большой охват территории страны! </p>
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

                $sql = 'SELECT city_id, data_prognoza, time_prognoza, temp, usloviya, skorost_vetra, vlazhnost  
                        FROM prognoz
                        WHERE city_id = ? or city_id = ? or city_id = ? or city_id = ? or city_id = ? or city_id = ?
                        ORDER BY data_prognoza ASC, time_prognoza ASC';
                $query = $pdo->prepare($sql);
                $query->execute([$minsk, $brest, $gomel, $vitebsk, $mogilev, $grodno]);
                $gorod_id = $query->fetchAll(); // возвращает массив, который состоит из всех строк

                $gorod_id_COUNT = count($gorod_id); //определяем количество строк в массиве

                //print_r($gorod_id[0][6])








                ?>















                <div class="card-deck mb-3 text-center">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Минск</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title"> +5 <small class="text-muted">/</small>  <img src="img/48х48/Обл_с_проясн_48_х_48_день.png">  </h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>Небольшой дождь</li>
                                <li>Ветер 3 м/с </li>
                                <li>Влажность 90 % </li>
                            </ul>
                            <button type="button" class="btn btn-lg btn-block btn-outline-secondary">Подробнее...</button>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Брест</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>20 users included</li>
                                <li>10 GB of storage</li>
                                <li>Help center access</li>
                            </ul>
                            <button type="button" class="btn btn-lg btn-block btn-outline-secondary">Подробнее...</button>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Гродно</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$29 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>30 users included</li>
                                <li>15 GB of storage</li>
                                <li>Help center access</li>
                            </ul>
                            <button type="button" class="btn btn-lg btn-block btn-outline-secondary">Подробнее...</button>
                        </div>
                    </div>
                </div>









                <div class="card-deck mb-3 text-center">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Витебск</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>10 users included</li>
                                <li>2 GB of storage</li>
                                <li>Email support</li>
                            </ul>
                            <button type="button" class="btn btn-lg btn-block btn-outline-secondary">Подробнее...</button>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Гомель</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$15 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>20 users included</li>
                                <li>10 GB of storage</li>
                                <li>Priority email support</li>
                            </ul>
                            <button type="button" class="btn btn-lg btn-block btn-outline-secondary">Подробнее...</button>
                        </div>
                    </div>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">Могилев</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$29 <small class="text-muted">/ mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>30 users included</li>
                                <li>15 GB of storage</li>
                                <li>Phone and email support</li>
                            </ul>
                            <button type="button" class="btn btn-lg btn-block btn-outline-secondary">Подробнее...</button>
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