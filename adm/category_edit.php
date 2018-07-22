<?php
header('Access-Control-Allow-Origin: *');
include('db.php');

$action = isset($_POST['action']) ? $_POST['action'] : '';
if($action == 'edit') {
    $cname = trim($_POST['val-categoryname']);
    $cid = trim($_POST['cate_id']);
    if($cname) {
        $valid_sql = "select * from filters where cname='".urlencode($cname)."' and id<>'".$cid."'";
        $valid_sql_result = mysqli_query($link, $valid_sql);
        $num = 0;
        while ($v_row = mysqli_fetch_array($valid_sql_result)) {
            $num++;
        }
        if($num == 0) {
            $new_sql = "UPDATE `filters` SET `cname`='".urlencode($cname)."' WHERE id='".$cid."'";
            mysqli_query($link, $new_sql);
            echo "<script>location.href='./category.php'</script>";
        } else {
            echo "<script>alert('Category name is already exist.')</script>";
        }
    } else {
        echo "<script>alert('Please enter a category name.')</script>";
    }
}

$cate_id = isset($_GET['id']) ? $_GET['id'] : "";
if($cate_id) {
    $sql = "select * from filters where id='".$cate_id."'";
    $sql_result = mysqli_query($link, $sql);
    $cur_cate = "";
    while ($row = mysqli_fetch_array($sql_result)) {
        $cur_cate = $row;
    }
    if($cur_cate == "" or sizeof($cur_cate) == 0) {
        header('location: ./category.php');
    }
} else {
    header('location: ./category.php');
}

$c_sql = "select * from filters where parent='0'";
$c_sql_result = mysqli_query($link, $c_sql);
$category = [];
while ($row = mysqli_fetch_array($c_sql_result)) {
    $category[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Admin Panel</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
                    <h3 class="text-primary">Edit category</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">edit category</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card" style="min-height: 70vh;">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="./category_edit.php?id=<?php echo $cate_id;?>" method="post">
                                        <input type="hidden" name="action" id="action" value="edit">
                                        <input type="hidden" name="cate_id" id="cate_id" value="<?php echo $cate_id;?>">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-categoryname">Category Name <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-categoryname" name="val-categoryname" placeholder="Enter a Category Name.." value="<?php echo urldecode($cur_cate['cname']);?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. by ARTIFACT</a></footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
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


    <!-- Form validation -->
    <script src="js/lib/form-validation/jquery.validate.min.js"></script>
    <script src="js/lib/form-validation/jquery.validate-init.js"></script>
    <!--Custom JavaScript -->
    <script src="js/scripts.js"></script>

</body>

</html>