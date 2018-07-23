<?php
header('Access-Control-Allow-Origin: *');
include('../adm/db.php');

$sql = "select * from product order by rand()";
$sql_result = mysqli_query($link, $sql);
$products = [];
while($row = mysqli_fetch_array($sql_result)) {
    $img_list = explode(',', $row['image']);
    $products[] = array(
        'id'=> $row['id'],
        'title'=> urldecode($row['title']),
        'image'=> trim($img_list[0]),
        'category'=> $row['category']
    );
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

?>