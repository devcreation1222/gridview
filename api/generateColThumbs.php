<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');
require 'image/vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;

$p_sql = "select * from collection";
$p_result = mysqli_query($link, $p_sql);
$products = [];
while($row = mysqli_fetch_array($p_result)) {
    $products[] = $row;
}

Image::configure(array('driver' => 'imagick'));
        
for ($i = 0; $i < sizeof($products); $i++) {
    $path = '/images/collection/'.$products[$i]['col_num'];
    $files = preg_grep('~\.(jpeg|jpg|png)$~', scandir(getcwd() . $path));

    $k = 0;

    while ($k < sizeof($files)) {
        $imagename = 'thumbnails/collection/'.$products[$i]['col_num'].'/'.$files[$k+2];
        
        if(file_exists($imagename)){
            $k++;
            continue;
        }
        $img = Image::make('images/collection/'.$products[$i]['col_num'].'/'.$files[$k+2]);
        
        $img->resize(120, 80);
        $img->save('thumbnails/collection/'.$products[$i]['col_num'].'/'.$files[$k+2]);
        $k++;
    }
}

echo 'Successfully generated thumbnails.';
mysqli_close($link);
?>