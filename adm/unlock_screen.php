<?php
header('Access-Control-Allow-Origin: *');

$password = $_GET['password'];

if ($password == "hughrocks") {
    echo "success";
}
?>