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

            <?php
            //global $gorod; //глобальная переменная для определения города из списка городов

            require_once 'functions.php';


            echo 'Привет ' . '!';



            ?>

        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>
</body>
</html>