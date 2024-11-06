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
     $havPermission = !isset($useraccess['devicesettings']['conditions']['viewaccess']) ? false : $useraccess['devicesettings']['conditions']['viewaccess'];
     if(!$havPermission){
         echo res(false,"You Do not have Permission to View Device Conditions List",[],401);
         exit;
     }
     require_once './../../controller/productconditioncontroller.php';
     $prcc = new ProductConditionController($cn);
     echo $prcc->GetAllConditions();
?>