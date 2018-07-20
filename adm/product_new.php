<?php
header('Access-Control-Allow-Origin: *');
include('db.php');

$action = isset($_POST['action']) ? $_POST['action'] : '';
if($action == 'add') {
    $pname = urlencode(trim($_POST['val-productname']));
    $psize = urlencode(trim($_POST['val-productsize']));
    $pkind = isset($_POST['val-productkind']) ? $_POST['val-productkind'] : "";
    $pdesc = urlencode(trim($_POST['val-productdescription']));
    $pmaterial = urlencode(trim($_POST['val-productmaterial']));
    
    $category = "";
    if($pkind != "") {
        for ($i = 0; $i < sizeof($pkind); $i++) { 
            if($pkind[$i]) {
                $category .= $pkind[$i].",";
            }
        }
    }
    
    $upload_dir = "upload/";
    $upload_new_files = "";
    if(!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    if(isset($_FILES['val-productimage']) && $_FILES['val-productimage']['name'][0]) {
        $num = 0;
        $count = sizeof($_FILES['val-productimage']['name']);
        $time = time();
        for ($i = 0; $i < sizeof($_FILES['val-productimage']['name']); $i++) { 
            $tmp = pathinfo($_FILES['val-productimage']['name'][$i]);
            $success = move_uploaded_file($_FILES['val-productimage']['tmp_name'][$i], $upload_dir.$i.$time.".".$tmp['extension']);
            if($success) {
                $upload_new_files .= "http://192.168.1.40/2_team/1_pae/3_gridview/angular/adm/".$upload_dir.$i.$time.".".$tmp['extension'].",";
                $num++;
            }
        }
        if($count == $num) {
            $plink = $upload_new_files.trim($_POST['val-productlink']);
            mysqli_query($link, "INSERT INTO `product`(`title`, `size`, `material`, `category`, `description`, `image`) VALUES ('".$pname."', '".$psize."', '".$pmaterial."', '".$category."', '".$pdesc."', '".$plink."')");
            echo "<script>location.href='./index.php'</script>";
        }
    } else{
        $plink = trim($_POST['val-productlink']);
        // mysqli_query($link, "INSERT INTO `product`(`title`, `size`, `category`, `description`, `image`) VALUES ('".$pname."', '".$psize."', '".$category."', '".$pdesc."', '".$plink."')");
        mysqli_query($link, "INSERT INTO `product`(`title`, `size`, `material`, `category`, `description`, `image`) VALUES ('".$pname."', '".$psize."', '".$pmaterial."', '".$category."', '".$pdesc."', '".$plink."')");
        echo "<script>location.href='./index.php'</script>";
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
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="hide-menu">Product</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="product_new.php">New</a></li>
                                <li><a href="index.php">List</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-share-alt" aria-hidden="true"></i><span class="hide-menu">Category</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="category_new.php">New</a></li>
                                <li><a href="category.php">List</a></li>
                            </ul>
                        </li>
                        <li><a href="setting.php"><i class="fa fa-cog" aria-hidden="true"></i><span class="hide-menu">Setting</span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Add a new product</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add a new product</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="./product_new.php" method="post">
                                    <input type="hidden" name="action" value="csv_import">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-productname">CSV File import <span class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="file" class="form-control" id="val-csvfile" name="val-csvfile">
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
                        <div class="card" style="min-height: 70vh;">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="./product_new.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="add">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-productname">Product Title <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-productname" name="val-productname" placeholder="Enter a Product Title..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-productsize">Product Size</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-productsize" name="val-productsize" placeholder="Enter a Product Size..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-productmaterial">Product Material</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-productmaterial" name="val-productmaterial" placeholder="Enter a Product Material..">
                                            </div>
                                        </div>
                                        <?php
                                        for ($i = 0; $i < sizeof($category); $i++) { 
                                        ?>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-productkind"><?php echo $category[$i]['cname'];?></label>
                                            <div class="col-lg-6">
                                                <?php
                                                if($category[$i]['cname'] == 'Mood') {
                                                ?>
                                                <select class="form-control" id="val-mood" name="val-productkind[]" multiple="multiple">
                                                <?php
                                                } else {
                                                ?>
                                                <select class="form-control" id="val-productkind" name="val-productkind[]">
                                                    <option value="">Please select</option>
                                                <?php
                                                }
                                                ?>
                                                    <?php
                                                        for ($j = 0; $j < sizeof($category[$i]['sub']); $j++) { 
                                                            $sub_cate = $category[$i]['sub'][$j];
                                                            echo "<option value='".$sub_cate['id']."'>".urldecode($sub_cate['cname'])."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-productdescription">Product Description <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="val-productdescription" name="val-productdescription" placeholder="Enter Product Description......." style="height: 300px;"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-productlink">Product Image Link</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-productlink" name="val-productlink" placeholder="http://example.com">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-productimage-label">Product Image Upload </label>
                                            <div class="col-lg-6 file-upload-area">
                                                <div>
                                                    <input type="file" id="val-productimage" name="val-productimage[]" multiple>
                                                    <p>Drag your files here or click in this area.</p>
                                                </div>
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
    <link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
    <script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js" type="text/javascript"></script>
    <!--Custom JavaScript -->
    <script src="js/scripts.js"></script>
    <script type="text/javascript">
        $(function () {
            $('#val-mood').multiselect({
                includeSelectAllOption: true
            });
        });
    </script>

</body>

</html>