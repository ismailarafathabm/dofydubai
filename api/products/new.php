<?php
require_once '../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not found", [], 404);
    exit();
}


extract($_POST);

$deviceType = !isset($deviceType) || trim($deviceType) === "" ? "" : trim($deviceType);
if ($deviceType === "") {
    echo res(false, "Enter Product Type", [], 409);
    exit;
}
$deviceBrand = !isset($deviceBrand) || trim($deviceBrand) === "" ? "" : trim($deviceBrand);
if ($deviceBrand === "") {
    echo res(false, "Enter Brand Name", [], 409);
    exit;
}
$deviceModel = !isset($deviceModel) || trim($deviceModel) === "" ? "" : trim($deviceModel);
if ($deviceModel === "") {
    echo res(false, "Enter Product Model", [], 409);
    exit;
}
$deviceRamRom = !isset($deviceRamRom) || trim($deviceRamRom) === "" ? "" : trim($deviceRamRom);
if ($deviceRamRom === "") {
    echo res(false, "Enter Product Ram Rom Size", [], 409);
    exit;
}

require_once './../../db/db.php';
$conn = new DBConnect();
$cn = $conn->connectDB();

require_once "./../../controller/userscontroller.php";
$uc = new UsersController($cn);

require_once './../auth.php';

//do autorization steps
$useraccess = $uc->UserAccess($userId);
$havPermission = !isset($useraccess['devicesettings']['models']['new']) ? false : $useraccess['devicesettings']['models']['new'];
$havPricePermission = !isset($useraccess['devicesettings']['models']['priceview']) ? false : $useraccess['devicesettings']['models']['priceview'];
if(!$havPermission){
    echo res(false,"You Do not have Permission to Add New Device Models info",[],401);
    exit;
}
//do autorization steps

$params = array(
    ':deviceType' => strtolower($deviceType),
    ':deviceBrand' => strtolower($deviceBrand),
    ':deviceModel' => strtolower($deviceModel),
    ':deviceRamRom' => strtolower($deviceRamRom),
);
require_once './../../controller/productcontrollers.php';
$prcc = new ProductControllers($cn);
echo $prcc->SaveNewProduct($params,$havPricePermission );
exit;
