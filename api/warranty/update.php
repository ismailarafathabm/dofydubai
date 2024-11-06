<?php
require_once '../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not found", [], 404);
    exit();
}


$id = !isset($_GET['id']) || trim($_GET["id"]) === "" ? "" : trim($_GET['id']);
if($id === ""){
    echo res(false,"Id missing",[],409);
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
$havPermission = !isset($useraccess['devicesettings']['warranty']['edit']) ? false : $useraccess['devicesettings']['warranty']['edit'];
if(!$havPermission){
    echo res(false,"You Do not have Permission to Edit Device Warranty info",[],401);
    exit;
}
require_once './../../controller/devicewarrantycontroller.php';
$prcc = new DeviceWarrantyController($cn);
$params = array(
    ":warranty" => $warranty,
    ":id" => $id,
);
echo (string)$prcc->UpdateAction($params);
exit;
