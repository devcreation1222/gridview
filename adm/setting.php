<?php
header('Access-Control-Allow-Origin: *');
include('db.php');

$action = isset($_POST['submit']) ? $_POST['submit'] : "";
if($action == "save") {
    $title = isset($_POST['val-title']) ? 1: 0;
    $desc = isset($_POST['val-description']) ? 1: 0;
    $cate = isset($_POST['val-category']) ? 1: 0;
    $img = isset($_POST['val-image']) ? 1: 0;
    $size = isset($_POST['val-size']) ? 1: 0;
    $material = isset($_POST['val-material']) ? 1: 0;
    $type = isset($_POST['val-type']) ? 1: 0;
    $tags = isset($_POST['val-tags']) ? 1: 0;
    $sku = isset($_POST['val-sku']) ? 1: 0;
    $price = isset($_POST['val-price']) ? 1: 0;
    $sale_price = isset($_POST['val-sale_price']) ? 1: 0;
    $on_sale = isset($_POST['val-on_sale']) ? 1: 0;
    $weight = isset($_POST['val-weight']) ? 1: 0;
    $length = isset($_POST['val-length']) ? 1: 0;
    $width = isset($_POST['val-width']) ? 1: 0;
    $height = isset($_POST['val-height']) ? 1: 0;
    $stock = isset($_POST['val-stock']) ? 1: 0;
    mysqli_query($link, "UPDATE `setting` SET `state`='".$title."' WHERE `field`='title'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$desc."' WHERE `field`='description'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$cate."' WHERE `field`='category'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$img."' WHERE `field`='image'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$size."' WHERE `field`='size'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$material."' WHERE `field`='material'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$type."' WHERE `field`='type'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$tags."' WHERE `field`='tags'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$sku."' WHERE `field`='sku'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$price."' WHERE `field`='price'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$sale_price."' WHERE `field`='sale_price'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$on_sale."' WHERE `field`='on_sale'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$weight."' WHERE `field`='weight'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$length."' WHERE `field`='length'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$width."' WHERE `field`='width'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$height."' WHERE `field`='height'");
    mysqli_query($link, "UPDATE `setting` SET `state`='".$stock."' WHERE `field`='stock'");
}

$sql = "select * from setting";
$sql_result = mysqli_query($link, $sql);
$options = [];
while($row = mysqli_fetch_array($sql_result)) {
    $options[] = $row;
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
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
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
                                <li><a href="product.php">List</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-share-alt" aria-hidden="true"></i><span class="hide-menu">Category</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="category_new.php">New</a></li>
                                <li><a href="category.php">List</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-share-alt" aria-hidden="true"></i><span class="hide-menu">Collection</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="collection_new.php">New</a></li>
                                <li><a href="collection.php">List</a></li>
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
                    <h3 class="text-primary">Setting</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Setting</li>
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
                            <h2 class="row" style="text-indent: 50px;">Display Options</h2>
                            <hr>
                            <form action="setting.php" method="post">
                            <input type="hidden" name="submit" value="save">
                            <div class="card-body row">
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[0]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-title" name="val-title" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-title" name="val-title">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-title">Title</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[1]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-size" name="val-size" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-size" name="val-size">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-size">Measurement</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[2]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-category" name="val-category" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-category" name="val-category">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-category">Category</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[3]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-image" name="val-image" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-image" name="val-image">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-image">Image</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[4]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-material" name="val-material" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-material" name="val-material">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-material">Year</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[5]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-description" name="val-description" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-description" name="val-description">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-description">Description</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[6]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-sku" name="val-sku" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-sku" name="val-sku">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-sku">SKU</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[7]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-price" name="val-price" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-price" name="val-price">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-price">Price</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[8]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-sale_price" name="val-sale_price" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-sale_price" name="val-sale_price">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-sale_price">Sale Price</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[9]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-on_sale" name="val-on_sale" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-on_sale" name="val-on_sale">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-on_sale">On Sale</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[10]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-weight" name="val-weight" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-weight" name="val-weight">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-weight">weight</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[11]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-length" name="val-length" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-length" name="val-length">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-length">Length</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[12]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-width" name="val-width" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-width" name="val-width">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-width">Width</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[13]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-height" name="val-height" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-height" name="val-height">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-height">Height</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[14]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-stock" name="val-stock" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-stock" name="val-stock">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-stock">Stock</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[15]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-tags" name="val-tags" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-tags" name="val-tags">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-tags">Tags</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group row">
                                        <div class="col-lg-4">
                                        <?php
                                        if($options[16]['state']) {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-type" name="val-type" checked>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="checkbox" class="form-control" id="val-type" name="val-type">
                                        <?php
                                        }
                                        ?>
                                        </div>
                                        <label class="col-lg-6 col-form-label" for="val-type">Type</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </form>
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