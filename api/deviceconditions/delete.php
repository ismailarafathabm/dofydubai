<?php
require_once './../gen.php';
if ($rq !== "GET") {
    echo res(false, "Page Not Found", [], 404);
    exit();
}
$id = !isset($_GET['id']) || trim($_GET["id"]) === "" ? "" : trim($_GET['id']);
if($id === ""){
    echo res(false,"Id missing",[],409);
}
require_once './../../db/db.php';
$db = new DBConnect();
$cn = $db->connectDB();
require_once './../../controller/userscontroller.php';
$uc = new UsersController($cn);
require_once './../auth.php';
//check
//autorization 
$useraccess = $uc->UserAccess($userId);
$havPermission = !isset($useraccess['devicesettings']['conditions']['delete']) ? false : $useraccess['devicesettings']['conditions']['delete'];
if(!$havPermission){
    echo res(false,"You Do not have Permission to Remove Device Conditions",[],401);
    exit;
}
//check
require_once './../../controller/productconditioncontroller.php';
$prcc = new ProductConditionController($cn);
echo (string)$prcc->DeleteAction($id);
exit;