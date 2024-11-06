<?php
require_once './../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not Found", [], 404);
    exit();
}

extract($_POST);
$currentpassword = !isset($currentpassword) || trim($currentpassword) === "" ? "" : trim($currentpassword);
if($currentpassword === ""){
    echo res(false,"Enter Your Current Password",[],409);
    exit();
}
$newpassword = !isset($newpassword) || trim($newpassword) === "" ? "" : trim($newpassword);
if($newpassword === ""){
    echo res(false,"Enter Your New Password",[],409);
    exit();
}
require_once './../../db/db.php';
$conn = new DBConnect();
$cn = $conn->connectDB();

require_once "./../../controller/userscontroller.php";
$uc = new UsersController($cn);

require_once './../auth.php';

if ($userId !== "superadmin") {
    echo res(false, "Access Error", [], 402);
    exit();
}
$params = array(
    "oldpass" => $currentpassword,
    "newpass" => $newpassword,
    "userId" => $userId,
);
echo $uc->ChangePassword($params);