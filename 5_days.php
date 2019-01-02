<!doctype html>
<html lang="ru">
<head>

    <?php
    $website_title = 'NEPOGODA.BY';
    require 'blocks/head.php';
    ?>

</head>
<body>
<?php require 'blocks/header.php'; ?>

<main class="container mt-3 container-main">
    <div class="row">
        <div class="col-md-9 mb-3">

            <?php
            $gorod_poisk = trim(filter_var($_GET['gorod_poisk'],FILTER_SANITIZE_STRING));
            $error = '';

            if (strlen($gorod_poisk ) < 3) {
                $error= 'Короткое название!';
            }

            if (strlen($gorod_poisk ) > 50) {
                $error= 'Длинное название!';
            }

            if ($error != ''){
                echo $error;
                exit();
            }

            //----------НАЧАЛО --форма поиска города------------------
            echo '
            
            <form class="p-2" method="get" action="5_days.php">
                <div class="input-group mb-3 ">
                    <input type="text" class="form-control" name="gorod_poisk" id="gorod_poisk" placeholder="Название..." aria-label="Recipient\'s username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="gorod_poisk_id">Найти</button>
                    </div>
                </div>
            </form>
            ';
            //----------КОНЕЦ --форма поиска города------------------




            echo '
             <div class="">
             
                 <h4>Прогноз погоды:  '. $gorod_poisk .'</h4>
                    
        
            </div>
            ';
            ?>

            <canvas id="myChart" width="400" height="200"></canvas>

            <?php
            require_once 'mysql_connect.php';

            define("API_KEY", "ab06caeacd9e4f38c2b216a394d0ff11");
            date_default_timezone_set('Europe/Minsk');   //Устанавливаем таймзону Беларуси

            $sql = 'SELECT gorod_id FROM gorod WHERE gorod_name_rus = ?';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_poisk]);
            $gorod_id = $query->fetchColumn();

            //непонятно для чего этот блок тут - возможно на удаление - НА ПРОВЕРКУ!
            $link = 'http://api.openweathermap.org/data/2.5/forecast?id=' . $gorod_id . '&appid=' . API_KEY . '&units=metric';
            $api = file_get_contents($link);
            $nepogoda = json_decode($api, true);
            $nepogoda_count = count($nepogoda['list']); //количество элементов в массиве API для цикла


            //----------------------------------ПОДКЛЮЧАЕМ ГРАФИК---------------------------------------
            require 'blocks/Chart_hour.php';

            //----------------------------------ПОДКЛЮЧАЕМ ТАБЛИЦУ--------------------------------------
            //require 'blocks/table_prognoz.php'; //почасовая таблица
            require 'blocks/table_prognoz_big.php'; //укрупненная таблица

            ?>

        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>

<script src="/js/Chart.min.js"></script>
<script src="/js/chart_for_nepogoda.js"></script>

</body>
</html>
