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