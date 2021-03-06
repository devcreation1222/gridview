<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

function getimg($url) {       
    $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';              
    $headers[] = 'Connection: Keep-Alive';         
    $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';         
    $user_agent = 'php';         
    $process = curl_init($url);         
    curl_setopt($process, CURLOPT_HTTPHEADER, $headers);         
    curl_setopt($process, CURLOPT_HEADER, 0);         
    curl_setopt($process, CURLOPT_USERAGENT, $user_agent); //check here         
    curl_setopt($process, CURLOPT_TIMEOUT, 30);         
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);         
    curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);         
    $return = curl_exec($process);         
    curl_close($process);         
    return $return;     
} 

$p_sql = "select * from product";
$p_result = mysqli_query($link, $p_sql);
$products = [];
while($row = mysqli_fetch_array($p_result)) {
    $products[] = $row;
}

for ($i = 0; $i < sizeof($products); $i++) {
    $img_list = explode(',', $products[$i]['image']);
    $main_img = trim($img_list[0]);
    $img_extension = pathinfo($main_img, PATHINFO_EXTENSION);
    $imagename = 'images/' . $products[$i]['id'] . '.' . $img_extension;
    if(file_exists($imagename)){
       continue;
    } 
    $image = getimg($main_img);
    file_put_contents($imagename, $image); 
}

echo 'Successfully downloaded images.';
mysqli_close($link);
?>