<?php 
    include_once 'mac.php';

    class ShopController extends mac{
        private object $cn;
        private object $cm;
        private string $sql;
        function __construct($db)
        {
            $this->cn = $db;
        }

        private function IShops(array $rows):array{
            (array)$cols = [];
            extract($rows);
            $cols['_id'] = $_id;
            $cols['shopCode'] = $shopCode;
            $cols['shopName'] = $shopName;
            $cols['shopLocation'] = $shopLocation;
            $cols['shopCurrencyType'] = $shopCurrencyType;
            return $cols;
        }

        private function _getallshops(bool $priceaccess = false):array{
            $this->sql = "SELECT *FROM shops order by shopName asc";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->execute();
            $shops = [];
            while($rows = $this->cm->fetch(PDO::FETCH_ASSOC)){
                $shop = $this->IShops($rows);
                $shops[] = $shop;
            }
            unset($this->cm,$this->sql,$rows);
            //return false;
            return $shops;
        }

        public function GetAllShops($priceaccess){
            $shops = (array)$this->_getallshops();
            return $this->res(true,"ok",$shops,200);
            
        }

        private function _checkshops(string $shopcode):int{
            $this->sql = "SELECT COUNT(shopCode) as cnt from shops where shopCod = :shopCode";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":shopCode",$shopcode);
            $this->cm->execute();
            $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            (int)$cnt = $rows['cnt'];
            unset($this->sql,$this->cm,$rows);
            return $cnt;
        }

        private function _saveshop(array $Ishop):bool{
            $this->sql = "INSERT INTO shops values(
                null,
                :shopCode,
                :shopName,
                :shopLocation,
                :shopCurrencyType
            )";
            $this->cm = $this->cn->prepare($this->sql);
            (bool)$isSaved = $this->cm->execute($Ishop);
            unset($this->sql,$this->cm,$rows);
            return $isSaved;
        }

        public function SaveAction(array $Ishop):string{
            $shopcode = strtolower($Ishop[':shopCode']);
            $cnt = $this->_checkshops($shopcode);
            if($cnt !== 0){
                return $this->res(false,"dublicate",[],409);
            }

            $Ishop[':shopCode'] = $shopcode;
            (bool)$isSaved = $this->_saveshop($Ishop);
            if(!$isSaved){
                return $this->res(false,"Error on Saving Data",[],500);
            }
            $shops = (array)$this->_getallshops();
            return $this->res(true,"ok",$shops,200);
        }

        private function _updateshop(array $Ishop):bool{
            $this->sql = "UPDATE shops set shopName = :shopName,shopLocation = :shopLocation,shopCurrencyType = :shopCurrencyType where shopCode = :shopCode";
            $this->cm = $this->cn->prepare($this->sql);
            $isUpdated = $this->cm->execute($Ishop);
            unset($this->sql,$this->cm,$rows);
            return $isUpdated;
        }

        public function UpdateAction(array $Ishop):string{
            
            (bool)$isUpdated = $this->_updateshop($Ishop);
            if(!$isUpdated){
                return $this->res(false,"Error on Update",[],500);
            }
            (array)$shops = $this->_getallshops();
            return $this->res(true,"ok",$shops,200);
        }

        private function _deletecheck(string $shopcode):int{
            $this->sql = "SELECT COUNT(imeiShopCode) as cnt FROM IMEIS where imeiShopCode where imeiShopCode = :imeiShopCode";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":imeiShopCode",$shopcode);
            $this->cm->execute();
            (array)$rows = $this->cm->fetch(PDO::FETCH_ASSOC);
            (int)$cnt = $rows['cnt'];
            unset($this->cm,$this->sql,$rows);
            return $cnt;
        }

        private function _deleteshop(string $shopcode):bool{
            $this->sql = "DELETE FROM shops where shopCode = :shopCode limit 1";
            $this->cm = $this->cn->prpeare($this->sql);
            $this->cm->bindParam(":shopCode",$shopcode);
            (bool)$isDelete = $this->cm->execute();
            unset($this->cm,$this->sql);
            return $isDelete;
        }

        public function DeleteShopAction(string $shopcode):string{
            //check before delete
            (int)$cnt = $this->_deletecheck($shopcode);
            if($cnt !== 0){
                return $this->res(false,"You could not perform this delete action because already some imei or stock entry or sales bill linked with this shop.",[],409);
            } 
            (bool)$isDelete = $this->_deleteshop($shopcode);
            if(!$isDelete){
                return $this->res(false,"Error on Deleting Shop",[],500);
            }
            (array)$shops = $this->_getallshops();
            return $this->res(true,"ok",$shops,200);
        }
    }
?>