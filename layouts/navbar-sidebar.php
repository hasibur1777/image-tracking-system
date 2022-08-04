<style>
    body {
        background-color: #f7ede361;
    }

    ul {
        column-count: 3;
        column-gap: 1rem;
        list-style: none;
    }

    .color-black {
        color: black;
    }
</style>

<!-- top navigation bar -->
<nav class="navbar navbar-expand-lg navbar-white fixed-top" style="background-color: #bbded7">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold color-black" href="#">Image Tracking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavBar" aria-controls="topNavBar" aria-expanded="false" aria-label="Toggle navigation">
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
<div class="offcanvas offcanvas-start sidebar-nav" tabindex="-1" id="sidebar" style="background-color: #bbded7ab">
    <div class="offcanvas-body p-0">
        <nav class="navbar-white">
            <ul class="navbar-nav">
                <li>
                    <div class="text-muted small fw-bold text-uppercase px-3">
                    </div>
                </li>
                <li>
                    <a href="welcome.php" class="nav-link px-3 color-black">
                        <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="user.php" class="nav-link px-3 active color-black">
                        <span class="me-2"><i class="bi bi-person-fill"></i></span>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="panel_setup.php" class="nav-link px-3 color-black">
                        <span class="me-2"><i class="bi bi-camera-fill"></i></span>
                        <span>Track</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- offcanvas -->