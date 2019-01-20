<!doctype html>
<html lang="ru">
<head>

    <?php
    $gorod_poisk = trim(filter_var($_GET['gorod_poisk'],FILTER_SANITIZE_STRING));
    $website_title = 'NEPOGODA.BY | Прогноз погоды '. $gorod_poisk . '. Погода '. $gorod_poisk;

    $website_description = $gorod_poisk . ' прогноз погоды на сегодня, завтра, неделю, график погоды ' . $gorod_poisk . ', влажность воздуха, скорость ветра, давление.';

    $website_keywords = 'Погода '. $gorod_poisk;


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
                    <form class="p-2" method="get" action="spisok_prognoz.php">
                        <div class="input-group mb-3 ">
                            <input type="text" class="form-control" name="gorod_poisk" id="gorod_poisk" placeholder="Название..." aria-label="Recipient\'s username" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="gorod_poisk_id">Найти</button>
                            </div>
                        </div>
                    </form>
                   ';
               //-----выводим список городов-----------------------------
                require 'alphabet_gorod.php';

                echo '
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
                    <form class="p-2" method="get" action="spisok_prognoz.php">
                        <div class="input-group mb-3 ">
                            <input type="text" class="form-control" name="gorod_poisk" id="gorod_poisk" placeholder="Название..." aria-label="Recipient\'s username" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit" id="gorod_poisk_id">Найти</button>
                            </div>
                        </div>
                    </form>
                    ';

                //-----выводим список городов-----------------------------
                require 'alphabet_gorod.php';

                echo '   
                    </div>
                ';
                //----------КОНЕЦ --форма поиска города------------------

                //-----подключаем блок рекламы---------------------------
                require 'blocks/aside.php';

                //-----выводим список городов-----------------------------
                require 'alphabet_gorod.php';

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
                
                <form class="p-2" method="get" action="spisok_prognoz.php">
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
                     <h1 class="font-weight-light">'. $gorod_poisk .'</h1>
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
                require 'blocks/table_prognoz_big.php'; //укрупненная таблица
            }
            ?>

            <div class="mt-2">
                <h3>Правила использования информации!</h3>
                <p>На данной странице представлен прогноз погоды в населенном пункте <?php echo $gorod_poisk; ?>. </p>
                <p>Погода в населенном пункте <?php echo $gorod_poisk; ?> представлена исключительно для личного некоммерческого использования в ознакомительных целях.</p>
                <p>Данные прогноза погоды в населенном пункте <?php echo $gorod_poisk; ?> носит исключительно консультативный характер и не могут использоваться в качестве официального источника данных о погоде при планировании мероприятий, связанных с риском материального ущерба.</p>
                <p>Информацию о погоде в населенном пункте <?php echo $gorod_poisk; ?> запрещено использовать в любых коммерческих целях, в частности в любых средствах массовой информации, на телевидении, Интернете, табло, радио, бордах и прочее.</p>
                <h3>О сайте</h3>
                <p>Сайт https://nepogoda.by содержит подробную информацию о погодных условиях и прогнозы погоды для около 460 городов и населенных пунктов Беларуси. На нашем сайте данные прогнозов погоды представлены в виде удобных графиков и таблиц, которые дают полную картину метеообстановки населенных пунктов на ближайшие дни и неделю. </p>
                <p>Прогноз погоды обновляется в автоматическом режиме каждые 30 минут.</p>
                <p>Также не стоит забывать, что любой прогноз не бывает на 100 % точным.</p>
                <p>Использование материалов возможно только с согласия администрации сайта!</p>
            </div>

        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>

<script src="/js/Chart.min.js"></script>
<script src="/js/chart_for_nepogoda.js"></script>

</body>
</html>
