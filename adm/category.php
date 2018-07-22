<?php
header('Access-Control-Allow-Origin: *');
include('db.php');

$action = isset($_POST['action']) ? $_POST['action'] : "";
if($action == 'del') {
    $cate_id = $_POST['cate_id'];
    if(trim($cate_id)) {
        mysqli_query($link, "DELETE FROM `filters` WHERE id='".$cate_id."'");
        mysqli_query($link, "DELETE FROM `filters` WHERE parent='".$cate_id."'");
        mysqli_query($link, "UPDATE `product` SET `pkind`='' WHERE 1 pkind='".$cate_id."'");
    }
}

$m_sql = "select * from filters where parent='0'";
$m_sql_result = mysqli_query($link, $m_sql);
$category = [];
while($m_row = mysqli_fetch_array($m_sql_result)) {
    $m_cate_name = $m_row['cname'];
    $s_sql = "select * from filters where parent='".$m_row['id']."'";
    $s_sql_result = mysqli_query($link, $s_sql);
    $s_cate = [];
    while ($s_row = mysqli_fetch_array($s_sql_result)) {
        $s_cate[] = $s_row;
    }
    $category[] = array(
        'id'=> $m_row['id'],
        'cname'=> $m_cate_name,
        'sub'=> $s_cate
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Admin Panel</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->

    <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/treeLinks.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <?php include 'preloader.php'; ?>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <?php include 'header.php'; ?>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <?php include 'left_sidebar.php'; ?>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Category List</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Category List</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="min-height: 70vh;">
                            <div class="card-body">
                                <div class="col-md-6">
                                    <ul role="tree" aria-labelledby="tree1">
                                        <?php
                                            $num = 0;
                                            for ($i = 0; $i < sizeof($category); $i++) { 
                                                if($num == 0) {
                                                    echo "<li role='treeitem' aria-expanded='true'>";
                                                    $num = 1;
                                                } else {
                                                    echo "<li role='treeitem' aria-expanded='false'>";
                                                }
                                                echo "  <span>".urldecode($category[$i]['cname']);
                                                echo '      <button type="button" class="btn btn-danger card-actions btn-flat btn-xs btn-addon m-l-5" onclick="removeCate('.$category[$i]['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                            <button type="button" class="btn btn-primary card-actions btn-flat btn-xs btn-addon m-l-5"onclick="location.href=\'./category_edit.php?id='.$category[$i]['id'].'\'"><i class="fa fa-pencil-square-o"></i></button>';
                                                echo "  </span>";
                                                echo "  <ul>";
                                                for($j = 0; $j < sizeof($category[$i]['sub']); $j++) {
                                                    $num++;
                                                    $sub_cate = $category[$i]['sub'][$j];
                                                    echo "<li role='none'>";
                                                    echo "  <a>".urldecode($sub_cate['cname']);
                                                    echo '      <button type="button" class="btn btn-danger card-actions btn-flat btn-xs btn-addon m-l-5" onclick="removeCate('.$sub_cate['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                                <button type="button" class="btn btn-primary card-actions btn-flat btn-xs btn-addon m-l-5"onclick="location.href=\'./category_edit.php?id='.$sub_cate['id'].'\'"><i class="fa fa-pencil-square-o"></i></button>';
                                                    echo "  </a>";
                                                    echo "</li>";
                                                }
                                                echo "  </ul>";
                                            }
                                            ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Page wrapper  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. by ARTIFACT</a></footer>
            <!-- End footer -->
        </div>
        <!-- End Wrapper -->
    </div>
<form action="./category.php" method="post" id="myfrm">
    <input type="hidden" name="cate_id" id="cate_id" value="">
    <input type="hidden" name="action" id="action" value="">
</form>
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/scripts.js"></script>


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
    <script src="js/treeLinks.js"></script>
    <script src="js/treeitemLinks.js"></script>

    <script>
        function removeCate(param) {
            var resp = confirm("Do you want to delete this category?");
            if(resp == true) {
                $("#cate_id").val(param);
                $("#action").val('del');
                $('#myfrm').submit();
            } else {
                console.log('no');
            }
        }
    </script>

</body>

</html>