<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

$path = '/thumbnails';
$files = preg_grep('~\.(jpeg|jpg|png)$~', scandir(getcwd() . $path));
shuffle($files);
$products = [];
$i = 2;
while ($i < sizeof($files)) {
    $img_id = intval(pathinfo($files[$i])['filename']);
    $sql = "select * from product where id=" . $img_id;
    $sql_result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($sql_result);
    $products[] = array(
         'id' => $img_id,
         'image' => './api/thumbnails/' . $files[$i],
         'title' => urldecode($row['title']),
         'category'=> $row['category']
    );
    $i++;
}

// echo json_encode($products);

$m_sql = "select * from filters where parent='0'";
$m_sql_result = mysqli_query($link, $m_sql);
$category = [];
while ($m_row = mysqli_fetch_array($m_sql_result)) {
    $m_cate_name = $m_row['cname'];
    $s_sql = "select * from filters where parent='".$m_row['id']."'";
    $s_sql_result = mysqli_query($link, $s_sql);
    $s_cate = [];
    while ($s_row = mysqli_fetch_array($s_sql_result)) {
        $s_cate[] = array(
            'id'=> $s_row['id'],
            'cname'=> urldecode($s_row['cname']),
            'parent'=> $s_row['parent']
        );
    }
    $category[] = array(
        'id'=> $m_row['id'],
        'cname'=> urldecode($m_cate_name),
        'sub'=> $s_cate,
        'parent'=> $m_row['parent']
    );
}

$output = array(
    'product'=> $products,
    'filter'=> $category,
);

echo json_encode($output);

mysqli_close($link);

?>