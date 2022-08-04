<?php
session_start();
require "backend/db_conn.php";
if ($_SESSION["login_user"] == false) {
    header("location: index.php");
}

$sub_user_id = $_GET["id"];

if (isset($_SESSION["admin"]) || isset($_SESSION["super_admin"])) {
    if ($_SESSION["login_user"] == $sub_user_id) {
        header("location: user.php");
    }
} else {
    header("location: user.php");
}


if (isset($_GET["id"])) {
    @$uid = $_GET["id"];
    $result = mysqli_query($conn, "SELECT * FROM user_prod WHERE user_id='$uid' and is_active='1'");
    @$user_product_details = array();
    while ($row = mysqli_fetch_array($result)) {
        $user_product_details[$row['short_code']] = $row['product'];
    }
    //var_dump($user_product_details);
    $my_query = "SELECT * FROM user_role WHERE user_id='$uid'";
    $result2 = mysqli_query($conn, $my_query) or die("Query Failed");
    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_array($result2)) {
            @$sub_user_role = $row['role'];
        }
    }
    $admin_products = $_SESSION['products'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["role"])) {

        $all = $_POST;
        $sub_user_id = $_POST["user_id"];
        $sub_user_role = $_POST["role"];
        if (count($all) > 2) {
            echo $sub_user_id;


            //user role changing
            $sqlquery = "SELECT * FROM user_role WHERE user_id='$sub_user_id'";
            $result = mysqli_query($conn, $sqlquery);
            if (mysqli_num_rows($result) > 0) {
                $role_update_query = "UPDATE user_role SET role='$sub_user_role' WHERE user_id='$sub_user_id'";
                if (mysqli_query($conn, $role_update_query) === TRUE) {
                    echo "Record inserted successfully";
                } else {
                    echo "Error: " . $role_update_query . "<br>" . $conn->error;
                }
            }

            // remove all products from user
            $remove_query = "UPDATE user_prod SET is_active=0 WHERE user_id='$sub_user_id'";

            if (mysqli_query($conn, $remove_query) === TRUE) {
                //header("location: user.php");
            } else {
                echo "Error rmv: " . $remove_query . "<br>" . $conn->error;
            }

            //echo count($all);



            // insert product
            foreach ($all as $x => $value) {
                if ($x != "user_id" && $x != "role") {

                    $sqlquery = "INSERT INTO user_prod (user_id, short_code, product) VALUES ('$sub_user_id', '$x', '$value')";

                    if (mysqli_query($conn, $sqlquery) === TRUE) {
                        echo "record inserted successfully";
                    } else {
                        echo "Error: " . $sqlquery . "<br>" . $conn->error;
                    }
                }
            }

            header("location: user.php");
        } else {
            $_SESSION['double_create_error'] = "Checkbox Empty";
        }
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4>Edit User</h4>
                    <hr>

                    <form action="edit_user.php" method="POST">

                        <?php
                        if (isset($_SESSION['super_admin'])) { ?>
                            <select class="form-select mb-1" name="role" id="edit_user_role" required>
                                <option value="">Select One</option>
                                <option value="admin" <?php if (@$sub_user_role == 'admin') {
                                                            echo "selected";
                                                        }; ?>>admin</option>
                                <option value="user" <?php if (@$sub_user_role == 'user') {
                                                            echo "selected";
                                                        }; ?>>user</option>
                            </select>
                        <?php
                        } elseif (isset($_SESSION['admin'])) { ?>
                            <input type="text" name="role" value="user" hidden>
                        <?php
                        } {
                        }
                        ?>

                        <input type="text" name="user_id" id="edit_user_id" class="form-control mb-1" value="<?php echo $uid; ?>" placeholder="user id" readonly>
                        <div class="form-check">
                            <ul>
                                <?php
                                //var_dump($user_product_details);
                                foreach ($admin_products as $key => $value) {
                                ?>
                                    <li>
                                        <input class="form-check-input" <?php if (in_array($value, $user_product_details)) {
                                                                            echo "checked";
                                                                        } ?> type="checkbox" name="<?php echo $key; ?>" value="<?php echo $value; ?>">

                                        <label for=""> <?php echo $value; ?> </label>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>

                        <input type="submit" class="btn btn-sm btn-outline-success" value="Update">
                        <div class="text-end">
                            <a href="user.php" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
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