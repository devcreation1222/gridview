<?php

$host = 'localhost';
$port = '8889';
$db = 'grid_view';
$db_user = 'root';
$db_passwd = 'root';
// $db = 'gridview';
// $db_user = 'gridview';
// $db_passwd = 'gridview1234';
$admin_email = 'lesok3333@gmail.com';
// $admin_email = 'maxexactly@gmail.com'

$link = mysqli_connect($host, $db_user, $db_passwd, $db, $port);

if (!$link) {
    echo '1';
    exit;
}

?>