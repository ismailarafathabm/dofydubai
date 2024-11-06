<?php 
    require_once 'mac.php';
    class KitsStatusController extends mac{
        private $cn,$sql,$cm;
        function __construct($db)
        {
            $this->cn = $db;
        }

        private function IKitTypes($rows){
            extract($rows);
            $cols = [];
            $cols['_id'] = $_id;
            $cols['kitCode'] = strtoupper($kitCode);
            $cols['kitType'] = ucwords(strtolower($kitType));
            return $cols;
        }

        private function _getallkitstype(){
            $this->sql = "SELECT *FROM kitTypes order by kitCode asc";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute();
            $kittypes = [];
            while($rows = $this->cm->fetch(PDO::FETCH_ASSOC)){
                $kittype = $this->IKitTypes($rows);
                $kittypes[] = $kittype;
            }
            unset($this->cm,$this->sql,$rows);
            return $kittypes;
        }

        public function GetAllKitType(){
            $kittypes = $this->_getallkitstype();
            return $this->res(true,"ok",$kittypes,200);
            exit;
        }

        private function _checkkit($kitCode){
            $this->sql = "SELECT count(_id) as cnt from kitTypes where kitCode = :kitCode";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":kitCode",$kitCode);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->cm,$this->sql,$rows);  
            return $cnt;
        }
        private function _checkkitforupdate($params){
            //print_r($params);
            $this->sql = "SELECT count(_id) as cnt from kitTypes where kitCode = :kitCode and _id <> :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute($params);
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->cm,$this->sql,$rows);  
            return $cnt;
        }

        private function _save($params){
            $this->sql = "INSERT INTO kitTypes values(null,:kitCode,:kitType)";
            $this->cm = $this->cn->prepare($this->sql);
            $isSaved = $this->cm->execute($params);
            unset($this->sql,$this->cm);
            return $isSaved;
        }

        private function _update($params){
            $this->sql = "UPDATE kitTypes set kitCode = :kitCode,kitType = :kitType where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $isUpdated = $this->cm->execute($params);
            unset($this->cm,$this->sql);
            return $isUpdated;

        }

        public function SaveAction($params){
            $kitCode = strtoupper($params[':kitCode']);
            $cnt = (int)$this->_checkkit($kitCode);
            if($cnt !== 0){
                return $this->res(false,"Dublicate Found",[],409);
                exit;
            }
            $params[":kitCode"] = $kitCode;
            $isSaved = $this->_save($params);
            if(!$isSaved){
                return $this->res(false,"Error on saving Data",[],500);
                exit;
            }
            $kittypes = $this->_getallkitstype();
            return $this->res(true,"ok",$kittypes,200);
            exit;
        }

        public function UpdateAction($params){
            $kitCode = strtoupper($params[':kitCode']);
            $updateparams = array(
                ":kitCode" => $kitCode,
                ":id" => $params[":id"]
            );
            $cnt = (int)$this->_checkkitforupdate($updateparams);
            if($cnt !== 0){
                return $this->res(false,"Dublicate Found",[],409);
                exit;
            }
            $params[":kitCode"] = $kitCode;
            $isUpdated = $this->_update($params);
            if(!$isUpdated){
                return $this->res(false,"Error on Update Data",[],500);
                exit;
            }
            $kittypes = $this->_getallkitstype();
            return $this->res(true,"ok",$kittypes,200);
            exit;
        }
        private function _delete($id):bool{
            $this->sql = "DELETE FROM kitTypes where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":id",$id);
            $isRemoved = $this->cm->execute();
            unset($this->cm,$this->sql);
            return $isRemoved;
        }
        private function _checkdelete($id):int{
            $this->sql = "SELECT COUNT(productKit) as cnt FROM stockEntry where productKit = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":id",$id);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->cm,$this->sql,$rows);
            return $cnt;
        }

        public function DeleteAction($id):string{
            $cnt = (int)$this->_checkdelete($id);
            if($cnt !== 0){
                return $this->res(false,"you could not remove this item because this already assigned with stock entry",[],409);
                exit;
            }
            $isRemoved = $this->_delete($id);
            if(!$isRemoved){
                return $this->res(false,"Error on delete Data",[],500);
                exit;
            }
            $devices = $this->_getallkitstype();
            return $this->res(true,"ok",$devices,200);
            exit;

        }
    }
?>