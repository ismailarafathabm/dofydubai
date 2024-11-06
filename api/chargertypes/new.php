<?php
require_once '../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not found", [], 404);
    exit();
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
$chargertype_newAccess = !isset($useraccess['devicesettings']['chargertype']['new']) ? false : $useraccess['devicesettings']['chargertype']['new'];
if(!$chargertype_newAccess){
    echo res(false,"You Do not have Permission to create new charger Type",[],401);
    exit;
}

require_once './../../controller/chargertypecontroller.php';
$prcc = new ChagerTypeController($cn);
echo $prcc->SaveAction($chargerType);
exit();
