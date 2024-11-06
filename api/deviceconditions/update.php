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
$productCondition = !isset($productCondition) || trim($productCondition) === "" ? "" : trim($productCondition);
if($productCondition === ""){
    echo res(false,"Enter Device Condition description",[],409);
    exit;
}
require_once './../../db/db.php';
$conn = new DBConnect();
$cn = $conn->connectDB();

require_once "./../../controller/userscontroller.php";
$uc = new UsersController($cn);

require_once './../auth.php';
$useraccess = $uc->UserAccess($userId);
$havPermission = !isset($useraccess['devicesettings']['conditions']['edit']) ? false : $useraccess['devicesettings']['conditions']['edit'];
if(!$havPermission){
    echo res(false,"You Do not have Permission to Edit Device Conditions",[],401);
    exit;
}
require_once './../../controller/productconditioncontroller.php';
$prcc = new ProductConditionController($cn);
$params = array(
    ":productCondition" => $productCondition,
    ":id" => $id,
);
echo $prcc->UpdateAction($params);
exit();
