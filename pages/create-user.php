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
                            <h6 class="text-gray-800"><i class="fa fa-plus"></i> Add New User</h6>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <form id="form" action="" method="POST">
                                <div class="form-group">
                                    <label class="form-label text-gray-800">Full Name <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="FullName" required placeholder="Enter full name..." />
                                </div>

                                <div class="form-group">
                                    <label class="form-label text-gray-800">Email Address <span class='text-danger'>*</span></label>
                                    <input type="email" class="form-control form-control-sm" name="Email" required placeholder="Enter email address..." />
                                    <p class="form-text text-success" style="font-size:10px">please provide valid email address</p>
                                </div>

                                <div class="form-group">
                                    <label class="form-label text-gray-800">Password <span class='text-danger'>*</span></label>
                                    <input type="password" class="form-control form-control-sm" name="Password" required placeholder="Enter password..." />
                                </div>

                                <div class="form-group">
                                    <label class="form-label text-gray-800">Role <span class='text-danger'>*</span></label>
                                    <select required name="RoleId" id="RoleId" class="form-select form-control-sm">

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="form-label text-gray-800">Account Status <span class='text-danger'>*</span></label>
                                    <select required name="Status" class="form-select form-control-sm">
                                        <option value="">Select Account Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 d-flex">
                                        <div class="offset-md-10">
                                            <a href="users.php" class="btn btn-sm btn-success">Back</a>
                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
            <!-- End Content -->

            <!-- Scripts -->
            <?php require_once 'components/scripts.php'; ?>
            <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

            <script>
                $(document).ready(function() {

                    getRoles();

                    function getRoles() {
                        $.ajax({
                            url: `http://localhost/hr-onboarding-system/src/api/dashboard/get-roles.php`,
                            type: 'POST',

                            success: function(response) {
                                if (response.status == true) {
                                    const roleSelect = $('#RoleId');
                                    roleSelect.empty();
                                    roleSelect.append('<option value="">Select Role</option>');
                                    response.data.forEach(role => {
                                        console.log("co")
                                        roleSelect.append(
                                            `<option value="${role.RoleId}">${role.RoleName}</option>`
                                        );
                                    });

                                } else {
                                    toastr.warning(response.message, 'Error');
                                }
                            },
                            error: function(response) {
                                toastr.error("Failed to fetch roles .", 'Error');

                            },
                        });
                    }

                    $.validator.addMethod(
                        "regex",
                        function(value, element, regexp) {
                            var re = new RegExp(regexp);
                            return this.optional(element) || re.test(value);
                        },
                        "Please enter a valid value."
                    );
                    // Initialize form validation
                    $("#form").validate({
                        rules: {
                            FullName: {
                                required: true,
                                regex: /^[a-zA-Z \s]+$/,
                            },
                        },
                        messages: {
                            FullName: {
                                required: "Please provide a full name.",
                                pattern: "Full name should only contain alphabetic characters and spaces.",
                            },
                        },
                        submitHandler: function(form) {
                            $.ajax({
                                url: 'http://localhost/hr-onboarding-system/src/api/dashboard/create-user.php',
                                type: 'POST',
                                data: $(form).serialize(),
                                success: function(response) {
                                    if (response.status == true) {
                                        toastr.success(response.message, 'Success');
                                        setTimeout(function() {
                                            window.location.href = 'http://localhost/hr-onboarding-system/pages/users.php';
                                        }, 500);
                                    } else {
                                        toastr.warning(response.message, 'Error');
                                    }
                                },
                                error: function(response) {
                                    if (response.responseJSON.status == false) {
                                        toastr.error(response.responseJSON.message || "", 'Error');
                                    } else {
                                        toastr.error("Something went wrong!", 'Error');
                                    }
                                },
                            });
                        },
                    });
                });
            </script>


            <!-- Footer -->
            <?php require_once 'components/footer.php'; ?>