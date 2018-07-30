<?php
header('Access-Control-Allow-Origin: *');
include 'thumbnailGenerator.php';

set_time_limit(0);
$tg = new thumbnailGenerator;

$path = '/images';
$files = scandir(getcwd() . $path);

$i = 2;
while ($i < sizeof($files)) {
    $imagename = 'thumbnails/' . $files[$i];
    if(file_exists($imagename)){
       continue;
    } 
    $tg->generate('images/' . $files[$i], 200, 250, 'thumbnails/' . $files[$i] );
    $i++;
}

echo 'Successfully generated thumbnails.';
?>