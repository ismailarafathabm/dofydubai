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

$updateuserId = !isset($updateuserId) || trim($updateuserId) === "" ? "" : trim($updateuserId);
$useraccess = !isset($useraccess) || trim($useraccess) === "" ? "" : trim($useraccess);
if($updateuserId === ""){
    echo res(false,"User Id Missing",[],409);
    exit();
}
if($useraccess === ""){
    echo res(false,"User Access Missing",[],409);
    exit();
}
$Iupdate = array(
    ":useraccess" => $useraccess,
    ":userId" => $updateuserId
);
echo $uc->UpdateUserAccess($Iupdate);
exit();
