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
                            <h6 class="text-gray-800"><i class="fa fa-file"></i> Upload Employee Document</h6>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <form id="form" action="" method="POST">
                            

                                <div class="form-group">
                                    <label class="form-label text-gray-800"> Employee <span class='text-danger'>*</span></label>
                                    <select required name="EmployeeId" id="EmployeeId" class="form-select form-control-sm">
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="file" class='form form-control' name="file" id="file" />
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

                    try {

                        getEmployeesList();

function getEmployeesList() {
    $.ajax({
        url: `http://localhost/hr-onboarding-system/src/api/dashboard/get-employees-list.php`,
        type: 'POST',
        success: function(response) {
            if (response.status == true) {
                const dataSelect = $('#EmployeeId');
                dataSelect.empty();
                dataSelect.append('<option value="">Select Employee</option>');
                response.data.forEach(emp => {
                    console.log("co")
                    dataSelect.append(
                        `<option value="${emp.EmployeeId}">${emp.EmployeeName}</option>`
                    );
                });
            } else {
                toastr.warning(response.message, 'Error');
            }
        },
        error: function(response) {
            toastr.error("Failed to fetch employee details.", 'Error');

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
    submitHandler: function(form) {
        // let formData = new FormData(form);
        // // let employeeId = $("#EmployeesList").val(); 
        // formData.append("EmployeeId", employeeId);
        var formData = new FormData(form);

        $.ajax({
            url: 'http://localhost/hr-onboarding-system/src/api/dashboard/employee-document-upload.php',
            type: 'POST',
            data: formData,
            processData: false, // Important for file uploads
            contentType: false, // Important for file uploads
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
                        
                    } catch (err) {
                        console.log(err.message)
                    }
               
                });
            </script>


            <!-- Footer -->
            <?php require_once 'components/footer.php'; ?>