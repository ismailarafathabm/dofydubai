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
     $havPermission = !isset($useraccess['shops']['view']) ? false : $useraccess['shops']['view'];
     $havPricePermission = !isset($useraccess['shops']['priceaccess']) ? false : $useraccess['shops']['priceaccess'];
     if(!$havPermission){
         echo res(false,"You Do not have Permission to View Shop List",[],401);
         exit;
     }
     require_once './../../controller/shopcontroller.php';
     $prcc = new ShopController($cn);
     echo $prcc->GetAllShops($havPricePermission);
     exit;
?>