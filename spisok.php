<!doctype html>
<html lang="ru">
<head>

    <?php
    $website_title = 'NEPOGODA.BY | Список городов - прогноз погоды, график прогноза погоды';

    $website_description = 'Список городов. Подробный прогноз погоды на сегодня, завтра, неделю, выходные, график погоды, влажность воздуха, скорость ветра, давление';

    $website_keywords = 'Список городов с прогнозом погоды';

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
                        <button class="btn btn-outline-secondary" type="submit" id="gorod_poisk_id">Найти</button>
                    </div>
                </div>
            </form>

            <?php
            echo '
                 <div class="mb-0">
                     <h1 class="font-weight-light">Список городов:</h1>
                </div>
                ';

            //вывводим список городов
            require 'alphabet_gorod.php';
            ?>

        </div>
        <?php require 'blocks/aside.php'; ?>
    </div>
</main>

<?php require 'blocks/footer.php'; ?>
</body>
</html>
