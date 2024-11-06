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
     $havPermission = !isset($useraccess['devicesettings']['kitstatus']['viewaccess']) ? false : $useraccess['devicesettings']['kitstatus']['viewaccess'];
     if(!$havPermission){
         echo res(false,"You Do not have Permission to View Device Kits List",[],401);
         exit;
     }
     require_once './../../controller/kitstatuscontroller.php';
     $prcc = new KitsStatusController($cn);
     echo $prcc->GetAllKitType();
     exit;
?>