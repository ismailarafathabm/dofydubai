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

$userName = !isset($userName) || trim($userName) === "" ? '' : trim($userName);
if ($userName === "") {
    echo res(false, "Enter user display Name", [], 409);
    exit();
}
$newuser = !isset($newuser) || trim($newuser) === "" ? '' : trim($newuser);
if ($newuser === "") {
    echo res(false, "Enter user ID", [], 409);
    exit();
}
$userPass = !isset($userPass) || trim($userPass) === "" ? '' : trim($userPass);
if ($userPass === "") {
    echo res(false, "Enter Password", [], 409);
    exit();
}
$useraccess = !isset($useraccess) || trim($useraccess) === "" ? '' : trim($useraccess);
if ($useraccess === "") {
    echo res(false, "User Access Missing", [], 409);
    exit();
}
$shopCode = !isset($shopCode) || trim($shopCode) === "" ? "" : trim($shopCode);
if($shopCode){
    echo res(false,"Select Shop Code",[],409);
    exit;
}
$acparams = array(

    ":userId" => strtolower($newuser),
    ":useraccess" => $useraccess
);
$Iuser = array(
    ":userName" => $userName,
    ":userId" => strtolower($newuser),
    ":userPass" => $uc->enc('enc', $userPass),
    ":userToken" => $uc->token(25) . "_" . $uc->enc('enc', $userId) . "_" . date('YmdHi'),
    ":userIp" => getenv("REMOTE_ADDR"),
    ":userLastLogin" => date('Y-m-d H:i:s'),
    ":userType" => "1",
    ":userStatus" => 1,
    ":userCby" => "superadmin",
    ":userEby" => "superadmin",
    ":userRole" => "1",
    ":shopCode" => $shopCode
);

echo $uc->SaveNewUser($Iuser, $acparams);

exit();
