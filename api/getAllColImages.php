<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

$sql = "SELECT * FROM collection";
$sql_result = mysqli_query($link, $sql);
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
    }
}

echo json_encode($image_paths);

mysqli_close($link);
?>