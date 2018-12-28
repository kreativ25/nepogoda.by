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
















            </div>
            <?php require 'blocks/aside.php' ?>
        </div>
    </main>
    <?php require 'blocks/footer.php' ?>
</body>
</html>