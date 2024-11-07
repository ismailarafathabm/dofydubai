<?php
require_once '../gen.php';
if ($rq !== "POST") {
    echo res(false, "Page Not found", [], 404);
    exit();
}

extract($_POST);
//validation parts

//validation part

require_once './../../db/db.php';
$conn = new DBConnect();
$cn = $conn->connectDB();

require_once "./../../controller/userscontroller.php";
(object)$uc = new UsersController($cn);

require_once './../auth.php';

//authorization
$useraccess = $uc->UserAccess($userId);
$haveAccessNewStockEntry = !isset($useraccess['stockentrys']['new']) ? false : $useraccess['stockentrys']['new'];
if(!$haveAccessNewStockEntry){
    echo res(false,"You Do not have Permission to Add New Stock Entry",[],401);
    exit;
}
//authorization
//params 
//stock entry
(array)$Istockeentry = array(
    ":stockDate" => date_format(date_create($stockDate),'Y-m-d'),
    ":productModel" => $productModel,
    ":productImei" => $productImei,
    ":productCondition" => $productCondition,
    ":productBattery" => $productBattery,
    ":productDisplaySize" => $productDisplaySize,
    ":productProcessor" => $productProcessor,
    ":productCharger" => $productCharger,
    ":productKit" => $productKit,
    ":productWarranty" => $productWarranty,
    ":cBy" => $userId,
    ":eBy" => $userId,
    ":devicePrice" => $devicePrice,
    ":priceType" => $priceType,
    ":shopCode" => $shopCode,
);
//Imei save
(array)$Imeisave = array(
    ":imeiNo" => $productImei,
    ":imeiModel" => $productModel,
    ":imeiCondition" => $productCondition,
    ":imeiBattery" => $productBattery,
    ":imeiDisplaySize" => $productDisplaySize,
    ":imeiProcessor" => $productProcessor,
    ":imeiChargerType" => $productCharger,
    ":imeiKitStatus" => $productKit,
    ":imeiKitStatus" => $productKit,
    ":imeiNlc" => $devicePrice,
    ":imeiMxprice" => $imeiMxprice,
    ":imeiSoldPrice" => 0,
    ":imeiCurrencyType" => $priceType,
    ":imeiStockInDate" => date_format(date_create($stockDate),'Y-m-d'),
    ":imeiShopCode" => $shopCode,
    ":cBy" => $userId,
    ":eBy" => $userId,
    ":imeiWarranty" => $productWarranty
);

(array)$Imeiupdate = array(
    ":imeiModel" => $productModel,
    ":imeiCondition" => $productCondition,
    ":imeiBattery" => $productBattery,
    ":imeiDisplaySize" => $productDisplaySize,
    ":imeiProcessor" => $productProcessor,
    ":imeiChargerType" => $productCharger,
    ":imeiKitStatus" => $productKit,
    ":imeiKitStatus" => $productKit,
    ":imeiNlc" => $devicePrice,
    ":imeiMxprice" => $imeiMxprice,
    ":imeiSoldPrice" => 0,
    ":imeiCurrencyType" => $priceType,
    ":imeiStockInDate" => date_format(date_create($stockDate),'Y-m-d'),
    ":imeiShopCode" => $shopCode,
    ":eBy" => $userId,
    ":imeiWarranty" => $productWarranty,
    ":imeiNo" => $productImei,
);

require_once './../../controller/stockentrycontroller.php';
$sec = new StockEntryController($cn);
echo $sec->SaveAction($Istockeentry,$Imeisave,$Imeiupdate);
exit;
//imei update
