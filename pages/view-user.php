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
                            <h6 class="text-gray-800"><i class="fa fa-eye"></i> View User Details</h6>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <p style="font-size: 11px;" id="name"><b>Full Name:</b> </p>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <p style="font-size: 11px;" id="email"><b>Email:</b> </p>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <p style="font-size: 11px;" id="role"><b>Role:</b> </p>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <p style="font-size: 11px;" id="status"><b>Account Status:</b> </p>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <p style="font-size: 11px;" id="added"><b>Added On:</b> </p>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <p style="font-size: 11px;" id="updated"><b>Updated On:</b> </p>
                        </div>
                    </div>
                </div>


            </div>
            <!-- End Content -->

            <!-- Scripts -->
            <?php require_once 'components/scripts.php'; ?>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src='./assets/js/path.config.js'></script>

            <script>
                $(document).ready(function() {

                    const urlParams = new URLSearchParams(window.location.search);
                    const UserId = urlParams.get('UserId');

                    if (UserId) {
                        $.ajax({
                            url: baseURL+"/src/api/dashboard/get-user.php",
                            type: 'POST',
                            data: {
                                UserId: UserId
                            },
                            success: function(response) {
                                if (response.status == true) {
                                    $("#name").append(response.data.FullName)
                                    $("#email").append(response.data.Email)
                                    $("#role").append(response.data.Role == 'Admin' ? `<span class="badge badge-success bg-dark">${response.data.Role}</span>` : `<span class="badge badge-primary">${response.data.Role}</span>`)

                                    $("#status").append(response.data.Status == 1 ? '<span class="badge badge-success bg-success">Active</span>' : '<span class="badge badge-success bg-danger">Inactive</span>')
                                    $("#added").append(formatDate(response.data.AddedOn))
                                    $("#updated").append(formatDate(response.data.UpdatedOn))
                                } else {
                                    toastr.warning(response.message, 'Error');
                                }
                            },
                            error: function(response) {
                                toastr.error("Failed to fetch user details.", 'Error');

                            },
                        });
                    } else {
                        toastr.error("User ID is missing in the URL.", 'Error');
                    }

                });
            </script>


            <!-- Footer -->
            <?php require_once 'components/footer.php'; ?>