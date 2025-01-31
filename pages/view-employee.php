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
                            <h6 class="text-gray-800"><i class="fa fa-eye"></i> View Employee Details</h6>
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
                            <p style="font-size: 11px;" id="department"><b>Department :</b> </p>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <p style="font-size: 11px;" id="manager"><b>Manager:</b> </p>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <p style="font-size: 11px;" id="status"><b>Status:</b> </p>
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

                <div class="row mb-2">
                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2">
                            <h6 class="text-gray-800"><i class="fa fa-eye"></i> View Employee Documents</h6>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                        <div class="card bg-white shadow py-2 p-2" id="documentsList">

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

                                    $("#email").append(response.data.EmployeeEmail)

                                    $("#name").append(response.data.EmployeeName)
                                    $("#department").append(response.data.Department)
                                    $("#manager").append(response.data.Manager)

                                    $("#status").append(response.data.Status == 1 ? '<span class="badge badge-success bg-success">Active</span>' : '<span class="badge badge-success bg-danger">Probhation</span>')
                                    $("#added").append(formatDate(response.data.AddedOn))
                                    $("#updated").append(formatDate(response.data.UpdatedOn))

                                    const documents = response.documents;
                                    let docs = "";
                                    if (documents?.length > 0) {
                                        documents.forEach((value) => {
                                            let fileUrlView = `https://drive.google.com/file/d/${value.DocumentReferenceId}/view`;
                                            let fileUrlDownload = `https://drive.usercontent.google.com/u/0/uc?id=${value.DocumentReferenceId}&export=download`;

                                            docs += `
                                                <div class="d-flex align-items-center justify-content-between border p-2 mb-2 rounded">
                                                    <span class="text-dark fw-bold">${value.DocumentName}</span>
                                                    <div>
                                                        <a target="_blank" href="${fileUrlView}" class="btn btn-sm btn-primary mx-1" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="${fileUrlDownload}" class="btn btn-sm btn-success mx-1" title="Download">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                    } else {
                                        docs = `
                                            <div class="text-center text-muted">
                                                <i class="fa fa-exclamation-circle fa-2x"></i>
                                                <p class="mt-2">No documents found</p>
                                            </div>
                                        `;
                                    }
                                    
                                    $("#documentsList").html(docs);

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

                });
            </script>


            <!-- Footer -->
            <?php require_once 'components/footer.php'; ?>