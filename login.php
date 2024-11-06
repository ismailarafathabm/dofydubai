<?php
session_start();
include_once './db/conf.php';
//print_r($_SESSION);
//unset($_SESSION['gbusername']);
//echo $_SESSION['gbusername'];
if (isset($_SESSION['gbusername'])) {
?>
    <script>
        location.href = "<?php echo $url ?>index.php";
    </script>
<?php
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin panel,pos,grocery,billing software">
    <meta name="author" content="Ismailarafath">
    <meta name="robots" content="noindex, nofollow">
    <title>Login - GroceryBuddy</title>

    <link rel="shortcut icon" type="image/x-icon"
        href="assets/img/favicon.jpg">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet"
        href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet"
        href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <form class="login-userset" method="POST" action="<?php echo $url ?>login.php">
                        <div class="login-userset">
                            <div class="login-logo">
                                <img src="assets/img/logo.png" alt="img">
                            </div>
                            <div class="login-userheading">
                                <h3>Sign In</h3>
                                <h4>Please login to your account</h4>
                            </div>
                            <div class="form-login">
                                <label>User Name</label>
                                <div class="form-addons">
                                    <input type="text"
                                        placeholder="Enter your email address" name="loginuser" id="loginuser">
                                    <img src="assets/img/icons/mail.svg"
                                        alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input"
                                        placeholder="Enter your password" id="loginpassword" name="loginpassword">
                                    <span
                                        class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                            <div class="form-login">
                                <div class="alreadyuser">
                                    <h4><a href="forgetpassword.html"
                                            class="hover-a">Forgot
                                            Password?</a></h4>
                                </div>
                            </div>
                            <?php
                            if (isset($_POST['loginaction'])) {
                                //echo 'working';
                                //echo $_POST['loginuser'];
                                $isOkUsername = !isset($_POST['loginuser']) || trim($_POST['loginuser']) === ''  ? false : true;
                                if (!$isOkUsername) {
                                    header("location:login.php?msg=Enter User Name");
                                    exit();
                                }
                                $isOkpassword = !isset($_POST['loginpassword']) || trim($_POST['loginpassword']) === '' ? false : true;
                                if (!$isOkpassword) {
                                    header("location:login.php?msg=Enter Password");
                                    exit();
                                }
                                require_once 'db/db.php';
                                $conn = new DBConnect();
                                $cn = $conn->connectDB();

                                require_once './controller/userscontroller.php';
                                $uc = new UsersController($cn);
                                $loginaction = $uc->Login($_POST['loginuser'], $_POST['loginpassword']);
                                //print_r($loginaction);
                                $response = json_decode($loginaction);
                                if (!$response->isSuccess) {
                                    header("location:login.php?msg=" . $response->msg);
                                    exit();
                                }
                                //echo $response->data->userId;
                                $_SESSION['gbusername'] = $response->data->userId;
                                $_SESSION['gbtoken'] = $response->data->token;
                                $_SESSION['gbrole'] = $response->data->role;
                                header("location:index.php");
                                //print_r($_SESSION);
                                exit();
                            }
                            ?>
                            <div class="form-login">
                                <button name="loginaction" type="submit" class="btn btn-login">Sign
                                    In</button>
                            </div>
                            <?php
                            if (isset($_GET['msg']) && trim($_GET['msg']) !== "") {
                            ?>
                                <div class="signinform text-center">
                                    <h4 class="manitoryblue"><?php echo $_GET['msg'] ?></h4>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </form>
                </div>
                <div class="login-img">
                    <img src="assets/img/login.jpg" alt="img">
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>