<?php
$gorod_poisk = trim(filter_var($_POST['gorod'],FILTER_SANITIZE_STRING));



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

/*
if ($gorod_poisk == 'Минск'){
    echo 'ГОТОВО';
}
*/

require_once '../mysql_connect.php';

//этот код пока не работает
$sql = 'SELECT gorod_id FROM gorod WHERE gorod_name_rus = ?';
$query = $pdo->prepare($sql);
$query->execute([$gorod_poisk]);
$gorod_id = $query->fetchColumn();

echo $gorod_id;

?>
