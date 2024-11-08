<?php 
    require_once '../gen.php';
    if ($rq !== "POST") {
        echo res(false, "Page Not found", [], 404);
        exit();
    }
    
    extract($_POST);
    //validation parts
    extract($_GET);
    $shop = !isset($shop) || trim($shop) === "" ? "" : trim($shop);
    if($shop === ""){
        echo res(false,"Enter Shop Code",[],409);
        exit;
    }
    $shopName = !isset($shopName) || trim($shopName) === "" ? trim(strtolower($shopCode)) : trim($shopName);
   
    $shopLocation = !isset($shopLocation) || trim($shopLocation) === "" ? "" : trim($shopLocation);
    $shopCurrencyType = !isset($shopCurrencyType) || trim($shopCurrencyType) === "" ? "inr" : trim($shopCurrencyType);
    //validation part
    
    require_once './../../db/db.php';
    $conn = new DBConnect();
    $cn = $conn->connectDB();
    
    require_once "./../../controller/userscontroller.php";
    (object)$uc = new UsersController($cn);
    
    require_once './../auth.php';

    $useraccess = $uc->UserAccess($userId);
    $havPermission = !isset($useraccess['shops']['edit']) ? false : $useraccess['shops']['edit'];
    if(!$havPermission){
        echo res(false,"You Do not have Permission to Edit Shop",[],401);
        exit;
    }
    $havPricePermission = !isset($useraccess['shops']['priceaccess']) ? false : $useraccess['shops']['priceaccess'];
    require_once './../../controller/shopcontroller.php';
    $prcc = new ShopController($cn);
    $Ishop = array(
        ":shopName" => $shopName,
        ":shopLocation" => $shopLocation,
        ":shopCurrencyType" => $shopCurrencyType,
        ":shopCode" => strtolower($shop),
    );
    echo $prcc->UpdateAction($Ishop,$havPermission);
    exit;
?>