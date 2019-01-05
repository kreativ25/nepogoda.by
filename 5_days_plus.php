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
                echo '
                    <div class="alert alert-danger text-center" role="alert">
                      <h4 class="alert-heading mt-3 mb-3">Вы ввели слишком короткое название!</h4>
                      <p>К сожалению такого города не существует.</p>
                      <p>Пожалуйста, попробуйте еще раз :)</p>
    
                    </div>
                    ';

                //----------НАЧАЛО --форма поиска города------------------
                echo '
                    <form class="p-2" method="get" action="5_days_plus.php">
                        <div class="input-group mb-3 ">
                            <input type="text" class="form-control" name="gorod_poisk" id="gorod_poisk" placeholder="Название..." aria-label="Recipient\'s username" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="gorod_poisk_id">Найти</button>
                            </div>
                        </div>
                    </form>
                    </div>
                ';
                //----------КОНЕЦ --форма поиска города------------------

                //-----подключаем блок рекламы---------------------------
                require 'blocks/aside.php';

                echo '
                 </div>
                 </main>
                ';
                //-----подключаем футер-----------------------------------
                require 'blocks/footer.php';

                //----прекращаем выполнять php код
                exit();

                //------------если название города слишком длинное---------
            } elseif (strlen($gorod_poisk ) > 50){
                echo '
                    <div class="alert alert-danger text-center" role="alert">
                      <h4 class="alert-heading mt-3 mb-3">Вы ввели слишком длинное название!</h4>
                      <p>К сожалению такого города не существует.</p>
                      <p>Пожалуйста, попробуйте еще раз :)</p>
                    </div>
                    ';

                //----------НАЧАЛО --форма поиска города------------------
                echo '
                    <form class="p-2" method="get" action="5_days_plus.php">
                        <div class="input-group mb-3 ">
                            <input type="text" class="form-control" name="gorod_poisk" id="gorod_poisk" placeholder="Название..." aria-label="Recipient\'s username" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="gorod_poisk_id">Найти</button>
                            </div>
                        </div>
                    </form>
                    </div>
                ';
                //----------КОНЕЦ --форма поиска города------------------

                //-----подключаем блок рекламы---------------------------
                require 'blocks/aside.php';

                echo '
                 </div>
                 </main>
                ';
                //-----подключаем футер-----------------------------------
                require 'blocks/footer.php';
                //----прекращаем выполнять php код
                exit();
            };

            //----------НАЧАЛО --форма поиска города------------------
            echo '
                
                <form class="p-2" method="get" action="5_days_plus.php">
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
                 <div class="mb-4">
                     <h4>Прогноз погоды:  '. $gorod_poisk .'</h4>
                </div>
                ';
            ?>

            <?php
            require_once 'mysql_connect.php';

            define("API_KEY", "ab06caeacd9e4f38c2b216a394d0ff11");
            date_default_timezone_set('Europe/Minsk');   //Устанавливаем таймзону Беларуси

            $sql = 'SELECT gorod_id FROM gorod WHERE gorod_name_rus = ?';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_poisk]);
            $gorod_id = $query->fetchColumn();

            if ($gorod_id == ""){
                echo '
                    <div class="alert alert-success text-center" role="alert">
                      <h4 class="alert-heading mt-3 mb-3">Неправильное название!</h4>
                      <p>Ничего страшного.</p>
                      <p>Успокойтесь.</p>
                      <p>Это же не проблема.</p>
                      <p>Вы не останетесь без прогноза погоды.</p>
                      <p>Пожалуйста, попробуйте еще раз :)</p>
                    </div>
                    ';
            } else{

                echo '<canvas id="myChart" width="400" height="200"></canvas>';

                //----------------------------------ПОДКЛЮЧАЕМ ГРАФИК---------------------------------------
                require 'blocks/Chart_hour.php';

                //----------------------------------ПОДКЛЮЧАЕМ ТАБЛИЦУ--------------------------------------
                //require 'blocks/table_prognoz.php'; //почасовая таблица
                require 'blocks/table_prognoz.php'; //укрупненная таблица
            }
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
