<?php
header('Access-Control-Allow-Origin: *');
include('db.php');

$action = isset($_POST['action']) ? $_POST['action'] : "";
if($action == 'del') {
    $pid = $_POST['p_id'];
    if(trim($pid)) {
        mysqli_query($link, "DELETE FROM `product` WHERE id='".$pid."'");
    }
}

$p_sql = "select * from product";
$p_result = mysqli_query($link, $p_sql);
$products = [];
while($row = mysqli_fetch_array($p_result)) {
    $products[] = $row;
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
    <link rel="stylesheet" href="icons/font-awesome/css/font-awesome.min.css">
    <!-- <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- Custom CSS -->

    <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
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
                    <h3 class="text-primary">Product List</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Product List</li>
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
                                <h4 class="card-title">Product Export</h4>
                                <h6 class="card-subtitle">Export products to Copy, CSV, Excel, PDF & Print</h6>
                                <button type="button" id="generate-thumbnails" class="btn btn-middle btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Images">Speed Up</button>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php
                                            for ($i = 0; $i < sizeof($products); $i++) {
                                                $img_list = explode(',', $products[$i]['image']);
                                                $main_img = trim($img_list[0]);
                                                $c_list = explode(',', $products[$i]['category']);
                                                $category = "";
                                                for ($j = 0; $j < sizeof($c_list); $j++) { 
                                                    $c_sql = "select * from filters where id='".$c_list[$j]."'";
                                                    $c_sql_result = mysqli_query($link, $c_sql);
                                                    while ($row = mysqli_fetch_array($c_sql_result)) {
                                                        $category .= urldecode($row['cname']).", ";
                                                    }
                                                }
                                        ?>
                                        <tr>
                                            <td style="width: 10%;"><?php echo $i+1;?></td>
                                            <td style="width: 10%;"><img src="<?php echo urldecode($main_img);?>" alt="" style="width: 100px;"></td>
                                            <td style="width: 10%;"><?php echo urldecode($products[$i]['title']);?></td>
                                            <td style="width: 10%;"><?php echo urldecode($category);?></td>
                                            <td style="width: 10%;">
                                                <button type="button" class="btn btn-primary btn-flat btn-addon m-l-5" onclick="location.href='./product_edit.php?id=<?php echo $products[$i]['id'];?>'"><i class="fa fa-pencil-square-o"></i></button>
                                                <button type="button" class="btn btn-danger btn-flat btn-addon m-l-5" onclick="removeProduct('<?php echo $products[$i]['id'];?>');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>
                                        <?php        
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Page wrapper  -->
        </div>
        <!-- End Wrapper -->
    </div>
    <form action="./product.php" method="post" id="myfrm">
        <input type="hidden" name="p_id" id="p_id" value="">
        <input type="hidden" name="action" id="action" value="">
    </form>

    <!-- All Jquery -->
    <!-- <script src="js/lib/jquery/jquery.min.js"></script> -->
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <!-- <script src="js/lib/bootstrap/js/bootstrap.min.js"></script> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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

    <script>
        function removeProduct(param) {
            var resp = confirm("Do you want to delete this category?");
            if(resp == true) {
                console.log(param);
                $("#p_id").val(param);
                $("#action").val('del');
                $('#myfrm').submit();
            } else {
                console.log('no');
            }
        }
        
        $("#generate-thumbnails").click(function(){
            $(this).button('loading');
            $.when($.ajax("../api/downloadImages.php"), $.ajax("../api/generateThumbnails.php")).done(function() {
                alert("Successfully speed up.");
                $("#generate-thumbnails").button('reset');
            });
        });
        
    </script>

</body>

</html>