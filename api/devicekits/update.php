<?php
require_once '../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not found", [], 404);
    exit();
}

require_once './../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not Found", [], 404);
    exit();
}
$id = !isset($_GET['id']) || trim($_GET['id']) === "" ? "" : trim($_GET['id']);
if($id === ""){
    echo res(false, "Id Missing", [], 409);
    exit;
}
extract($_POST);
$kitCode = !isset($kitCode) || trim($kitCode) === "" ? "" : trim($kitCode);
if ($kitCode === "") {
    echo res(false, "Enter Kit status code", [], 409);
    exit;
}
$kitType = !isset($kitType) || trim($kitType) === "" ? "" : trim($kitType);
if ($kitType === "") {
    echo res(false, "Enter Kit status Description", [], 409);
    exit;
}

require_once './../../db/db.php';
$conn = new DBConnect();
$cn = $conn->connectDB();

require_once "./../../controller/userscontroller.php";
$uc = new UsersController($cn);

require_once './../auth.php';

$useraccess = $uc->UserAccess($userId);
$havPermission = !isset($useraccess['devicesettings']['kitstatus']['edit']) ? false : $useraccess['devicesettings']['kitstatus']['edit'];
if(!$havPermission){
    echo res(false,"You Do not have Permission to Edit Device Kits",[],401);
    exit;
}

$param = array(
    ":kitCode" => strtoupper($kitCode),
    ":kitType" => $kitType,
    ":id" => $id
);
require_once './../../controller/kitstatuscontroller.php';
$prcc = new KitsStatusController($cn);
echo $prcc->UpdateAction($param);
exit;