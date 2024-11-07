<?php 
    require_once '../gen.php';
    if ($rq !== "POST") {
        echo res(false, "Page Not found", [], 404);
        exit();
    }
    
    extract($_POST);
    //validation parts
    $shopCode = !isset($shopCode) || trim($shopCode) === "" ? "" : trim($shopCode);
    if($shopCode === ""){
        echo res(false,"Enter Shop Code",[],409);
        exit;
    }
    $shopName = !isset($shopName) || trim($shopName) === "" ? trim(strtolower($shopCode)) : trim($shopName);
   
    $shopLocation = !isset($shopName) || trim($shopName) === "" ? "" : trim($shopName);
    $shopCurrencyType = !isset($shopCurrencyType) || trim($shopCurrencyType) === "" ? "inr" : trim($shopCurrencyType);
    //validation part
    
    require_once './../../db/db.php';
    $conn = new DBConnect();
    $cn = $conn->connectDB();
    
    require_once "./../../controller/userscontroller.php";
    (object)$uc = new UsersController($cn);
    
    require_once './../auth.php';

    $useraccess = $uc->UserAccess($userId);
    $havPermission = !isset($useraccess['shops']['new']) ? false : $useraccess['shops']['new'];
    if(!$havPermission){
        echo res(false,"You Do not have Permission to Add new Shop",[],401);
        exit;
    }
    $havPricePermission = !isset($useraccess['shops']['priceaccess']) ? false : $useraccess['shops']['priceaccess'];
    require_once './../../controller/shopcontroller.php';
    $prcc = new ShopController($cn);
    $Ishop = array(
        ":shopCode" => strtolower($shopCode),
        ":shopName" => $shopName,
        ":shopLocation" => $shopLocation,
        ":shopCurrencyType" => $shopCurrencyType,
    );
    echo $prcc->SaveAction($Ishop,$havPermission);
    exit;
?>