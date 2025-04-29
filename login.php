<link rel="stylesheet" href="assets/css/popup_style.css"> 
           <style>
.footer1 {
  position: fixed;
  bottom: 0;
  width: 100%;
  color: #5c4ac7;
  text-align: center;
}

</style>
<?php
include('./constant/layout/head.php');
include('./constant/connect.php');
session_start();

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        if ($email == "") $errors[] = "Email is required";
        if ($password == "") $errors[] = "Password is required";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $connect->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['userId'] = $user['user_id'];
                ?>

                <div class="popup popup--icon -success js_success-popup popup--visible">
                    <div class="popup__background"></div>
                    <div class="popup__content">
                        <h3 class="popup__content__title">Success</h3>
                        <p>Login Successfully</p>
                        <p><?php echo "<script>setTimeout(\"location.href = 'dashboard.php';\",1500);</script>"; ?></p>
                    </div>
                </div>

                <?php
            } else {
                showLoginError("Incorrect email/password combination");
            }
        } else {
            showLoginError("Email does not exist");
        }
    }
}

function showLoginError($message) {
    ?>
    <div class="popup popup--icon -error js_error-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">Error</h3>
            <p><?php echo $message; ?></p>
            <p><a href="login.php"><button class="button button--error">Close</button></a></p>
        </div>
    </div>
    <?php
}
?>
    
    <div id="main-wrapper">
        <div class="unix-login">

            <div class="container-fluid" style="background-image: url('assets/uploadImage/Logo/banner3.jpg');
 background-color: #ffffff;background-size:cover">
                <div class="row ">
                    <div class="col-md-4">
                        <div class="login-content ">
                            <div class="login-form">
                                <center><img src="./assets/uploadImage/Logo/logo.png" style="width: 300px;"></center><br>
                                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="loginForm" class="row">
                                    <div class="form-group col-md-12">
                                        <label lass="col-sm-3 control-label">email</label>
                                        <input type="text" name="email" id="email" class="form-control" placeholder="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address"required="">
     
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Password</label>
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>

                                    </div>
                                    
                                        <div class="col-md-6 form-check">
                                            <input type="checkbox" class="pl-3" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                        </div>
                                        <div class="forgot-phone col-md-6 text-right">
                                            <a href="#" class="text-right f-w-600 text-gray"> Forgot Password?</a>
                                        </div>
                                 
                                   <div class="col-md-12"> 
                                       <button style="background-color: #102b49; border-radius: 50px;" type="submit" name="login" class=" f-w-600 text-white btn  btn-flat m-b-30 m-t-30">Sign in</button>
                                   </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><center>
 
            
            </footer> </center>
    </div>
    
    
    
    
    <script src="./assets/js/lib/jquery/jquery.min.js"></script>
    
    <script src="./assets/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="./assets/js/lib/bootstrap/js/bootstrap.min.js"></script>
    
    <script src="./assets/js/jquery.slimscroll.js"></script>
    
    <script src="./assets/js/sidebarmenu.js"></script>
    
    <script src="./assets/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    
    <script src="./assets/js/custom.min.js"></script>
</body>

</html>
