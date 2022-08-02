<?php
session_start();
if (!isset($_SESSION["login_user"])) {
    header("location: index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    session_destroy();
    header("location: index.php");
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
    <style>
    #my_camera {
        width: 320px;
        height: 240px;
        border: 1px solid black;
    }
    </style>
    <title>Image Tracking System</title>
</head>

<body>

<?php require "layouts/navbar-sidebar.php"; ?>
    
    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center mb-2">Tracking Panel</h1>
                    <hr>

                    <div class="row">
                        <div class="col-6">
                            <div class="">
                                <div class="row g-3">
                                    <div class="col-3">
                                        <label for="" class="col-form-label">Barcode</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id='barcode'
                                            placeholder="enter barcode">

                                        <input type=button value="Submit" id="submitBtnId" class="btn btn-primary mt-1"
                                            onClick="saveSnap()">
                                    </div>

                                </div>

                                <div class="row g-3 align-items-center mt-3">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-3">
                                        <div id="my_camera"></div>
                                    </div>
                                </div>

                                <div class="row g-3 align-items-center">
                                    <div class="col-3">
                                    </div>

                                </div>

                                <div id="results"></div>


                            </div>
                        </div>
                        <div class="col-6">
                            <?php
                            if (isset($_SESSION["last_img"])) {
                                ?>
                            <p><b>Last Barcode: </b><?php echo $_SESSION["barcode"] ?></p>
                            <img src="<?php echo $_SESSION["last_img"] ?>" alt="" width="600" height="480">
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>


    <script type="text/javascript" src="webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script language="JavaScript">

    var input = document.getElementById("barcode");

    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            document.getElementById("submitBtnId").click();
        }
    });

    function configure() {
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#my_camera');
    }
    // A button for taking snaps

    configure();

    function take_snapshot() {

        // take snapshot and get image data
        Webcam.snap(function(data_uri) {
            // display results in page
            document.getElementById('results').innerHTML =
                '<img id="imageprev" src="' + data_uri + '"/>';
        });

        Webcam.reset();
    }

    function saveSnap() {
        take_snapshot();
        // Get base64 value from <img id='imageprev'> source
        var base64image = document.getElementById("imageprev").src;
        var barcode = document.getElementById("barcode").value;
        var url = 'upload.php?barcode=' + barcode;

        Webcam.upload(base64image, url, function(code, text) {
            console.log('Save successfully');
            console.log(text);
            location.reload();
        });

    }
    </script>

<?php
    require "footer.php";
    ?>

</body>

</html>