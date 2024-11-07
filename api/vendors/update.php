<?php 
    require_once '../gen.php';
    if ($rq !== "POST") {
        echo res(false, "Page Not found", [], 404);
        exit();
    }
    
    extract($_POST);
    //validation parts
    extract($_GET);
    $vendorCode = !isset($vendorCode) || trim($vendorCode) === "" ? "" : trim($vendorCode);
    if($shopCode === ""){
        echo res(false,"Enter Vendor Code",[],409);
        exit;
    }
    $vendorName = !isset($vendorName) || trim($vendorName) === "" ? "": trim($vendorName);
    if($vendorName === ""){
        echo res(false,"Enter Vendor Name",[],409);
        exit;
    }
    $vendorPhone = !isset($vendorPhone) || trim($vendorPhone) === "" ? "": trim($vendorPhone);
    if($vendorPhone === ""){
        echo res(false,"Enter Vendor Phone",[],409);
        exit;
    }
    $vendorAddress = !isset($vendorAddress) || trim($vendorAddress) === "" ? "" : trim($vendorAddress);
    $status = !isset($status) || trim($status) === "" ? "1" : trim($status);
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
        echo res(false,"You Do not have Permission to  Edit Vendor",[],401);
        exit;
    }
    $havPricePermission = !isset($useraccess['shops']['priceaccess']) ? false : $useraccess['shops']['priceaccess'];
    require_once './../../controller/shopcontroller.php';
    $prcc = new ShopController($cn);
    (array)$Ishop = array(
        ":vendorName" => $vendorName,
        ":vendorPhone" => $vendorPhone,
        ":vendorAddress" => $vendorAddress,
        ":status" => $status,
        ":eBy" => $userId,
        ":vendorCode" => strtolower($vendorCode),
     );
    echo $prcc->UpdateAction($Ishop,$havPermission);
    exit;
?>