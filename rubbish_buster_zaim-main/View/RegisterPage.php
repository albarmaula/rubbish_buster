<!DOCTYPE html>
<html>
<head>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="path/to/your/font-awesome-folder/js/all.min.js"></script>

    <title>Register</title>
<style>
    
    body{
        background-color: #3C6255;
        font-family: 'Montserrat';
        overflow: hidden;
        margin: 0;
        padding: 0;
    }
    h1{
        color: white;
        font-size: 46px;
        font-style: normal;
        font-weight: 700;
    }
    label{
        color: white;
        font-size: 20px;
        font-style: normal;
        font-weight: 700;
    }
    p{
        color: white;
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
        background-color: #61876E;
        color: white;
        border-bottom: 2px solid white;
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
        color: white;
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
        background-color: white;
        color: #3C6255;
        border-radius: 30px;
        border-color: transparent; /* Update border-color */
        padding: 12px 20px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type=submit]:hover {
        color: white;
        background-color: #3C6255;
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
        flex: 1;
        padding: 110px;
        padding-top: 0px;
        z-index: 1;
    }
    .error-message {
        color: pink;
        font-size: 16px;
        margin-top: 5px;
    }
    .error-field {
        border-bottom-color: red;
    }
    .image-container {
        position: absolute; 
        right: 26px; 
        z-index: 2;
    }
    .login-section {
        text-align: center;
        color: white;
        font-size: 16px;
    }
    
    .login-section a {
        color: white;
        text-decoration: underline;
    }
    </style>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="column" style="background-color:#61876E;">
            <br><br>
            <h1><center>Create an account</center></h1><br>
            
            <form method="POST" action="../Controller/UserController.php?action=register">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                <?php if (isset($errors) && !empty($errors) && in_array("Username already exists", $errors)){
                    echo '<span class="error-message">Username already exists</span>';
                } ?><br>
                
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                <?php if (isset($errors) && !empty($errors) && in_array("Invalid email format", $errors)) {
                    echo '<span class="error-message">Invalid format</span>';
                }else if (isset($errors) && !empty($errors) && in_array("Email already exists", $errors)){
                    echo '<span class="error-message">Email already exists</span>';
                } ?><br>

                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" required>
                    <span class="password-toggle" onclick="togglePasswordVisibility()"><i class="fa fa-eye"></i></span>
                </div>
                <?php if (isset($errors) && !empty($errors) && in_array("Invalid password format", $errors)) {
                        echo '<span class="error-message">Password must contain at least 6 characters and 1 uppercase</span>';
                    }?>
                <br><br><br>
                <div class="submit-container">
                    <input type="submit" value="Register">
                </div>
                <div class="login-section">
                    <p>Already have an account? <a href='../View/LoginPage.php';>Login</a></p>
                </div>
            </form>
            </div>
            <div class="column">
                <div class="image-container">
                    <img src="../bg_regis.png" alt="Image" style="width:615.61px; height: 683px;">
                </div>
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