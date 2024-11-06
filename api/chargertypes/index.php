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
     $chargertype_viewAccess = !isset($useraccess['devicesettings']['chargertype']['viewaccess']) ? false : $useraccess['devicesettings']['chargertype']['viewaccess'];
     if(!$chargertype_viewAccess){
         echo res(false,"You Do not have Permission get data",[],401);
         exit;
     }
     require_once './../../controller/chargertypecontroller.php';
     $prcc = new ChagerTypeController($cn);
     echo $prcc->GetAllChargerTypes();
?>