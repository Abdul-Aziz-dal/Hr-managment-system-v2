<?php
session_start();
if (!isset($_SESSION['user'])) {

    header("Location: ../index.php");
}
require_once "../src/config/env.php";
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
                            <h6 class="text-gray-800"><i class="fa fa-users"></i> Users</h6>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <a href="create-user.php"><button class="btn btn-primary btn-sm offset-md-11"><i class="fa fa-plus"></i> Add User </button></a>
                            <table style="font-size: 12px;" id="table" class="table table-bordered">
                                <thead>
                                    <tr class="text-gray-800 " style="font-size:10px">
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role </th>
                                        <th>AddedOn</th>
                                        <th>Status</th>
                                        <th>Actions</th>
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
                            url: baseURL+"/src/api/dashboard/view-users.php",
                            type: "POST",
                            success: function(response) {
                                console.log(response);
                                if (response.status == true) {
                                    $("#table tbody").empty();

                                    response.data?.forEach(function(item) {
                                        var row = `<tr>
                                            <td>${item.FullName}</td>
                                            <td>${item.Email}</td>
                                             <td>${item.Role == 'Admin' ?  `<span class="badge badge-dark">${item.Role}</span>` : `<span class="badge badge-primary">${item.Role}</span>`    }</td>
                                            <td>${formatDate(item.AddedOn)}</td>
                                            <td>${item.Status == 1 ? '<span class="badge badge-success bg-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' }</td>

                                             <td>
                                                <a style="font-size:10px" href="view-user.php?UserId=${item.UserId}" class="btn  btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                                                <a style="font-size:10px" href="edit-user.php?UserId=${item.UserId}" class="btn  btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                                
                                                </td>
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