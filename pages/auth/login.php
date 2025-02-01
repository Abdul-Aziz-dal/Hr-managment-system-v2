<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: ../../index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginForm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            background: lightgray;
        }

        .text-custom {
            color: #0A264C;
        }

        .bg-custom {
            background-color: #0A264C;

        }

        label.error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            width: 100%;
            font-size: 10px;
            font-weight: 400;
            margin-top: 5px;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
    </style>
</head>

<body>

    <div class="container-fluid d-flex align-items-center justify-content-center " style="min-height: 100vh;">


        <div class="row w-100">

            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12  d-flex align-items-center justify-content-center ">
                <div class="card border-primary-down shadow-sm bg-white"
                    style="margin:auto;width:30% ;display: flex; flex-direction: column;border-top:5px solid #0A264C">


                    <div class="card-body p-2 m-5" style="flex: 1;">
                        <div class="row">

                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                <div class="text-center">
                                    <img class="m-2" src="../assets/img/building.png" style="width:20%" />

                                    <h5 class="text-center m-1 text-custom" style="font-size:20px">
                                        HR ONBOARDING SYSTEM
                                    </h5>

                                    <p class="form-text" style="font-size:12px">Please login to ignite the system</p>
                                </div>

                                <form id="LoginForm" action="" method="POST">

                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <div class="form-group">

                                                <input type="email" name="email" class="form-control form-control-sm"
                                                    placeholder="Email Address" />
                                                <p class="form-text text-success" style="font-size:11px">please provide
                                                    registered email
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <div class="form-group">

                                                <input type="password" name="password" class="form-control form-control-sm"
                                                    placeholder="Password" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 d-flex justify-content-center">
                                            <a href="" class="text-custom "
                                                style="font-size:11px;margin-left:1px">Forget
                                                Password?</a>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 d-flex justify-content-center">
                                            <button type="submit" class="btn bg-custom text-white"
                                                style="font-size: 11px;">
                                                Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer bg-custom p-0 d-flex align-items-center justify-content-center"
                        style="min-height: 30px;">
                        <p class="mb-0 text-light" style="font-size:12px">&copy; <?php echo date('Y-m-d') ?> - <a
                                href="#" class="text-light">Abdul Aziz</a> - All rights
                            reserved.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src='../assets/js/path.config.js'></script>

    <script>
        $(document).ready(function() {
            // Initialize form validation
            $("#LoginForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: "Please provide your email.",
                        email: "Please enter a valid email address."
                    },
                    password: {
                        required: "Please provide your password.",
                        minlength: "Your password must be at least 6 characters long."
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: baseURL+"/src/api/auth/login.php",
                        type: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {

                            if (response.status == true) {
                                toastr.success(response.message, 'Success');

                                setTimeout(function() {
                                    window.location.href = baseURL+"/";
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

                        }
                    });
                }
            });
        });
    </script>
</body>

</html>