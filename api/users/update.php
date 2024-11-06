<?php
require_once './../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not Found", [], 404);
    exit();
}

extract($_POST);
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
//print_r($_POST);

$userName = !isset($edit_userName) || trim($edit_userName) === "" ? '' : trim($edit_userName);
if ($userName === "") {
    echo res(false, "Enter user display Name", [], 409);
    exit();
}
$newuser = !isset($edit_userId) || trim($edit_userId) === "" ? '' : trim($edit_userId);
if ($newuser === "") {
    echo res(false, "Enter user ID", [], 409);
    exit();
}
$userPass = !isset($edit_userPass) || trim($edit_userPass) === "" ? '' : trim($edit_userPass);
if ($userPass === "") {
    echo res(false, "Enter Password", [], 409);
    exit();
}
$userStatus = !isset($edit_userStatus) || trim($edit_userStatus) === "" ? '' : trim($edit_userStatus);
if ($userPass === "") {
    echo res(false, "Enter Password", [], 409);
    exit();
}
$shopCode = !isset($edit_shopCode) || trim($edit_shopCode) === "" ? '' : trim($edit_shopCode);
if ($userPass === "") {
    echo res(false, "Enter Shop Code", [], 409);
    exit();
}

//echo $uc->enc('enc', $userPass);
$Iuser = array(
    ":userName" => $userName,
    ":userPass" => $uc->enc('enc', $userPass),
    ":userToken" => $uc->token(25) . "_" . $uc->enc('enc', $userId) . "_" . date('YmdHi'),
    ":userStatus" => $userStatus,
    ":userEby" => "superadmin",
    ":shopCode" => $shopCode,
    ":userId" => strtolower($newuser),
);

echo $uc->UpdateUserInfo($Iuser);

exit();
