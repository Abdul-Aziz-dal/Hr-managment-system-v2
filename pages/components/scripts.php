<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Bootstrap core JavaScript-->
<script src="<?php echo $basePath ?>/pages/assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo $basePath ?>/pages/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?php echo $basePath ?>/pages/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?php echo $basePath ?>/pages/assets/js/sb-admin-2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script>
<script>
    function formatDate(dateString) {
        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };
        const date = new Date(dateString);
        return date.toLocaleString('en-US', options);
    }
    $(document).ready(function() {

        $("#logoutButton").on('click', function() {
            $.ajax({
                url: "http://localhost/hr-onboarding-system/src/api/auth/logout.php",
                type: "POST",
                success: function(response) {
                    console.log(response);
                    if (response.status == true) {
                        toastr.success(response.message, 'Success');
                        setTimeout(function() {
                            window.location.href = 'http://localhost/hr-onboarding-system/';
                        }, 500);
                    } else {
                        toastr.warning(response.message, 'Error');

                    }

                },
                error: function(response) {
                    toastr.warning(response.responseJSON.message, 'Error');

                }
            });
        })
    });
</script>