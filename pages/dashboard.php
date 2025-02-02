<?php
session_start();
if (!isset($_SESSION['user'])) {

    header("Location: ../index.php");
}

?>
<!-- Config -->
<?php require_once '../src/config/baseviewpath.php';  ?>

<!-- Header -->
<?php require_once 'components/header.php'; ?>


<div id="wrapper">
    <?php require_once 'components/sidebar.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <?php require_once 'components/navbar.php'; ?>

            <!-- Content -->
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <h5 class="text-gray-800"><i class="fa fa-tachometer-alt"></i> Dashboard</h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <a style="text-decoration: none">
                            <div class="card border-left-dark  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 p-2">
                                            <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">
                                                Dashboard
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-800"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <a style="text-decoration: none">
                            <div class="card border-left-dark  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 p-2">
                                            <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">
                                                Total Departments
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="departments">2</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-800"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <a style="text-decoration: none">
                            <div class="card border-left-dark  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 p-2">
                                            <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">
                                                Total Employees
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="employees"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-address-book fa-2x text-gray-800"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <a style="text-decoration: none">
                            <div class="card border-left-dark  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 p-2">
                                            <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">
                                                Total User Roles 
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="roles"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-800"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <a style="text-decoration: none">
                            <div class="card border-left-dark  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 p-2">
                                            <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">
                                                Total System Users
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="users"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-users fa-2x text-gray-800"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <a style="text-decoration: none">
                            <div class="card border-left-dark  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 p-2">
                                            <div class="text-xs font-weight-bold text-gray-800 text-uppercase mb-1">
                                                Total Permenant Empolyees
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="employeesPermenant"></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa fa-address-card fa-2x text-gray-800"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>


            </div>
            <!-- End Content -->

            <!-- Scripts -->
            <?php require_once 'components/scripts.php'; ?>
            <script src='./assets/js/path.config.js'></script>

                <script>
                    $(document).ready(function() {

                loadData();

                function loadData() {

                    $.ajax({
                        url: baseURL+"/src/api/dashboard/view-count.php",
                        type: "POST",
                        success: function(response) {
                            if (response.status == true) {

                                $("#roles").html(response.roles[0].count)
                                $("#employees").html(response.employees[0].count)
                                $("#departments").html(response.department[0].count)
                                $("#employeesPermenant").html(response.employeesPermenant[0].count)
                                $("#users").html(response.users[0].count)                               
                            } else {
                                toastr.warning(response.message, 'Error');
                            }

                        },
                        error: function(response) {
                            toastr.warning(response.responseJSON.message, 'Error');

                        }
                    });


                }
                });


  </script>
            <!-- Footer -->
            <?php require_once 'components/footer.php'; ?>