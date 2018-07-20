<?php
header('Access-Control-Allow-Origin: *');

include('db.php');

$tmp = ['9', '10', '12', '13', '14', '15', '21', '22', '23', '24', '25', '26', '29', '30', '32', '33', '34', '35'];

require('excel/php-excel-reader/excel_reader2.php');
require('excel/SpreadsheetReader.php');

$Reader = new SpreadsheetReader("products.xls");
$Sheets = $Reader->Sheets();
foreach ($Sheets as $Index => $Name)
{
    $Reader -> ChangeSheet($Index);
    $num = 0;
    foreach ($Reader as $Row)
    {
        if($num != 0) {
            $title = $Row[2];
            $description = $Row[3];
            $type = $Row[4];
            $tags = $Row[5];
            $category = $tmp[mt_rand(0, 17)];
            $visible = $Row[7];
            $images = $Row[8];
            $sku = $Row[9];
            $price = $Row[10];
            $sale_price = $Row[11];
            $on_sale = $Row[12];
            $weight = $Row[13];
            $length = $Row[14];
            $width = $Row[15];
            $height = $Row[16];
            $stock = $Row[17];

            if(trim($visible) && trim($images)) {
                $sql = "INSERT INTO `product`(`title`, `description`, `category`, `image`, `type`, `tags`, `sku`, `price`, `sale_price`, `on_sale`, `weight`, `length`, `width`, `height`, `stock`) 
                        VALUES ('".urlencode($title)."', '".urlencode($description)."', '".$category."', '".$images."', '".$type."', '".$tags."', '".$sku."', '".$price."', '".$sale_price."', '".$on_sale."', '".$weight."', '".$length."', '".$width."', '".$height."', '".$stock."')";
    
                mysqli_query($link, $sql);
            }
        }
        $num = 1;
    }
}


?>