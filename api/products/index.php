<?php 
     require_once './../gen.php';
     if($rq !== "GET"){
         echo res(false,"Page Not Found",[],404);
         exit();
     }
     require_once './../../db/db.php';
     $db = new DBConnect();
     $cn = $db->connectDB();
     require_once './../../controller/userscontroller.php';
     $uc = new UsersController($cn);
     require_once './../auth.php';
     $useraccess = $uc->UserAccess($userId);
     $havPermission = !isset($useraccess['devicesettings']['models']['viewaccess']) ? false : $useraccess['devicesettings']['models']['viewaccess'];
     $havPricePermission = !isset($useraccess['devicesettings']['models']['priceview']) ? false : $useraccess['devicesettings']['models']['priceview'];
     if(!$havPermission){
         echo res(false,"You Do not have Permission to View Device Models ",[],401);
         exit;
     }
     require_once './../../controller/productcontrollers.php';
     $prcc = new ProductControllers($cn);
     echo $prcc->GetAllProducts($havPricePermission);
?>