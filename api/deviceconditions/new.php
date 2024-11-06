<?php
require_once '../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not found", [], 404);
    exit();
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
$havPermission = !isset($useraccess['devicesettings']['conditions']['new']) ? false : $useraccess['devicesettings']['conditions']['new'];
if(!$havPermission){
    echo res(false,"You Do not have Permission to Add New Device Conditions",[],401);
    exit;
}

require_once './../../controller/productconditioncontroller.php';
$prcc = new ProductConditionController($cn);
echo $prcc->SaveAction($productCondition);
exit();
