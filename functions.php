<?php

    //Функция распечатки массива - для визуализации
    function print_arr($arr){
        echo '<pre>' . print_r($arr, true) . '</pre>';
    }

?>

<?php
//Выводим список городов
echo '
<section class="banner-img py-5">
    <div class="container">
        ';

        for ($i = 0; $i < count($alphabet); $i++){

        for ($x = 0; $x < $gorod_count; $x++){
        if ($alphabet[i] = mb_substr($gorod_rus[$x],0,1)){
        //выводим заглавную букву - если она имеется
        echo '
        <div class="row text-center">
            <div class="col-md-12">
                <h2 class="text-left">' . $alphabet[i] . '</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                ';
                break;
                }
                }


                for ($x = 0; $x < $gorod_count; $x++){
                if ($alphabet[i] == mb_substr($gorod_rus[$x],0,1)){
                echo '
                <ul class="list-unstyled">
                    <a href= "spisok_prognoz.php?gorod_poisk=' . $gorod_rus[$x] . ' "><li>' . $gorod_rus[$x] . '</li></a>
                </ul>
                ';
                }
                }
                echo '
            </div>
        </div>

        ';
        }
        echo '
    </div>
</section>
';

?>

