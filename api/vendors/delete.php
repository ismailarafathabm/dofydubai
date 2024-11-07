<?php
require_once './../gen.php';
if ($rq !== "GET") {
    echo res(false, "Page Not Found", [], 404);
    exit();
}
extract($_GET);
$vendorCode = !isset($vendorCode) || trim($vendorCode) === "" ? "" : trim($vendorCode);
if ($shopCode === "") {
    echo res(false, "Enter Vendor Code", [], 409);
    exit;
}
require_once './../../db/db.php';
$db = new DBConnect();
$cn = $db->connectDB();
require_once './../../controller/userscontroller.php';
$uc = new UsersController($cn);
require_once './../auth.php';
$useraccess = $uc->UserAccess($userId);
$havPermission = !isset($useraccess['vendors']['delete']) ? false : $useraccess['vendors']['delete'];
$havPricePermission = !isset($useraccess['vendors']['priceaccess']) ? false : $useraccess['vendors']['priceaccess'];
if (!$havPermission) {
    echo res(false, "You Do not have Permission to Delete Vendor", [], 401);
    exit;
}
require_once './../../controller/vendorscontroller.php';
$prcc = new VendorsController($cn);
echo $prcc->DeleteAction(strtolower($vendorCode),$havPricePermission);
exit;
