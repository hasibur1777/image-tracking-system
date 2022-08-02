<?php
session_start();
require "db_conn.php";
if ($_SESSION["login_user"] == false) {
    header("location: index.php");
}
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    if (isset($_POST["user_id"])) {
        
        $all = $_POST;
        $user_id = $_POST["user_id"];
        $user_role = $_POST["role"];
        
        foreach($all as $x => $value) {
            if ($x != "user_id" && $x != "role") {

                $sqlquery = "INSERT INTO user_prod (user_id, short_code, product) 
                            VALUES ('$user_id', '$x', '$value')";

                if (mysqli_query($conn, $sqlquery) === TRUE) {
                    echo "record inserted successfully";
                } else {
                    echo "Error: " . $sqlquery . "<br>" . $conn->error;
                }
            }
        }
        if ($user_role != "") {

            $sqlquery = "SELECT * FROM user_role WHERE user_id='$user_id'";
            $result = mysqli_query($conn, $sqlquery);
            if(mysqli_num_rows($result) > 0){
                $sqlquery3 = "UPDATE user_role SET role='$user_role' WHERE user_id='$user_id'";
                if (mysqli_query($conn, $sqlquery3) === TRUE) {
                    echo "Record inserted successfully";
                } else {
                    echo "Error: " . $sqlquery3 . "<br>" . $conn->error;
                }
            }else{
                $sqlquery2 = "INSERT INTO user_role (user_id, role) 
                                VALUES ('$user_id', '$user_role')";
    
                if (mysqli_query($conn, $sqlquery2) === TRUE) {
                    echo "Record inserted successfully";
                } else {
                    echo "Error: " . $sqlquery2 . "<br>" . $conn->error;
                }

            }
        }

        header("location: user.php");
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
    
<?php require "layouts/navbar-sidebar.php"; ?>


    <main class="mt-5 pt-3">
        <div class="container">
            <h3 class="text-center">User Details</h3>
            <hr>

            <?php
            if (isset($_SESSION['super_admin']) || isset($_SESSION['admin'])) {
                ?>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add User
            </button>

            <?php
            }
            ?>


            <!-- Modal -->
            <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="user.php" method="POST">
                                
                            <?php
                            if (isset($_SESSION['super_admin'])) {?>
                                <select class="form-select mb-1" name="role" required>
                                    <option value="">Select One</option>
                                    <option value="admin">admin</option>
                                    <option value="user">user</option>
                                </select>
                            <?php
                            }elseif (isset($_SESSION['admin'])) {?>
                                <input type="text" name="role" value="user" hidden>
                            <?php
                            }{

                            }
                            ?>

                                <input type="text" name="user_id" class="form-control mb-1" placeholder="user id"
                                    required>
                                <div class="form-check">
                                    <ul>
                                        <?php
                                            @$sql = "SELECT * FROM bc_business_global_catagory WHERE biz_global_cat_id='PROD_CAT' AND is_active=1";
                                            @$query = mysqli_query($conn_qc, $sql);
                                            //var_dump($query);
                                            // $ex = explode("_",trim($product_id));
                                            while ($row = mysqli_fetch_array($query)) {
                                                    ?>
                                        <li>
                                            <input class="form-check-input" type="checkbox"
                                                name="<?php echo $row['short_code']; ?>" id="<?php echo $row['id']; ?>"
                                                value="<?php echo $row['name']; ?>">

                                            <label for="vehicle1"> <?php echo $row['name']; ?> </label>
                                        </li>
                                        <?php
                                            }
                                    ?>
                                    </ul>
                                </div>

                                <input type="submit" class="btn btn-sm btn-success" value="Submit">
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary btn-sm mt-1"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Product</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    @$sql = "SELECT * FROM user_prod WHERE is_active=1 GROUP BY user_id";
                    @$query = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($query)) {
                            ?>
                    <tr>
                        <th scope="row"><?php echo $row['user_id']; ?></th>
                        <td>
                            <?php
                            $prod_user_id = $row['user_id'];
                            @$sql2 = "SELECT product FROM user_prod WHERE user_id='$prod_user_id'";
                            @$query2 = mysqli_query($conn, $sql2);
                            while ($row2 = mysqli_fetch_array($query2)) {
                             echo $row2['product'] . ", ";
                            }
                            ?>

                        </td>
                        <td>
                            <?php
                            $prod_user_id = $row['user_id'];
                            @$sql2 = "SELECT role FROM user_role WHERE user_id='$prod_user_id'";
                            @$query2 = mysqli_query($conn, $sql2);
                            while ($row2 = mysqli_fetch_array($query2)) {
                             echo $row2['role'] . " ";
                            }
                            ?>

                        </td>
                        <td>
                            <a href="" class="btn btn-sm btn-warning">Edit</a>
                            <a href=""
                                class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>

                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.all.min.js"></script>

    <script>
    /*
    //onclick="removeFunc(<?php echo $row['id']; ?>)"
    function removeFunc(params) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })
    }
    */
    </script>


    <?php
    require "footer.php";
    ?>
</body>

</html>