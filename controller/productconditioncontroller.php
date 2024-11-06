<?php 
    include_once 'mac.php';
    class ProductConditionController extends mac{
        private $cn,$cm,$sql;
        function __construct($db)
        {
            $this->cn = $db;
        }

        private function IProductCondition($rows){
            extract($rows);
            $cols = [];
            $cols['_id'] = $_id;
            $cols['productCondition'] = ucwords(strtolower($productCondition));
            return $cols;
        }

        private function _getallconditions(){
            $this->sql = "SELECT *FROM productConditions order by productCondition asc";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute();
            $conditions = [];
            while($rows = $this->cm->fetch(PDO::FETCH_ASSOC)){
                $condition = $this->IProductCondition($rows);
                $conditions[] = $condition;
            }
            unset($this->sql,$rows,$this->cm);
            return $conditions;
        }
        public function GetAllConditions(){
            $conditions = $this->_getallconditions();
            return $this->res(true,"ok",$conditions,200);
            exit();
        }

        private function _checkconditions($productCondition){
            $this->sql = "SELECT COUNT(productCondition) as cnt from productConditions where productCondition = :productCondition";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":productCondition",$productCondition);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$rows,$this->cm);
            return $cnt;
        }

        private function _checkconditionsforupdate($params){
            $this->sql = "SELECT COUNT(productCondition) as cnt from productConditions where productCondition = :productCondition and _id <> :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute($params);
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$rows,$this->cm);
            return $cnt; 
        }

        private function _save($productCondition){
            $this->sql = "INSERT INTO productConditions values(null,:productCondition)";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":productCondition",$productCondition);
            $isSaved = $this->cm->execute();
            unset($this->cm,$this->sql,$rows);
            return $isSaved;
        }

        private function _update($Iparams){
            $this->sql = "UPDATE productConditions set productCondition = :productCondition where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $isUpdated = $this->cm->execute($Iparams);
            unset($this->cm,$this->sql,$rows);
            return $isUpdated;
        }

        public function SaveAction($productCondition){
            $productCondition = strtolower($productCondition);
            $cnt = $this->_checkconditions($productCondition);
            if($cnt !== 0){
                return $this->res(false,"Dublicate Found",[],409);
                exit();
            }
            $isSaved = $this->_save($productCondition);
            if(!$isSaved){
                return $this->res(false,"Error on Saving Data",[],500);
                exit();
            }
            $conditions = $this->_getallconditions();
            return $this->res(true,"ok",$conditions,200);
            exit();
        }

        public function UpdateAction($Iupdate){
            $Iupdate[':productCondition'] = strtolower($Iupdate[':productCondition']);
            $cnt = $this->_checkconditionsforupdate($Iupdate);
            if($cnt !== 0){
                return $this->res(false,"Dublicate Found",[],409);
                exit();
            }
            $isUpdated = $this->_update($Iupdate);
            if(!$isUpdated){
                return $this->res(false,"Error on Update Data",[],500);
                exit();
            }
            $conditions = $this->_getallconditions();
            return $this->res(true,"ok",$conditions,200);
            exit();
        }

        private function _delete($id):bool{
            $this->sql = "DELETE FROM productConditions where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":id",$id);
            $isRemoved = $this->cm->execute();
            unset($this->cm,$this->sql);
            return $isRemoved;
        }
        private function _checkdelete($id):int{
            $this->sql = "SELECT COUNT(productCondition) as cnt FROM stockEntry where productCondition = :id";
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
            $devices = $this->_getallconditions();
            return $this->res(true,"ok",$devices,200);
            exit;

        }
    }
?>