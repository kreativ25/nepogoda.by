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

            <form method="get" action="spisok_prognoz.php">
                <div class="input-group mb-3 ">
                    <input type="text" class="form-control" name="gorod_poisk" id="gorod_poisk" placeholder="Название..." aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit" id="gorod_poisk_id">Найти населенный пункт</button>
                    </div>
                </div>
            </form>

            <?php
            //создаем массив с алфавитом
            mb_internal_encoding("UTF-8"); //устанавливаем кодировку для php
            $alphabet = array(
                'А', 'Б', 'В', 'Г', 'Д', 'Е','Ж', 'З','И','К','Л','М','Н',
                'О','П','Р','С','Т','У','Ф','Х','Ч','Ш','Щ','Э','Ю','Я');

            //выбираем все города из БД
            require_once 'mysql_connect.php';

            $sql = 'SELECT COUNT(*) FROM gorod';
            $query = $pdo->prepare($sql);
            $query->execute();
            $gorod_count = $query->fetchColumn(); //возвращает количество городов в БД

            //выводим на сайт количество городов в БД
            echo '
                     <div class="text-left text-justify mt-5" >
                        <p class="h4">
                            <a href="/" class="text-primary">nepogoda.by</a> - это прогноз погоды в '. $gorod_count . ' населенных пунктах Беларуси! 
                        </p>
                    </div>
             ';

            //Создаем массив со списком городов
            $gorod_rus = $pdo->query('SELECT gorod_name_rus FROM gorod ORDER BY gorod_name_rus ASC')->fetchAll(PDO::FETCH_COLUMN);

            //Выводим список городов
            echo '
                <section class="banner-img py-5">
                <div class="container">
            ';

            for ($i = 0; $i < count($alphabet); $i++){
                //проверяем есть ли города подходящие для алфавита
                for ($x = 0; $x < $gorod_count; $x++){
                    if ($alphabet[$i] == mb_substr($gorod_rus[$x],0,1)){
                        echo '
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <h2 class="text-left">' . $alphabet[$i] . '</h2>
                                </div>
                            </div> 
                            <div class="row">
                            <div class="col-md-4">
                            <ul class="list-unstyled">
                            ';
                        break;
                    }
                }
                //добавляем название города в виде ссылки
                for ($a = 0; $a < $gorod_count; $a++){
                    if ($alphabet[$i] == mb_substr($gorod_rus[$a],0,1)){
                        echo '
                                <a href= "spisok_prognoz.php?gorod_poisk=' . $gorod_rus[$a] . ' "><li>' . $gorod_rus[$a] . '</li></a>
                            ';
                    }
                }
                echo '
                    </ul>
                    </div>
                    </div>
                    <br>
                 ';
            }
            echo '
            </div>
            </section>
            ';
            ?>

        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>
</body>
</html>