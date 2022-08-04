<?php
session_start();

if (isset($_SESSION["product"]) && isset($_SESSION["line"]) && isset($_SESSION["point"])) {
    header("location: tracking_panel.php");
}
if (!isset($_SESSION["login_user"])) {
    header("location: index.php");
} else {
    require "backend/db_conn.php";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["product"])) {
        $_SESSION["product"] = $_POST["product"];
        $_SESSION["line"] = $_POST["line"];
        $_SESSION["point"] = $_POST["point"];

        header("location: tracking_panel.php");
    } else {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />

    <title>Image Tracking System</title>
</head>

<body>

    <?php require "layouts/navbar-sidebar.php"; ?>

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
                                            <select class="form-select mb-1" aria-label="Default select example" name="product" id="category-dropdown" required>
                                                <option value="">Select One</option>
                                                <?php
                                                $user_id = $_SESSION["login_user"];
                                                $sql = "SELECT * FROM user_prod WHERE user_id='$user_id' AND is_active=1";
                                                $query = mysqli_query($conn, $sql);
                                                var_dump($query);
                                                while ($row = mysqli_fetch_array($query)) {
                                                ?>
                                                    <option value="<?php echo $row['short_code']; ?>">

                                                        <?php echo $row['product']; ?>
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
                                            <select class="form-select mb-1" aria-label="Default select example" name="line" id="sub-category-dropdown" required>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Point</label>
                                        </div>
                                        <div class="col">
                                            <select class="form-select mb-1" aria-label="Default select example" name="point" required>
                                                <option value="">Select One</option>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#category-dropdown').on('change', function() {
                var short_code = this.value;
                console.log(short_code);
                $.ajax({
                    url: "backend/fetch_line.php",
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

    <?php
    require "backend/footer.php";
    ?>

</body>

</html>