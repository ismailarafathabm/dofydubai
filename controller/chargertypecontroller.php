<?php 
    require_once 'mac.php';
    class ChagerTypeController extends mac{
        private $cn,$sql,$cm;
        function __construct($db)
        {
            $this->cn = $db;
        }

        private function IchargerTypes($rows):array{
            extract($rows);
            $cols = [];
            $cols['_id'] = $_id;
            $cols['chargerType'] = ucwords(strtolower($chargerType));
            return $cols;
        }

        private function _getallchargertype():array{
            $this->sql = "SELECT *FROM chargerTypes order by chargerType asc";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute();
            $chargertypes = [];
            while($rows = $this->cm->fetch(PDO::FETCH_ASSOC)){
                $chargertype = (array)$this->IchargerTypes($rows);
                $chargertypes[] = (array)$chargertype;
            }
            unset($this->cm,$this->sql,$rows);
            return $chargertypes;
        }

        public function GetAllChargerTypes():string{
            $chargertypes = (array)$this->_getallchargertype();
            return $this->res(true,'ok',$chargertypes,200);
            exit;
        }

        private function _checkchargertype($chargerType):int{
            $this->sql = "SELECT COUNT(_id) as cnt FROM chargerTypes where chargerType = :chargerType";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":chargerType",$chargerType);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$this->cm,$rows);
            return $cnt;
        }

        private function _save($chargerType):bool{
            $this->sql = "INSERT INTO chargerTypes values(null,:chargerType)";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":chargerType",$chargerType);
            $isSaved = $this->cm->execute();
            unset($this->sql,$this->cm,$rows);
            return $isSaved;
        }

        public function SaveAction($_chargerType):string{
            $chargerType = strtolower($_chargerType);
            $cnt = (int)$this->_checkchargertype($chargerType);
            if($cnt !== 0){
                return $this->res(false,"Dublicate Found",[],409);
                exit;
            }
            $isSaved = (bool)$this->_save($chargerType);
            if(!$isSaved){
                return $this->res(false,"Error on saving data",[],500);
                exit;
            }
            $chargertypes = (array)$this->_getallchargertype();
            return $this->res(true,'ok',$chargertypes,200);
            exit;
        }

        private function _checkchargertypeforudpate($Iparams):int{
            $this->sql = "SELECT COUNT(_id) as cnt FROM chargerTypes where chargerType = :chargerType and _id <> :id";
            $this->cm = $this->cn->prepare($this->sql);
            
            $this->cm->execute($Iparams);
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$this->cm,$rows);
            return $cnt;
        }

        private function _update($Iparams):bool{
            $this->sql = "UPDATE chargerTypes set chargerType = :chargerType where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $isUpdated = $this->cm->execute($Iparams);
            unset($this->sql,$this->cm,$rows);
            return $isUpdated;
        }
        public function UpdateAction($params):string{
            $chargerType = strtolower($params[':chargerType']);
            $params[':chargerType'] =  $chargerType ;
            $cnt = (int)$this->_checkchargertypeforudpate($params);
            if($cnt !== 0){
                return $this->res(false,"Dublicate Found",[],409);
                exit;
            }
            $isUpdated = (bool)$this->_update($params);
            if(!$isUpdated){
                return $this->res(false,"Error on updating data",[],500);
                exit;
            }
            $chargertypes = (array)$this->_getallchargertype();
            return $this->res(true,'ok',$chargertypes,200);
            exit;
        }

        private function _checkdelet($id):int{
            $this->sql = "SELECT COUNT(productCharger) as cnt FROM stockEntry where productCharger = :productCharger";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":productCharger",$id);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->cm,$this->sql,$rows);
            return $cnt;
            
        }

        private function _delete($id):bool{
            $this->sql = "DELETE FROM chargerTypes where _id = :id limit 1";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":id",$id);
            $isRemoved = $this->cm->execute();
            unset($this->sql,$this->cm);
            return $isRemoved;
        }

        public function RemoveAction($id):string{
            $cnt = (int)$this->_checkdelet($id);
            if($cnt !== 0){
                return $this->res(false,"you could not remove this item because this already assigned with stock entry",[],409);
                exit;
            }
            $isRemoved = (bool)$this->_delete($id);
            if(!$isRemoved){
                return $this->res(false,"Error on Deleteing Data",[],500);
                exit;
            }
            $chargertypes = (array)$this->_getallchargertype();
            return $this->res(true,'ok',$chargertypes,200);
            exit;

        }
    }
?>