<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

$id = isset($_POST['id']) ? $_POST['id'] : "";

$sql = "select * from product where id='".$id."'";
$sql_result = mysqli_query($link, $sql);
$product = "";
while($row = mysqli_fetch_array($sql_result)) {
    $product = $row;
}

$s_sql = "select * from setting";
$s_result = mysqli_query($link, $s_sql);
$setting = [];
while($row = mysqli_fetch_array($s_result)) {
    $setting[] = $row;
}

$output = [];
if($product) {
    $output['title'] = urldecode($product['title']);
    $output['image'] = urldecode($product['image']);
    $sub = [];
    for($i = 0; $i < sizeof($setting); $i++) {
        if($setting[$i]['state'] == '1') {
            $value = $product[$setting[$i]['field']];
            if(trim($value) && ($setting[$i]['field'] != 'title' && ($setting[$i]['field'] != 'image') && ($setting[$i]['field'] != 'category'))) {
                $sub[$setting[$i]['field']] = urldecode($product[$setting[$i]['field']]);
            }
        }
    }
    $output['sub'] = $sub;

    $c_list = explode(',', $product['category']);
    $category = 0;
    for ($j = 0; $j < sizeof($c_list); $j++) { 
        $c_sql = "select * from filters where id='".$c_list[$j]."'";
        $c_sql_result = mysqli_query($link, $c_sql);
        while ($row = mysqli_fetch_array($c_sql_result)) {
            if(urldecode($row['cname']) == "Vintage") {
                $category = 1;
            }
        }
    }

    $output['vintage'] = $category;

}

echo json_encode($output);

mysqli_close($link);

?>