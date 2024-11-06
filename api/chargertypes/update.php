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
$chargerType = !isset($chargerType) || trim($chargerType) === "" ? "" : trim($chargerType);
if ($chargerType === "") {
    echo res(false, "Enter Device Charger Type", [], 409);
    exit;
}
require_once './../../db/db.php';
$conn = new DBConnect();
$cn = $conn->connectDB();

require_once "./../../controller/userscontroller.php";
$uc = new UsersController($cn);

require_once './../auth.php';
$useraccess = $uc->UserAccess($userId);
$chargertype_updateAccess = !isset($useraccess['devicesettings']['chargertype']['edit']) ? false : $useraccess['devicesettings']['chargertype']['edit'];
if(!$chargertype_updateAccess){
    echo res(false,"You Do not have Permission to Update charger Type",[],401);
    exit;
}

require_once './../../controller/chargertypecontroller.php';
$prcc = new ChagerTypeController($cn);
$params = array(
    ":chargerType" => $chargerType,
    ":id" => $id,
);
echo $prcc->UpdateAction($params);
exit();
