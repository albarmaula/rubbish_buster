<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="path/to/your/font-awesome-folder/js/all.min.js"></script>
    <link rel="stylesheet" href="../css/stylelogin.css">
</head>
<body>
<div class="container">
        <div class="row">
            <div class="column" style="background-color:#41644A;">
                <div class="image-container">
                    <img src="../image/bg_login.png" alt="Image" style="width: 630px; height: 670px;">
                </div>
            
            </div>


            <div class="column right-column" style="background-color: #D9D9D9;">
            <br>
            <h2><center>Hello there, <br> Welcome back!</center></h2>
            <h1><center>Login</center></h1>
            
            <?php
            // Display error message if it exists
            if (isset($_GET['error'])) {
                $errorMessage = $_GET['error'];
                echo '<p style="color: red;">' . $errorMessage . '</p>';
            }
            ?>
            
            <form method="POST" action="../Controller/UserController.php?action=login">
                
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                <?php if (isset($errors) && !empty($errors) && in_array("Email does not exist", $errors)) {
                    echo '<span class="error-message">Email does not exist</span>';
                }?><br>

                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <span class="password-toggle" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
                </div>
                <?php if (isset($errors) && !empty($errors) && in_array("Invalid password", $errors)) {
                        echo '<span class="error-message">Invalid password</span>';
                    } ?>
                <br><br>
                <div class="submit-container">
                    <input type="submit" value="Login">
                </div>
                <div class="login-section">
                    <p>Don't have account? <a href='../View/RegisterPage.php';>Register</a></p>
                </div>
            </form>
            </div>
        </div>
    </div> 
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var passwordToggle = document.querySelector(".password-toggle");
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                passwordInput.type = "password";
                passwordToggle.innerHTML = '<i class="fa fa-eye"></i>';
            }
        }
    </script>
</body>
</html>