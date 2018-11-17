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

    <main class="container mt-5">
        <div class="row">
            <div class="col-md-8 mb-3">


                <?php
                require_once 'functions.php';

                $link = 'http://api.openweathermap.org/data/2.5/weather?id=625144&appid=ab06caeacd9e4f38c2b216a394d0ff11&units=metric';
                $api = file_get_contents($link);
                $nepogoda = json_decode($api, true);
                //var_dump($nepogoda);
                print_arr($nepogoda);

                ?>

            </div>
            <?php require 'blocks/aside.php' ?>
        </div>
    </main>

    <?php require 'blocks/footer.php' ?>
</body>
</html>