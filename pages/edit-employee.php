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
                            <h6 class="text-gray-800"><i class="fa fa-edit"></i> Edit Employee Details</h6>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <form id="form" action="" method="POST">
                                <div class="form-group">
                                    <label class="form-label text-gray-800">Employee Name <span class='text-danger'>*</span></label>
                                    <input type="text" class="form-control form-control-sm" name="EmployeeName" required placeholder="Enter Employee Name..." />
                                    <input type="hidden" required class="form-control form-control-sm" name="EmployeeId" value="<?php echo $_GET['EmployeeId'] ?>" />
                                </div>


                                <div class="form-group">
                                    <label class="form-label text-gray-800"> Status <span class='text-danger'>*</span></label>
                                    <select required name="Status" class="form-select form-control-sm">
                                        <option value="">Select Employee Status</option>
                                        <option value="2">Probhation</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary offset-md-11">Save</button>
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

                    const urlParams = new URLSearchParams(window.location.search);
                    const employeeId = urlParams.get('EmployeeId');

                    if (employeeId) {
                        $.ajax({
                            url: `http://localhost/hr-onboarding-system/src/api/dashboard/get-employee.php`,
                            type: 'POST',
                            data: {
                                EmployeeId: employeeId
                            },
                            success: function(response) {
                                if (response.status == true) {
                                    console.log(response);
                                    $('#EmployeeName').val(response.data.EmployeeName);
                                    $('input[name="EmployeeName"]').val(response.data.EmployeeName);
                                    $('select[name="Status"]').val(response.data.Status);
                                } else {
                                    toastr.warning(response.message, 'Error');
                                }
                            },
                            error: function(response) {
                                toastr.error("Failed to fetch employee details.", 'Error');

                            },
                        });
                    } else {
                        toastr.error("Employee ID is missing in the URL.", 'Error');
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
                            EmployeeName: {
                                required: true,
                                regex: /^[a-zA-Z\s]+$/,
                            },
                        },
                        messages: {
                            EmployeeName: {
                                required: "Please provide a department name.",
                                pattern: "EmployeeName name should only contain alphabetic characters and spaces.",
                            },
                        },
                        submitHandler: function(form) {
                            $.ajax({
                                url: 'http://localhost/hr-onboarding-system/src/api/dashboard/edit-employee.php',
                                type: 'POST',
                                data: $(form).serialize(),
                                success: function(response) {
                                    if (response.status == true) {
                                        toastr.success(response.message, 'Success');
                                        setTimeout(function() {
                                            window.location.href = 'http://localhost/hr-onboarding-system/pages/employees.php';
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