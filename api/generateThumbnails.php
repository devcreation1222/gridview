<?php
header('Access-Control-Allow-Origin: *');
require 'image/vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$path = '/images';
$files = preg_grep('~\.(jpeg|jpg|png)$~', scandir(getcwd() . $path));
//print_r(sizeof($files)); exit;
$i = 0;

Image::configure(array('driver' => 'imagick'));
    
while ($i < sizeof($files)) {
    $imagename = 'thumbnails/' . $files[$i+2];
    
    if(file_exists($imagename)){
        $i++;
       continue;
    } 
    
    //echo 'images/' . $files[$i+2]; exit;
    // and you are ready to go ...
    $img = Image::make('images/' . $files[$i+2]);
    
    $img->resize(300, 375);
    $img->save('thumbnails/' . $files[$i+2]);
    //$tg->generate('images/' . $files[$i], 200, 250, 'thumbnails/' . $files[$i] );
    $i++;
}

echo 'Successfully generated thumbnails.';
?>