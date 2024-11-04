<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to MDB CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.8.0/mdb.min.css" rel="stylesheet">
    <!-- Link to Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
    .form-outline {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-outline input.form-control {
        border: 1px solid #ced4da;
        border-radius: .25rem;
        padding: .375rem .75rem;
    }

    .form-outline input.form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
    }

    .form-outline .form-label {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 1rem;
        transition: .2s ease-out;
        font-size: 1rem;
        padding: 0 .25rem;
        background-color: #fff;
        pointer-events: none;
    }

    .form-outline .form-control:focus~.form-label,
    .form-outline .form-control:not(:placeholder-shown)~.form-label {
        top: 0;
        transform: translateY(-100%);
        left: .75rem;
        font-size: .75rem;
        background-color: #f8f9fa;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        cursor: pointer;
    }

    #error-message {
        color: red;
        margin-top: .25rem;
        display: none;
    }
    </style>
</head>

<body>
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Sign in</h3>

                            <div class="alert alert-danger" role="alert" id="error-message" style="display: none;">
                                Invalid email or password
                            </div>

                            <form id="login-form" action="<?php echo _WEB_ROOT; ?>/user/checkLogin" method="post">

                                <div class="form-outline mb-4">
                                    <input type="text" id="email" name="email" class="form-control form-control-lg"
                                        required>
                                    <label class="form-label" for="email">Email</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password"
                                        class="form-control form-control-lg" required>
                                    <label class="form-label" for="password">Password</label>
                                    <i class="fas fa-eye password-toggle" id="toggle-password"></i>
                                </div>

                                <div class="mb-4">
                                    <span>Don't have an account? <a href="<?php echo _WEB_ROOT; ?>/auth/register">Sign
                                            Up</a></span>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>

                                <div id="error-message"></div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Link to MDB JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.8.0/mdb.min.js"></script>
    <!-- Custom JavaScript for Form Validation and Toggle Password Visibility -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('login-form');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const errorMessage = document.getElementById('error-message');
        const togglePassword = document.getElementById('toggle-password');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            console.log('Form submitted');

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('Response received:', xhr.responseText);
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            console.log('huhu');
                            errorMessage.innerText = response.message;
                            errorMessage.style
                                .display = 'block';
                        }
                    } catch (e) {
                        console.error('Response is not valid JSON:', xhr.responseText);
                        errorMessage.innerText = 'An error occurred, please try again.';
                        errorMessage.style.display = 'block';
                    }
                } else {
                    console.error('An error occurred during the request.');
                }
            };

            xhr.send(formData);
            console.log('Request sent');
        });

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
    </script>
</body>

</html>