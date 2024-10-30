<?php
session_start();
if (isset($_SESSION['userID'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.1-web/css/all.min.css">
    <link href="assets/img/logoSIT.png" rel="icon">
    <link rel="stylesheet" href="styles/loginpage.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 d-flex flex-column typing-effect">
                <div id="csta-logo">
                    <img src="assets/img/cstaLogo.png" alt="CSTA Logo">
                </div>
                <div id="csta-container">
                    <p id="csta-text"></p>
                </div>
                <p id="dynamic-text"></p>
            </div>
            <div class="col-md-5 d-flex justify-content-center align-items-center FormLogin">
                <div class="login-form">
                    <h2 class="text-primary">CSTA</h2>
                    <form method="POST" id="loginForm">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" disabled>
                                        <i class="fa fa-user fa-lg"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-lg" placeholder="Username" id="username" name="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" id="passwordGroup" type="button" disabled>
                                        <i class="fa fa-lock fa-lg"></i>
                                    </button>
                                </div>
                                <input type="password" class="form-control form-control-lg" placeholder="Password" id="password" name="password">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="errorMessage"></div>
                        <button type="submit" class="btn btn-primary btn-lg" id="loginBtn">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="scripts/loginpage.js"></script>

    <script src="jquery/dist/jquery.min.js"></script>
    <script>
        var username = '';
        var password = '';

        $(document).ready(function() {
            $('#loginForm').submit(function(e) {
                e.preventDefault();


                var username = $('#username').val().trim();
                var password = $('#password').val().trim();

                if (username === '' || password === '') {
                    alert('Please enter both username and password.');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'http://huntergramapp.space/validate_login.php',
                    dataType: 'json',
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = 'index.php';
                        } else {
                            $('#password').val("");
                            $('.errorMessage').text("Invalid username or password").css("color", "red");
                            setTimeout(function() {
                                $('.errorMessage').text("");
                            }, 1100);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error occurred while validating credentials. Please try again.');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('contextmenu', event => event.preventDefault());

        document.onkeydown = function(e) {
            if (e.key === "F12") {
                return false; // Disable F12
            }
        };
    </script>

</body>

</html>