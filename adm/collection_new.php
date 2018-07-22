<?php
header('Access-Control-Allow-Origin: *');
include('db.php');

$action = isset($_POST['action']) ? $_POST['action'] : '';
if($action == 'add') {
    $col_num = urlencode(trim($_POST['col_num']));
    $col_description = urlencode(trim($_POST['col_description']));
    
    $upload_dir = "upload/";
    $upload_new_files = "";
    if(!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    if(isset($_FILES['col_image']) && $_FILES['col_image']['name'][0]) {
        $num = 0;
        $count = sizeof($_FILES['col_image']['name']);
        $time = time();
        for ($i = 0; $i < sizeof($_FILES['col_image']['name']); $i++) { 
            $tmp = pathinfo($_FILES['col_image']['name'][$i]);
            $success = move_uploaded_file($_FILES['col_image']['tmp_name'][$i], $upload_dir.$i.$time.".".$tmp['extension']);
            if($success) {
                $upload_new_files .= "http://192.168.1.16:8888/2_team/1_pae/3_gridview/angular/adm/".$upload_dir.$i.$time.".".$tmp['extension'].",";
                $num++;
            }
        }
        if($count == $num) {
            $col_image_link = $upload_new_files.trim($_POST['col_image_link']);
            mysqli_query($link, "INSERT INTO `collection` (`col_num`, `col_description`, `col_image`) VALUES ('".$col_num."', '".$col_description."', '".$col_image_link."')");
            echo "<script>location.href='./collection.php'</script>";
        }
    } else{
        $col_image_link = trim($_POST['col_image_link']);
        mysqli_query($link, "INSERT INTO `collection` (`col_num`, `col_description`, `col_image`) VALUES ('".$col_num."', '".$col_description."', '".$col_image_link."')");
        echo "<script>location.href='./collection.php'</script>";
    }

}

$m_sql = "SELECT MAX(col_num) as col_num FROM collection";
$m_sql_result = mysqli_query($link, $m_sql);

if ($m_sql_result) {
    $row = mysqli_fetch_row($m_sql_result);
    $cur_col_num = $row['col_num'];
} else {
    $cur_col_num = 1;
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
                    <h3 class="text-primary">Add a new collection</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Add a new collection</li>
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
                                    <form class="form-valide" action="./collection_new.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="add">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="col_num">Number <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <input type="number" class="form-control" id="col_num" name="col_num" placeholder="Enter a Collection Number..." value="<?php echo $cur_col_num;?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="col_description">Description <span class="text-danger">*</span></label>
                                            <div class="col-lg-6">
                                                <textarea class="form-control" id="col_description" name="col_description" placeholder="Enter Description..." style="height: 300px;"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="col_image_link">Image Link</label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="col_image_link" name="col_image_link" placeholder="http://example.com">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="col_image">Image Upload </label>
                                            <div class="col-lg-6 file-upload-area">
                                                <div>
                                                    <input type="file" id="col_image" name="col_image[]" multiple>
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

</body>

</html>