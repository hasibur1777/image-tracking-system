<?php

ob_start();

if (!session_start()) session_start();

if (isset($_POST['btn_login'])) {
    echo @$username = $_POST['user'];
    echo @$password = $_POST['password'];
    echo $username;

    if (empty($username)) {
        @$_SESSION['MESSAGE'] = @$message .= "User Name can not be blank ." . "<br>";
        @$error = true;
    }
    if (empty($password)) {
        @$_SESSION['MESSAGE'] = @$message .= "Password field can not be blank ." . "<br>";
        @$error = true;
    }

    if ((!empty($username)) and (!empty($password))) {
        $response = file_get_contents("http://192.168.200.200:8281/auth/CheckUser/index?userId=$username&userPass=$password");
        $json = json_decode($response, true);

        if ($json['auth'] == 1) {
            if ($json['auth'] == 1) {
                $response2 = file_get_contents("http://192.168.150.232:8080/pb/hrms_apps_v_1_0_3/employee_basic/emb_id.php?id=$username");
                $json2 = json_decode($response2, true);
                print_r($json2);

                $_SESSION['EMP_CODE'] = $json2['EMP_CODE'][0];

                if ($_SESSION['EMP_CODE']) {
                    $_SESSION['SESSIONCHECKING'] = true;
                    $_SESSION["login_user"] = $username;

                    require "backend/db_conn.php";


                    $my_query = "SELECT * FROM user_role WHERE user_id='$username' AND is_active=1";

                    $result = mysqli_query($conn, $my_query) or die("Query Failed");
                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_array($result)) {
                            if ($row['role'] == 'super_admin') {
                                $_SESSION['super_admin'] = $username;

                                $sql = "SELECT * FROM bc_business_global_catagory WHERE biz_global_cat_id='PROD_CAT' AND is_active=1";
                                $query = mysqli_query($conn_qc, $sql);
                                $all_products_arr = array();
                                while ($row2 = mysqli_fetch_array($query)) {
                                    $all_products_arr[$row2['short_code']] =  $row2['name'];
                                }
                                $_SESSION['products'] = $all_products_arr;
                            } else {
                                if ($row['role'] == 'admin') {
                                    $_SESSION['admin'] = $username;
                                }
                                $all_products_arr = array();
                                $sql2 = "SELECT * FROM user_prod WHERE user_id='$username' WHERE is_active='1'";
                                $query2 = mysqli_query($conn, $sql2);
                                while ($row2 = mysqli_fetch_array($query2)) {
                                    $all_products_arr[$row2['short_code']] =  $row2['product'];
                                }
                                $_SESSION['products'] = $all_products_arr; //implode(" ,, ", $all_products_arr);
                            }
                            header("Location: welcome.php");
                        }
                    } else {
                        session_destroy();
                        header("location: index.php");
                    }
                }
            } else {
                @$_SESSION['MESSAGE'] = @$message .= "User Name and Password does not match" . "<br>";
                header("Location:index.php");
            }
        } else {
            @$error = true;
            header("Location:index.php");
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Tracking System</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Theme style -->
    <link rel="stylesheet" href="css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>Image Tracking System</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="index.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="user" placeholder="Employee ID">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="HRMS password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">

                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="btn_login" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


                <!-- /.social-auth-links -->


            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <?php
    require "backend/footer.php";
    ?>
</body>

</html>