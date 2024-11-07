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
     $havPermission = !isset($useraccess['vendors']['view']) ? false : $useraccess['vendors']['view'];
     $havPricePermission = !isset($useraccess['vendors']['priceaccess']) ? false : $useraccess['vendors']['priceaccess'];
     if(!$havPermission){
         echo res(false,"You Do not have Permission to View Vendor List",[],401);
         exit;
     }
     require_once './../../controller/vendorscontroller.php';
     $prcc = new VendorsController($cn);
     echo $prcc->GetAllVendors($havPricePermission);
     exit;
?>