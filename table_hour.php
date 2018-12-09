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

<main class="container mt-5 container-main">
    <div class="row">
        <div class="col-md-8 mb-3">

            <?php require_once 'functions.php';?>
            <?php

            $gorod_poisk = trim(filter_var($_POST['gorod_poisk'],FILTER_SANITIZE_STRING));
            $error = '';

            if (strlen($gorod_poisk ) < 3) {
                $error= 'Короткое название!';
            }

            if (strlen($gorod_poisk ) > 23) {
                $error= 'Длинное название название!';
            }

            if ($error != ''){
                echo $error;
                exit();
            }

            require_once 'mysql_connect.php';

            define("API_KEY", "ab06caeacd9e4f38c2b216a394d0ff11");
            date_default_timezone_set('Europe/Minsk');   //Устанавливаем таймзону Беларуси

            $sql = 'SELECT gorod_id FROM gorod WHERE gorod_name_rus = ?';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_poisk]);
            $gorod_id = $query->fetchColumn();

            $link = 'http://api.openweathermap.org/data/2.5/forecast?id=' . $gorod_id . '&appid=' . API_KEY . '&units=metric';
            $api = file_get_contents($link);
            $nepogoda = json_decode($api, true);
            $nepogoda_count = count($nepogoda['list']); //количество элементов в массиве API для цикла

            //*********************************************************
            //для тестов

            echo $gorod_id;

            //*********************************************************

            echo "</br>";
            echo "</br>";
            echo "</br>";
            echo "</br>";
            echo "</br>";
            echo "</br>";

            //--------СОЗДАЕМ ТАБЛИЦУ С ПРОГНОЗОМ------
            require_once 'mysql_connect.php';
            $sql = 'SELECT data_prognoza, time_prognoza, temp, usloviya, skorost_vetra, vlazhnost
                    FROM prognoz
                    WHERE city_id = ? 
                    ORDER BY data_prognoza ASC, time_prognoza ASC';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_id]);
            $gorod_id = $query->fetchAll(); // возвращает массив, который состоит из всех строк

            $i = 1;

            echo $gorod_id[$i]["data_prognoza"] . "</br>";
            echo $gorod_id[$i]["time_prognoza"]. "</br>";
            echo $gorod_id[$i]["temp"] . "</br>";
            echo $gorod_id[$i]["usloviya"] . "</br>";
            echo $gorod_id[$i]["skorost_vetra"] . "</br>";
            echo $gorod_id[$i]["vlazhnost"] . "</br>";

            $gorod_id_COUNT = count($gorod_id); //определяем количество строк в массиве


            echo "</br>";
            echo "</br>";
            echo "</br>";

            //заголовок таблицы
            echo '
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">Время</th>
                    <th scope="col">Температура</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Ветер, м/с</th>
                    <th scope="col">Влажность, %</th>
                </tr>
                </thead>
                <tbody>
            ';
            //вставляем строки
            for ($i = 0; $i < $gorod_id_COUNT; $i++){
                echo '
                 <tr>
                    <td>' . $gorod_id[$i]["data_prognoza"] . '</td>
                    <td>' . $gorod_id[$i]["time_prognoza"] . '</td>
                    <td>' . $gorod_id[$i]["temp"] . '</td>
                    <td>' . "     " . '</td>
                    <td>' . $gorod_id[$i]["usloviya"] . '</td>
                    <td>' . $gorod_id[$i]["skorost_vetra"] . '</td>
                    <td>' . $gorod_id[$i]["vlazhnost"] . '</td>
                </tr>
                ';
            }
                //закрытие тега создающего таблицу
                echo '
                    </tbody>
                    </table>';

            //--------КОНЕЦ ТАБЛИЦЫ С ПРОГНОЗОМ-------
            ?>


            <?php
                echo "</br>";
                echo "</br>";
                echo "</br>";
                echo "</br>";
                echo "</br>";
                echo "</br>";
            ?>






            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">Дата</th>
                    <th scope="col">Температура</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">Ветер, м/с</th>
                    <th scope="col">Влажность, %</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>Mark</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Mark</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <td>Mark</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>

                </tbody>
            </table>





        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>
</body>
</html>