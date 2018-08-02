<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

$sql = "SELECT col_num FROM collection ORDER BY id";
$sql_result = mysqli_query($link, $sql);
$col_nums = [];
if ($sql_result) {
    while($row = mysqli_fetch_array($sql_result)) {
        $col_nums[] = array(
            'col_num'=> $row['col_num']
        );
    }
}

echo json_encode($col_nums);

mysqli_close($link);
?>