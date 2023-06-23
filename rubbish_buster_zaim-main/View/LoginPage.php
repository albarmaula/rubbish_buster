<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="path/to/your/font-awesome-folder/js/all.min.js"></script>

    <title>Login</title>
<style>
    
    body{
        background-color: #41644A;
        font-family: 'Montserrat';
        overflow: hidden;
        margin: 0;
        padding: 0;
    }
    h1{
        color: #41644A;
        font-size: 40px;
        font-style: normal;
        font-weight: 700;
        
    }h2{
        color: #41644A;
        font-size: 40px;
        font-style: normal;
        font-weight: 500;
    }
    label{
        color: #41644A;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
    }
    p{
        color: #41644A;
        font-size: 15px;
        font-style: normal;
        font-weight: 700;
    }
    input[type=text],
    input[type=password] {
        font-size: 15px;
        font-style: normal;
        font-weight: 700;
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        border: none;
        background-color: #D9D9D9;
        color: #41644A;
        border-bottom: 2px solid #41644A;
    }
    .password-container {
        position: relative;
    }
    .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }
    .password-toggle i {
        color: #41644A;
    }
    
    .submit-container {
        text-align: center;
    }
    input[type=submit] {
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
        width: 426px;
        height: 69px;
        background-color: #41644A;
        color: #D9D9D9;
        border-radius: 30px;
        border-color: transparent; /* Update border-color */
        padding: 12px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type=submit]:hover {
        color: #41644A;
        background-color: #D9D9D9;
        border-color: #41644A;
    }

    *{
    box-sizing: border-box;
    }

    /* Create a container with full height */
    .container {
        display: flex;
        height: 100vh;
    }

    /* Create a row to contain columns */
    .row {
        display: flex;
        flex: 1;
    }

    /* Adjust z-index */
    .column {
        position: relative;
        flex: 0 0 40%; /* Adjust the width of the left column */
        padding: 110px;
        padding-top: 0px;
        z-index: 2;
    }

    .right-column {
        flex: 0 0 60%; /* Adjust the width of the right column */
        background-color: #D9D9D9;
        padding: 140px;
        padding-top: 0px;
        margin-left: 50px;
        border-radius: 50px;
        z-index: 1;
    }

    .error-message {
        color: red;
        font-size: 16px;
        margin-top: 5px;
    }
    .error-field {
        border-bottom-color: red;
    }
    .image-container {
        position: absolute; 
        margin-left: -110px;
    }
    .login-section {
        text-align: center;
        color: #41644A;
        font-size: 16px;
    }
    
    .login-section a {
        color: #41644A;
        text-decoration: underline;
    }
    </style>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="column" style="background-color:#41644A;">
                <div class="image-container">
                    <img src="../bg_login.png" alt="Image" style="width: 630px; height: 670px;">
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
                <?php if (isset($errors) && !empty($errors) && in_array("Your password is wrong", $errors)) {
                        echo '<span class="error-message">Your password is wrong</span>';
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