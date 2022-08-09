<?php
session_start();
if ($_SESSION["login_user"] == false) {
    header("location: index.php");
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

    <?php require "layouts/navbar_sidebar.php"; ?>

    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Hello</h4>
                    <?php
                    //var_dump($_SESSION);
                    if (isset($_SESSION["super_admin"])) {

                        echo "<h1>Super admin  [ {$_SESSION['login_user']} ]</h1>";
                    } elseif (isset($_SESSION["admin"])) {

                        echo "<h1>Admin  [ {$_SESSION['login_user']} ]</h1>";
                    } else {
                        echo "<h1>General User  [ {$_SESSION['login_user']} ]</h1>";
                    }

                    ?>
                </div>
            </div>
        </div>
    </main>

    <?php
    require "backend/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

</body>

</html>