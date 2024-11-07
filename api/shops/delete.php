<?php 
     require_once './../gen.php';
     if($rq !== "GET"){
         echo res(false,"Page Not Found",[],404);
         exit();
     }
     extract($_GET);
     $shopCode = !isset($shopCode) || trim($shopCode) === "" ? "" : trim($shopCode);
     if($shopCode === ""){
         echo res(false,"Enter Shop Code",[],409);
         exit;
     }
     require_once './../../db/db.php';
     $db = new DBConnect();
     $cn = $db->connectDB();
     require_once './../../controller/userscontroller.php';
     $uc = new UsersController($cn);
     require_once './../auth.php';
     $useraccess = $uc->UserAccess($userId);
     $havPermission = !isset($useraccess['shops']['delete']) ? false : $useraccess['shops']['delete'];
     $havPricePermission = !isset($useraccess['shops']['priceaccess']) ? false : $useraccess['shops']['priceaccess'];
     if(!$havPermission){
         echo res(false,"You Do not have Permission to Delete Shop",[],401);
         exit;
     }
     require_once './../../controller/shopcontroller.php';
     $prcc = new ShopController($cn);
     echo $prcc->DeleteShopAction(strtolower($shopCode),$havPricePermission);
     exit;
?>