<?php
require_once './../gen.php';
if ($rq !== "GET") {
    echo res(false, "Page Not Found", [], 404);
    exit();
}
require_once './../../db/db.php';
$db = new DBConnect();
$cn = $db->connectDB();
require_once './../../controller/userscontroller.php';
$uc = new UsersController($cn);
require_once './../auth.php';
$useraccess = $uc->UserAccess($userId);
$havPermission = !isset($useraccess['devicesettings']['warranty']['viewaccess']) ? false : $useraccess['devicesettings']['warranty']['viewaccess'];
if(!$havPermission){
    echo res(false,"You Do not have Permission to View Device Warranty list",[],401);
    exit;
}
require_once './../../controller/devicewarrantycontroller.php';
$prcc = new DeviceWarrantyController($cn);
echo (string)$prcc->GetAllWarrantys();
exit;
