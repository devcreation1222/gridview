<?php

$host = 'localhost';
$db = 'grid_view';
$db_user = 'root';
$db_passwd = '';
// $db = 'gridview';
// $db_user = 'gridview';
// $db_passwd = 'gridview1234';

$link = mysqli_connect($host, $db_user, $db_passwd, $db);

if (!$link) {
    echo '1';
    exit;
}

?>