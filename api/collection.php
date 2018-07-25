<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

$col_num = $_GET['col_num'];
$sql = "SELECT * FROM collection WHERE col_num=".$col_num;
$sql_result = mysqli_query($link, $sql);
$col_data = [];
$image_paths = [];
if ($sql_result) {
    while($row = mysqli_fetch_array($sql_result)) {
        $img_list = explode(',', $row['col_image']);
        
        foreach($img_list as $img) {
            if ($img) {
                $image_paths[] = array(
                    'custom' => $img,
                    'thumbnail' => $img
                );
            }
        }
        if ($image_paths) {
            $col_data[] = array(
                'imagePaths'=> $image_paths,
                'description'=> urldecode($row['col_description'])
            );
        }
    }
}

echo json_encode($col_data);

mysqli_close($link);
?>