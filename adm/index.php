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
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
<style>
    #loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #fff;
        z-index: 1000;
    }
    
    .lock-screen .form-group {
        width: 200px;
        float: left;
    }
    
    .lock-screen .btn-right {
        float: right;
    }
    
    .lock-screen .form-control {
        border-radius: unset;
    }
    
    .lock-screen .btn {
        background-color: #fff;
        border-color: #fff;
    }
    
    .lock-screen .btn:focus {
        outline: 0 !important;
        border: none !important;
        background-color: #fff !important;
        border-radius: unset !important;
        box-shadow: unset !important;
    }
    
    .lock-screen .fa {
        color: #000;
        font-size: 24px;
    }
    
    @media (max-width: 600px) {
    	.lock-screen .form-group {
    	    width: 135px;
    	}
    }
</style>

<div id="loader-wrapper">
    <div style="position: relative; height: 100%;">
        <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
            <div class="lock-screen">
                <div style="clear: both;">
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" required />
                    </div>
                    <div class="btn-right">
                        <button id="btn-unlock" type="button" class="btn btn-primary"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
<script>
    $("#btn-unlock").click(function() {
        var password = $("#password").val();
        console.log(password);
        if (password == "password1") {
            location.href='./product.php';
        } else {
            return false;
        }
    });
</script>