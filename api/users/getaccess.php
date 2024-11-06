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
   
    if($userId !== 'superadmin'){
        echo res(false,"You Can Not access Page",[],402);
        exit();
    }
    extract($_GET);
    echo $uc->GetUserAccessInfo($getuserId);
    exit();

?>