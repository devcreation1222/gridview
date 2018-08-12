<?php
header('Access-Control-Allow-Origin: *');
require 'image/vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$path = '/images';
$files = preg_grep('~\.(jpeg|jpg|png)$~', scandir(getcwd() . $path));

$i = 0;

Image::configure(array('driver' => 'imagick'));
    
while ($i < sizeof($files)) {
    $imagename = 'thumbnails/' . $files[$i+2];
    
    if(file_exists($imagename)){
        $i++;
       continue;
    } 
    
    $img = Image::make('images/' . $files[$i+2]);
    
    $img->resize(300, 375);
    $img->save('thumbnails/' . $files[$i+2]);
    $i++;
}

echo 'Successfully generated thumbnails.';
?>