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
$chargertype_deleteAccess = !isset($useraccess['devicesettings']['chargertype']['delete']) ? false : $useraccess['devicesettings']['chargertype']['delete'];
if(!$chargertype_deleteAccess){
    echo res(false,"You do not have permission to delete",[],401);
    exit;
}

//check
require_once './../../controller/chargertypecontroller.php';
$prcc = new ChagerTypeController($cn);
echo (string)$prcc->RemoveAction($id);
exit;
