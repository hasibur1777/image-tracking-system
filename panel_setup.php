<?php
session_start();
if (!isset($_SESSION["login_user"])) {
    header("location: index.php");
}
else{
    require "db_conn.php";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){ 

    if (isset($_POST["product"])) {
        $_SESSION["product"] = $_POST["product"];
        $_SESSION["line"] = $_POST["line"];
        $_SESSION["point"] = $_POST["point"];

        header("location: tracking_panel.php");
    }
    else{
        session_destroy();
        header("location: index.php");
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />

    <title>Image Tracking System</title>
</head>

<body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                aria-controls="offcanvasExample">
                <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
            </button>
            <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="#">Image Tracking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar"
                aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="topNavBar">
                <div class="d-flex ms-auto my-3 my-lg-0">
                </div>
                <ul class="navbar-nav">
                    <li>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="submit" value="Logout" class="btn btn-sm btn-outline-danger">
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        <div class="text-muted small fw-bold text-uppercase px-3">
                        </div>
                    </li>
                    <li>
                        <a href="welcome.php" class="nav-link px-3 ">
                            <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link px-3">
                            <span class="me-2"><i class="bi bi-book-fill"></i></span>
                            <span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="panel_setup.php" class="nav-link px-3 active">
                            <span class="me-2"><i class="bi bi-book-fill"></i></span>
                            <span>Track</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="text-center mb-2">Panel Setup</h1>
                    <hr>
                    <div class="row">
                        <div class="col-3">

                        </div>
                        <div class="col-6">
                        <div class="card p-3">
                        <form action="panel_setup.php" method="post">

                            <div class="row g-3 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">Product</label>
                                </div>
                                <div class="col">
                                    <select class="form-select mb-1" aria-label="Default select example" name="product"
                                        id="category-dropdown">
                                        <option selected>Select One</option>
                                        <?php
                                            @$sql = "SELECT * FROM bc_business_global_catagory WHERE biz_global_cat_id='PROD_CAT' AND is_active=1";
                                            @$query = mysqli_query($conn_qc, $sql);
                                            var_dump($query);
                                            // $ex = explode("_",trim($product_id));
                                            while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                                    <option value="<?php echo $row['short_code']; ?>">

                                                        <?php echo $row['name']; ?>
                                                    </option>
                                                    <?php
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">Line</label>
                                </div>
                                <div class="col">
                                    <select class="form-select mb-1" aria-label="Default select example" name="line"
                                        id="sub-category-dropdown">
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-3">
                                    <label for="" class="col-form-label">Point</label>
                                </div>
                                <div class="col">
                                    <select class="form-select mb-1" aria-label="Default select example" name="point">
                                        <option selected>Select One</option>
                                        <option value="packaging_point">Packaging Point</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center">
                                <div class="col-3">

                                </div>
                                <div class="col-3">
                                    <input type="submit" class="btn btn-primary" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#category-dropdown').on('change', function() {
            var short_code = this.value;
            $.ajax({
                url: "fetchLine.php",
                type: "POST",
                data: {
                    short_code: short_code
                },
                cache: false,
                success: function(result) {
                    $("#sub-category-dropdown").html(result);
                    console.log(result);
                }
            });
        });
    });
    </script>

</body>

</html>