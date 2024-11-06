<?php
session_start();
include_once './db/conf.php';
$sessionuser = !isset($_SESSION['gbusername']) || trim($_SESSION['gbusername']) === "" ? "" : $_SESSION['gbusername'];
$sessiontoken = !isset($_SESSION['gbtoken']) || trim($_SESSION['gbtoken']) === "" ? "" : $_SESSION['gbtoken'];
$sessionuserrole = !isset($_SESSION['gbrole']) || trim($_SESSION['gbrole']) === "" ? "" : $_SESSION['gbrole'];

if ($sessionuser === "") {
    header("http/1.0 402 Autorization Faild");
    header("location:login.php");
    exit();
}
if ($sessiontoken === "") {
    header("http/1.0 402 Autorization Faild");
    header("location:login.php");
    exit();
}
if ($sessionuserrole === "") {
    header("http/1.0 402 Autorization Faild");
    header("location:login.php");
    exit();
}
//roles 
require_once './db/db.php';
$conn = new DBConnect();
$cn = $conn->connectDB();

require_once './controller/userscontroller.php';
$ucc = new UsersController($cn);
$xaccess = $ucc->UserAccess($sessionuser);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="description" content="POS - Bootstrap Admin Template" />
    <meta
        name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive" />
    <meta name="author" content="Dreamguys - Bootstrap Admin Template" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Star Mobile (DOFY)</title>

    <link
        rel="shortcut icon"
        type="image/x-icon"
        href="assets/img/favicon.jpg" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toatr.css">
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/js/node_modules/ng-hijri-gregorian-datepicker/dist/ng-hijri-gregorian-datepicker.css">

    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css" />

    <link
        rel="stylesheet"
        href="assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/angular-toastr.css">
    <style>
        .gridbtn {
            padding: 1px;
            display: flex;
            line-height: 1rem;
            height: 100%;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }
    </style>
</head>

<body ng-app="gbuddy">

    <div class="main-wrapper">
        <?php
        include_once './src/pageheader.php';
        include_once './src/sidebar.php';
        ?>
        <div class="page-wrapper pagehead" ng-view>


        </div>
    </div>

    <!-- <script src="assets/js/jquery-3.6.0.min.js"></script> -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <script src="assets/plugins/toastr/toastr.js"></script>
    <script src="assets/js/angular/angular.js"></script>
    <script src="assets/js/angular/angular-route.js"></script>
    <!-- for date time picker -->
    <script src="assets/js/node_modules/moment/moment.js"></script>
    <script src="assets/js/node_modules/moment/locale/ar-sa.js"></script>
    <script src="assets/js/node_modules/moment-hijri/moment-hijri.js"></script>
    <script src="assets/js/node_modules/ng-hijri-gregorian-datepicker/dist/ng-hijri-gregorian-datepicker.js"></script>
    <script src="assets/js/angular-animate.min.js"></script>
    <script src="assets/js/angular-toastr.tpls.js"></script>

    <!-- date time picker end -->
    <script src="assets/js/ism-grid.js"></script>
    <!-- <script src="assets/js/angular/angular.js" ></script> -->
    <!--
    <script src="assets/js/angular/angular-ui-router.js"></script> -->
    <script>
        const url = "<?php echo $url ?>";
        const api = "<?php echo $url ?>/api/";
        const m = "<?php echo $deployment ?>";
        const useraccess = <?php echo json_encode($xaccess) ?>;
        m === "0" ? console.log(useraccess?.homepagesummary ?? false) : "";
        const gbusername = "<?php echo $sessionuser ?>";
        const gbtoken = "<?php echo $sessiontoken ?>";
        const app = angular.module('gbuddy', ['ngRoute', 'ngHijriGregorianDatepicker', 'toastr']);
        // const app = angular.module("gp",[]);
        // console.log(app)



        function menuactive(currentmenu, submenu = "") {
            const _rm = ['dashboard_menu', 'product_menu', 'user_menu', 'changepassword_menu'];
            const _sub = ['model_submenu','condition_submenu','kitstatus_submenu','warranty_submenu','chargertype_submenu']
            _rm.map(i => {
                //m === '0' ? console.log(i) : "";
                const ele = document.getElementById(i);
                //m === '0' ? console.log(ele) : "";
                if(!ele){

                }else{
                    document.getElementById(i).classList.remove("active");
                }
            })
            _sub.map(i => {
                const ele = document.getElementById(i);
                if(!ele){
                }else{
                    document.getElementById(i).classList.remove("active");
                }
            })
            document.getElementById(currentmenu).classList.add("active");
            if (submenu !== "") {
                document.getElementById(submenu).classList.add("active");
            }
        }
    </script>
    
    <script src="./src/router.js"></script>

    <!-- initialize controllers -->
    <script type="module" src="./pages/home-page/dashboard.js"></script>
    <script type="module" src="./pages/users/index.js"></script>
    <script type="module" src="./pages/products/index.js"></script>
    <script type="module" src="./pages/conditions/index.js"></script>
    <script type="module" src="./pages/kitsatus/index.js"></script>
    <script type="module" src="./pages/warranty/index.js"></script>
    <script type="module" src="./pages/chargertypes/index.js"></script>
    <!-- initialize controllers -->

    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>