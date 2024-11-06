<?php
require_once '../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not found", [], 404);
    exit();
}


extract($_POST);
$warranty = !isset($warranty) || trim($warranty) === "" ? "" : trim($warranty);
if ($warranty === "") {
    echo res(false, "Enter Device Warrany Informations", [], 409);
    exit;
}

require_once './../../db/db.php';
$conn = new DBConnect();
$cn = $conn->connectDB();

require_once "./../../controller/userscontroller.php";
$uc = new UsersController($cn);

require_once './../auth.php';
$useraccess = $uc->UserAccess($userId);
$havPermission = !isset($useraccess['devicesettings']['warranty']['new']) ? false : $useraccess['devicesettings']['warranty']['new'];
if(!$havPermission){
    echo res(false,"You Do not have Permission to Add New Device Warranty ",[],401);
    exit;
}
require_once './../../controller/devicewarrantycontroller.php';
$prcc = new DeviceWarrantyController($cn);
echo (string)$prcc->SaveAction($warranty);
exit;
