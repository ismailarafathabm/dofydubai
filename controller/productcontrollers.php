<?php 
    include_once 'mac.php';
    class ProductControllers extends mac{
        private $cn,$cm,$sql;
        function __construct($db)
        {
            
            $this->cn = $db;
        }
        
        private function IDeviceModels($rows){
            extract($rows);
            $cols = [];
            $cols['_id'] = $_id;
            $cols['deviceType'] = ucwords(strtolower($deviceType));
            $cols['deviceBrand'] = ucwords(strtolower($deviceBrand));
            $cols['deviceModel'] = ucwords(strtolower($deviceModel));
            $cols['deviceRamRom'] = $deviceRamRom;
            $cols['deviceFullName'] = ucwords(strtolower($deviceFullName));
            return $cols;
        }

        private function _getallproducts($havPricePermission =false){
            $this->sql = "SELECT dv.*,IFNULL(st.avi,0) as instock,IFNULL(st.dcost,0) as instockval 
            FROM deviceModels as dv left join 
            (select productModel,count(_id) as avi,sum(devicePrice) as dcost from stockEntrys where status=1 group by productModel) 
            as st on dv._id = st.productModel  order by dv._id asc;";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute();
            $devices = [];
            while($rows = $this->cm->fetch(PDO::FETCH_ASSOC)){
                $device = $this->IDeviceModels($rows);
                $device['instock'] = $rows['instock'];
                $device['instockval'] = !$havPricePermission ? '0' : $rows['instockval'];
                $devices[] = $device; 
            }
            unset($this->sql,$this->cm,$rows);
            return $devices;
        }

        public function GetAllProducts($p){
            $devices = $this->_getallproducts($p);
            return $this->res(true,"ok",$devices,200);
            exit;
        }

        private function _checkproduct($Iparams){
           // print_r($Iparams);
            $this->sql = "SELECT COUNT(_id) as cnt from deviceModels 
            where deviceType = :deviceType and deviceBrand = :deviceBrand and 
            deviceModel = :deviceModel and deviceRamRom = :deviceRamRom";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute($Iparams);
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$rows,$this->cm);
            return $cnt;
        }


        private function _checkproductforupdate($Iparams){
            $this->sql = "SELECT COUNT(_id) as cnt from deviceModels 
            where deviceType = :deviceType and deviceBrand = :deviceBrand and 
            deviceModel = :deviceModel and deviceRamRom = :deviceRamRom and _id <> :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute($Iparams);
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->sql,$rows,$this->cm);
            return $cnt;
        }

        private function _savenewproduct($Iparam){
           $this->sql = "INSERT INTO deviceModels values(
                null,
                :deviceType,
                :deviceBrand,
                :deviceModel,
                :deviceRamRom,
                :deviceFullName
           )";
           $this->cm = $this->cn->prepare($this->sql);
           $isSaved = $this->cm->execute($Iparam);
           unset($this->sql,$this->cm);
           return $isSaved;
            
        }

        public function SaveNewProduct($Iparam,$p){
            $cnt = $this->_checkproduct($Iparam);
            if($cnt !== 0){
                return $this->res(false,"Dublicate found",[],409);
                exit;
            }
            $Iparam[":deviceFullName"] = $Iparam[':deviceBrand'] . " " . $Iparam[':deviceModel'];
            $isSave = $this->_savenewproduct($Iparam);
            if(!$isSave){
                return $this->res(false,"Error on Saving data",[],500);
                exit;
            }
            $devices = $this->_getallproducts($p);
            return $this->res(true,"ok",$devices,200);
            exit;
        }

        private function _updateProduct($Iparams){
            $this->sql = "UPDATE deviceModels set 
            deviceType = :deviceType,
            deviceBrand = :deviceBrand,
            deviceModel = :deviceModel,
            deviceRamRom = :deviceRamRom,
            deviceFullName = :deviceFullName 
            where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $isUpdated = $this->cm->execute($Iparams);
            unset($this->sql,$this->cm);
            return $isUpdated;
        }

        public function UpdateProduct($Iparams,$p){
            $cnt = $this->_checkproductforupdate($Iparams);
            if($cnt !== 0){
                return $this->res(false,"You Could not update,This Product Already Found",[],409);
                exit;
            }
            $Iparams[":deviceFullName"] = $Iparams[':deviceBrand'] . " " . $Iparams[':deviceModel'];
            $isUpdated = $this->_updateProduct($Iparams);
            if(!$isUpdated){
                return $this->res(false,"Error on update data",[],200);
                exit();
            }
            $devices = $this->_getallproducts($p);
            return $this->res(true,"ok",$devices,200);
            exit;

        }

        private function _checkdelete($id):int{
            $this->sql = "SELECT COUNT(productModel) as cnt FROM stockEntry where productModel = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":id",$id);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            $cnt = (int)$rows['cnt'];
            unset($this->cm,$this->sql,$rows);
            return $cnt;
        }

        private function _delete($id):bool{
            $this->sql = "DELETE FROM deviceModels where _id = :id";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":id",$id);
            $isRemoved = $this->cm->execute();
            unset($this->cm,$this->sql);
            return $isRemoved;
        }

        public function DeleteAction($id,$p):string{
            ///check before delte
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
            $devices = $this->_getallproducts($p);
            return $this->res(true,"ok",$devices,200);
            exit;

        }
    }
?>