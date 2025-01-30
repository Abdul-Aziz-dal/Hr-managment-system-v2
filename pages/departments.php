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
                            <h6 class="text-gray-800"><i class="fa fa-building"></i> Departments</h6>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <a href="create-department.php"><button class="btn btn-primary btn-sm offset-md-10"><i class="fa fa-plus"></i> Add Department </button></a>
                            <table style="font-size: 12px;" id="table" class="table table-bordered">
                                <thead>
                                    <tr class="text-gray-800 " style="font-size:10px">
                                        <th>Department Name</th>
                                        <th>Added On</th>
                                        <th>Updated On </th>
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

            <script>
                $(document).ready(function() {

                    loadData();

                    function loadData() {

                        $.ajax({
                            url: "http://localhost/hr-onboarding-system/src/api/dashboard/view-departments.php",
                            type: "POST",
                            success: function(response) {
                                console.log(response);
                                if (response.status == true) {
                                    $("#table tbody").empty();

                                    response.data?.forEach(function(department) {
                                        var row = `<tr>
                                            <td>${department.DepartmentName}</td>
                                            <td>${formatDate(department.AddedOn)}</td>
                                            <td>${formatDate(department.UpdatedOn)}</td>
                                             <td>
                                                <a style="font-size:10px" href="edit-department.php?DepartmentId=${department.DepartmentId}" class="btn  btn-sm btn-success"><i class="fa fa-edit"></i></a>
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