<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="path/to/your/font-awesome-folder/js/all.min.js"></script>
    <link rel="stylesheet" href="../css/styleregister.css">
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
                    <img src='../image/bg_regis.png' alt="Image" style="width:615.61px; height: 683px;">
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