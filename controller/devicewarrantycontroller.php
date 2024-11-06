<?php 
    include_once 'mac.php';
    class DeviceWarrantyController extends mac{
        private $cn,$sql,$cm;
        function __construct($db)
        {
            $this->cn = $db;
        }

        private function Iwarrantys($rows):array{
            extract($rows);
            $cols = [];
            $cols["_id"] = $_id;
            $cols["warranty"] = ucwords(strtolower($warranty));
            return $cols;
        }

        private function _getallwarrantys(){
            $this->sql = "SELECT *FROM warrantys order by warranty asc";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute();
            $warrantys = [];
            while($rows = $this->cm->fetch(PDO::FETCH_ASSOC)){
                $warranty = $this->Iwarrantys($rows);
                $warrantys[] = $warranty;
            }
            unset($this->sql,$this->cm,$rows);
            return $warrantys;
        }

        public function GetAllWarrantys():string{
            $warrantys = $this->_getallwarrantys();
            return $this->res(true,"ok",$warrantys,200);
            exit;
        }

        private function _checkwarranty($warranty):int{
            $this->sql = "SELECT COUNT(_id) as cnt from warrantys where warranty = :warranty";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":warranty",$warranty);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$this->cm,$rows);
            return $cnt;
        }
        private function _checkwarrantyforudpate($params):int{
            $this->sql = "SELECT COUNT(_id) as cnt from warrantys where warranty = :warranty and _id <> :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute($params);
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$this->cm,$rows);
            return $cnt;
        }

        private function _save($warranty):bool{
            $this->sql = "INSERT INTO warrantys values(null,:warranty)";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":warranty",$warranty);
            $isSaved = $this->cm->execute();
            unset($this->cm,$this->sql);
            return $isSaved;
        }

        private function _update($params):bool{
           
            $this->sql = "UPDATE warrantys set warranty = :warranty where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $isUpdate = $this->cm->execute($params);
            unset($this->cm,$this->sql);
            return $isUpdate;
        }

        public function SaveAction($_warranty):string{
            $warranty = strtolower($_warranty);
            $cnt = (int)$this->_checkwarranty($warranty);
            if($cnt !== 0){
                return $this->res(false,"dublicate found",[],409);
                exit;
            }
            $isSaved = (bool)$this->_save($warranty);
            if(!$isSaved){
                return $this->res(false,"error on saving data",[],500);
                exit;
            }
            $warrantys = $this->_getallwarrantys();
            return $this->res(true,"ok",$warrantys,200);
            exit;
            
        }

        public function UpdateAction($params):string{
           // print_r($params);
            $warranty = strtolower($params[':warranty']);
            $params[':warranty'] = $warranty;
            $cnt = (int)$this->_checkwarrantyforudpate($params);
            if($cnt !== 0){
                return $this->res(false,"dublicate found",[],409);
                exit;
            }
            $isSaved = (bool)$this->_update($params);
            if(!$isSaved){
                return $this->res(false,"error on Update data",[],500);
                exit;
            }
            $warrantys = $this->_getallwarrantys();
            return $this->res(true,"ok",$warrantys,200);
            exit;
            
        }

        private function _delete($id):bool{
            $this->sql = "DELETE FROM warrantys where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":id",$id);
            $isRemoved = $this->cm->execute();
            unset($this->cm,$this->sql);
            return $isRemoved;
        }
        private function _checkdelete($id):int{
            $this->sql = "SELECT COUNT(productWarranty) as cnt FROM stockEntry where productWarranty = :id";
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
            $warrantys = $this->_getallwarrantys();
            return $this->res(true,"ok",$warrantys,200);
            exit;

        }
      
    }
?>