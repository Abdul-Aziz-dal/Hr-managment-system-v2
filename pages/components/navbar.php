<?php 
 if(!session_id())session_start();
require_once('../src/library/googleApi.config/config.php');
require_once("../src/library/googleApi.config/GoogleDriveUploadAPI.php");
$gdriveAPI = new GoogleDriveUploadAPI();
?>

<nav class="navbar navbar-expand navbar-light bg-custom topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link text-light d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown no-arrow mt-3">
    <?php 
                    if (!isset($_SESSION['access_token']) || empty($_SESSION['access_token'])) { 
                    ?>
                        <a class="btn btn-primary rounded-pill w-100" href="<?= $gOauthURL ?>">Sign in with Google</a>
                    <?php 
                    } 
                    ?>
                    </li>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-100 small"><b> Abdul Aziz</b></span>
                <img class="img-profile rounded-circle"
                    src="assets/img/profile.png">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">


                <a class="dropdown-item" id="logoutButton" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>