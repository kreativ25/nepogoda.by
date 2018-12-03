<?php
$gorod_poisk = trim(filter_var($_POST['gorod'],FILTER_SANITIZE_STRING));

if ($gorod_poisk == 'Минск'){
    echo 'ГОТОВО';
}


?>
