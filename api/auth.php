<?php 
    $requestHeader = apache_request_headers();
    //print_r($requestHeader);
    $Gtoken = !isset($requestHeader['GTOKEN']) || trim($requestHeader['GTOKEN']) === "" ? "" : $requestHeader["GTOKEN"];

    if($Gtoken === ""){

        echo res(false,"Authorization Falid 01 $Gtoken",[],402);
        exit();
    }
    $sp_token = explode("_",$Gtoken);
    if(count($sp_token) !== 3){
        echo res(false,"Autorization Faild - Miss match Token Syntax",[],402);
        exit();
    }
    $userId = $uc->enc('denc', $sp_token[1]);
   
    $apicheck = $uc->CHECKAPI($Gtoken,$userId);
    $apidec = json_decode($apicheck);
    if(!$apidec->isSuccess){
        echo res(false,$apidec->msg,[],402);
        exit();
    }
    $userrole = $apidec->msg;
    

?>