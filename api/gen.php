<?php 
     header("Content-Type:text/json");
     header("Access-Control-Allow-Origin: *");
     header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
     header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token,GTOKEN");
     $rq = $_SERVER['REQUEST_METHOD'];
    function res($isSuccess,$msg,$data,$statusCode){
        $response = array(
            "isSuccess" => $isSuccess,
            "msg" => $msg,
            "data" => $data,
            "statusCode" => $statusCode
        );
        header("HTTP/1.0 $statusCode $msg");
        echo json_encode($response);
        exit();
    }

    
?>