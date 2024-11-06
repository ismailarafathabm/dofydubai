<?php 
    include_once 'mac.php';
    class UsersController extends mac{
        private $cn;
        private $cm;
        private $sql;
        

        function __construct($db)
        {
            $this->cn = $db;
        }
        private function StatusToString($status){
            //echo $status;
            $statuslist = ['InActive','Active'];
            $statusTxt = $statuslist[(int)$status];
            return $statusTxt;
        }
        
        private function IUser($rows):array{
           // print_r($rows);
            extract($rows);
            $cols = [];
            $cols['_id'] = $_id;
            $cols['userName'] = $userName;
            $cols['userId'] = $userId;
            $cols['userPass'] = $this->enc('denc',$userPass);
            $cols['userToken'] = $userToken;
            $cols['userIp'] = $userIp;
            $cols['userLastLogin'] = $userLastLogin;
            $cols['userType'] = $userType;
            $cols['userStatus'] = $userStatus;
            $cols['userCby'] = $userCby;
            $cols['userEby'] = $userEby;
            $cols['userCdate'] = $userCdate;
            $cols['userEdate'] = $userEdate;
            $cols['passwrongCnt'] = $passwrongCnt;
            $cols['userRole'] = $userRole;
            $cols['shopCode'] = $shopCode;
            $cols['userStatus_txt'] = $this->StatusToString($userStatus);
            return $cols;
        }

        private function _saveUserAccess($params){
            
            $this->sql = "INSERT INTO userRoles values(null,:userId,:useraccess)";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute($params);
            unset($this->cm,$this->sql);
        }
        private function _countUser($userId):int{
            $this->sql = "SELECT COUNT(userId) as cnt FROM userinfo where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userId",$userId);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->cm,$this->sql,$rows);
            //echo $cnt;
            return $cnt;
        }

        private function _getAllUsers():array{
            $this->sql = "SELECT *FROM userinfo where userId<>'superadmin'";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute();
            $users = [];
            while($rows = $this->cm->fetch(PDO::FETCH_ASSOC)){
                $user = $this->IUser($rows);
                $users[] = $user;
            }
            unset($this->sql,$this->cm,$rows);
            return $users;
        }

        private function _userinfo($userId):array{
            $this->sql = "SELECT *FROM userinfo where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userId",$userId);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $user = (array)$this->Iuser($rows);
            unset($this->cm,$this->sql,$rows);
            return $user;
        }

        private function _updateToken($userId):string{
            $gentoken = $this->token(25);
            $otoken = $gentoken . "_". $this->enc('enc',$userId) . "_" . date('YmdHI');
            $this->sql = "UPDATE userinfo set userToken = :userToken where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userToken",$otoken);
            $this->cm->bindParam(":userId",$userId);
            $this->cm->execute();
            unset($this->cm,$this->sql);
            return $otoken;
        }

        private function _updateWrongPassCount($userId,$cnt):void{
            $this->sql = "UPDATE userinfo set passwrongCnt = :passwrongCnt where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":passwrongCnt",$cnt);
            $this->cm->bindParam(":userId",$userId);
            $this->cm->execute();
            unset($this->sql,$this->cm);
            return;
        }
        private function _lockAccount($userId,$userStatus):void{
            $this->sql = "UPDATE userinfo set userStatus = :userStatus where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userStatus",$userStatus);
            $this->cm->bindParam(":userId",$userId);
            $this->cm->execute();
            unset($this->sql,$this->cm);
            return;
        }
        public function Login($userId,$userPass){
            $cnt = (int)$this->_countUser($userId);
            if($cnt !== 1){
                return $this->res(false,"Please Check User Name",[],401);
                exit;
            }
            $getuserinfo = (array)$this->_userinfo($userId);
            //print_r($getuserinfo);
            $wrongcountLast = (int)$getuserinfo['passwrongCnt'];
            $isLocked = (int)$getuserinfo['userStatus'] === 0 ? true : false;
            if($isLocked){
                return $this->res(false,"Your Account Locked Please Contact Admin",[],402);
                exit;
            }
            $userpass = $getuserinfo['userPass'];
            $encpass = $userPass;
            $newcnt = 1;
            if($userpass !== $encpass){
                //echo "called";
                $newcnt += $wrongcountLast;
                $this->_updateWrongPassCount($userId,$newcnt);
                if($newcnt >= 10){
                    $this->_lockAccount($userId,0);
                }
                return $this->res(false,"Check Your Password $newcnt",[],401);
                exit;
            }
            $this->_updateWrongPassCount($userId,0);
            $token = $this->_updateToken($userId);
            $res = array(
                "userId" => $userId,
                "token" => $token,
                "role" => $getuserinfo['userRole']
            );

            return $this->res(true,"ok",$res,200);
            exit;

        }


        private function _savenewuser($user){
            $this->sql = "INSERT INTO userinfo values(
                null,
                :userName,
                :userId,
                :userPass,
                :userToken,
                :userIp,
                :userLastLogin,
                :userType,
                :userStatus,
                :userCby,
                :userEby,
                now(),
                now(),
                0,
                :userRole,
                :shopCode
            )";
            $this->cm = $this->cn->prepare($this->sql);
            $issave = $this->cm->execute($user);
            unset($this->cm,$this->sql);
            return $issave;
        }
        
        public function SaveNewUser($user,$acc){
            //user ID
            $userId = $user[":userId"];
            //check dublicate
            $cnt = (int)$this->_countUser($userId);
            if($cnt !== 0){
                return $this->res(false,"Already This User Name found",[],409);
                exit;
            }
            $issave = (bool)$this->_savenewuser($user);
            if(!$issave){
                return $this->res(false,"Error on saving Data",[],500);
                exit;
            }
            $this->_saveUserAccess($acc);
            $users = (array)$this->_getAllUsers();
            return $this->res(true,"User Has Created",$users,200);
            exit;
        }

        public function UnBlockUser($userId):array{
            $this->_updateWrongPassCount($userId,0);
            $this->_lockAccount($userId,1);
            //change token of user

            $this->_updateToken($userId);
            $users = $this->_getAllUsers();
            return (array)$this->res(true,"Updated",$users,200);
            exit;
        }

        private function _updateuserinfo($Iuser):bool{
            $this->sql = "UPDATE userinfo set 
            userName = :userName,
            userPass = :userPass,
            userToken = :userToken,
            userStatus = :userStatus,
            userEby = :userEby,
            passwrongCnt = 0,
            userEdate = now(),
            shopCode = :shopCode  
            where 
            userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $isupdate = $this->cm->execute($Iuser);
            unset($this->sql,$this->cm);
            return $isupdate;

        }

        public function UpdateUserInfo($Iuser){
            $isUpdate = (bool)$this->_updateuserinfo($Iuser);
            if(!$isUpdate){
                return $this->res(false,"Error on Update User Information",[],500);
                exit;
            }
            $users = $this->_getAllUsers();
            return $this->res(true,"Data Has Updated",$users,200);
            exit;
        }
        public function _getuseraccess($userId){
            $this->sql = "SELECT *FROM userRoles where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userId",$userId);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $useraccess = $rows['useraccess'];
            unset($this->sql,$this->cm,$rows);
            return $useraccess;
        }
        public function GetUserAccessInfo($userId){
            $useraccess = $this->_getuseraccess($userId);
            $data = array(
                "useraccess" => $useraccess
            );
            return  $this->res(true,'ok',$data,200);
            exit;
        }
        public function _checktoken($token):int{
            $this->sql = "SELECT COUNT(userToken) as cnt FROM userinfo where userToken = :userToken";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userToken",$token);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$this->cm,$rows);
            return $cnt;
        }
        public function CHECKAPI($token,$userId){
           $cnt = $this->_checktoken($token);
           if($cnt !== 1){
                return $this->res(false,"Un Autorized User",[],402);
                exit;
           }
           $userinfo = $this->_userinfo($userId);
           $serverUserIP = $userinfo['userIp'];
        //    $machinUserIP = getenv("REMOTE_ADDR");
        //    if($serverUserIP !== $machinUserIP){
        //         return $this->res(false,"Un Autorized System",[],402);
        //         exit;
        //    }
           $isActive = (int)$userinfo['userStatus'] === 1 ? true : false;
           if(!$isActive){
                return $this->res(false,"Autorization Faild with User Locked",[],402);
                exit;
           }
           return $this->res(true,$userinfo['shopCode'],[],200);
           exit;

        }

        public function GetAllUsers(){
            $userslist = (array)$this->_getAllUsers();
            return $this->res(true,"ok",$userslist,200);
            exit;
        }

        public function getuserrole($userId){
            $this->sql = "SELECT *FROM userRoles where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userId",$userId);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $roles = json_decode($rows['useraccess']);
            unset($rows,$this->cm,$this->sql);
            return $roles;
        }

        public function UserAccess($userId){
            if($userId === "superadmin"){
                return $this->superadminaccess();
            }else{
                $access =  $this->getuserrole($userId);
                return $this->UserAccesMapping($access);
            }
        }

        private function _updateUseAcces($params){
            $this->sql = "UPDATE userRoles set useraccess = :useraccess where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $isUpdate = $this->cm->execute($params);
            unset($this->sql,$this->cm);
            return $isUpdate;
        }
        public function UpdateUserAccess($params){
            $isUpdated = $this->_updateUseAcces($params);
            if(!$isUpdated){
               return  $this->res(false,"Error on update",[],500);
                exit;
            }
            return $this->res(true,'ok',[],200);
            exit;
            
        }
        //creating user role

        private function _checkUserRole($userRole):int{
            $this->sql = "SELECT COUNT(userRole) as cnt from userRoles where userRole = :userRole";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userRole",$userRole);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['userRole'];
            unset($this->sql,$this->cm,$rows);
            return $cnt;
        }

        private function _saveUserRole($userRole):bool{
            $this->sql = "INSERT INTO userRoles values(null,:userRole)";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":userRole",$userRole);
            $res = $this->cm->execute();
            unset($this->sql,$this->cm);
            return $res;
        }

        private function _changepassword($IupdateParams){
            $this->sql = "UPDATE userinfo set userPass = :userPass,userToken = :userToken where userId = :userId";
            $this->cm = $this->cn->prepare($this->sql);
            $isUpdated = $this->cm->execute($IupdateParams);
            unset($this->sql,$this->cm);
            return $isUpdated;
        }

        public function ChangePassword($Iupdate){
            $userId = $Iupdate["userId"];
            $useroldpass = $Iupdate['oldpass'];
            $newpassword = $this->enc('enc',$Iupdate['newpass']);
            $getuserinfo = (array)$this->_userinfo($userId);
            $userpass = $getuserinfo['userPass'];
            if($userpass !== $useroldpass){
                return $this->res(false,"Check Your Password",[],401);
                exit;
            }
            $gentoken = $this->token(25);
            $token = $gentoken . "_". $this->enc('enc',$userId) . "_" . date('YmdHI');
            $iupdate = array(
                ":userPass" => $newpassword,
                ":userToken" => $token,
                ":userId" => $userId
            );
            $isUpdated = $this->_changepassword($iupdate);
            if(!$isUpdated){
                return $this->res(false,"Error on update",[],500);
                exit;
            }
            return $this->res(true,'ok',[],200);
            exit;

        }

        public function AddAdminUser(){
            $Iuser = array(
                ":userName" => 'Super Admin',
                ":userId" => strtolower("superadmin"),
                ":userPass" => $this->enc('enc',"admin@123"),
                ":userToken" => $this->token(25) . "_" . $this->enc('enc',"superadmin") . "_" . date('YmdHi'),
                ":userIp" => getenv("REMOTE_ADDR"),
                ":userLastLogin" => date('Y-m-d H:i:s'),
                ":userType" => "1",
                ":userStatus" => 1,
                ":userCby" => "superadmin",
                ":userEby" => "superadmin",
                ":userRole" => "1"
            );

           //echo  $this->SaveNewUser($Iuser);
        }
       


    }
    // require_once './../db/db.php';
    // $conn = new DBConnect();
    // $cn = $conn->connectDB();
    // $user = new UsersController($cn);
    // echo $user->AddAdminUser();
?>