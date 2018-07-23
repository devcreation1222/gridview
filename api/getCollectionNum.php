<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

$sql = "SELECT col_num FROM collection";
$sql_result = mysqli_query($link, $sql);
$col_nums = [];
while($row = mysqli_fetch_array($sql_result)) {
    $col_nums[] = array(
        'col_num'=> $row['col_num']
    );
}

echo json_encode($col_nums);

?>