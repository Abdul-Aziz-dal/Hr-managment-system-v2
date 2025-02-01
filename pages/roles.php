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
                            <h6 class="text-gray-800"><i class="fa fa-user-lock"></i> User Roles</h6>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <table style="font-size: 12px;" id="table" class="table table-bordered">
                                <thead>
                                    <tr class="text-gray-800 " style="font-size:10px">
                                        <th>Role Name</th>
                                        <th>Role Permissions</th>
                                        <th>AddedOn</th>
                                        <th>UpdatedOn</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
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
                            url: baseURL+"/src/api/dashboard/view-roles.php",
                            type: "POST",
                            success: function(response) {
                                console.log(response);
                                if (response.status == true) {
                                    $("#table tbody").empty();

                                    response.data?.forEach(function(item) {
                                        var row = `<tr>
                                            <td>${item.RoleName}</td>
                                            <td>${item.RolePermissions}</td>
                                            <td>${formatDate(item.AddedOn)}</td>
                                            <td>${formatDate(item.UpdatedOn)}</td>

                                        </tr>`;
                                        $("#table tbody").append(row);
                                    });

                                    $("#table").DataTable();
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