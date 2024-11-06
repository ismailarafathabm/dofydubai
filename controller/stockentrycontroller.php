<?php 
 include_once 'mac.php';
 class StockEntryController extends mac{
    private $cn,$cm,$sql;
    function __construct($db)
    {
        $this->cn = $db;
    }

    private function statustxt($status){
        $statuslist = ['In-Stock','Sold','Transfer'];
        return $statuslist[$status];
    }
    private function IstockEntrys(array $rows,bool $priceaccess = false):array{
        extract($rows);
        $cols = [];
        $cols['_id'] = $_id;
        $cols['stockDate'] = $stockDate;
        $cols['stockDates'] = $this->datemethod($stockDate);
        $cols['productModel'] = $productModel;
        $cols['productImei'] = $productImei;
        $cols['productCondition'] = $productCondition;
        $cols['productBattery'] = $productBattery;
        $cols['productDisplaySize'] = $productDisplaySize;
        $cols['productProcessor'] = $productProcessor;
        $cols['productCharger'] = $productCharger;
        $cols['productKit'] = $productKit;
        $cols['cBy'] = $cBy;
        $cols['eBy'] = $eBy;
        $cols['cDate'] = $cDate;
        $cols['eDate'] = $eDate;
        $cols['status'] = $status;
        $cols['statusTxt'] = $this->statustxt($status);
        $cols['devicePrice'] = $priceaccess ? $devicePrice : '0';
        $cols['priceType'] = $priceType;
        $cols['shopCode'] = $shopCode;
        return $cols;
    }

    private function _getstockEntry(array $params):array{
        $this->sql = "SELECT ste.*,
        dm.deviceType,
        dm.deviceBrand,
        dm.deviceModel,
        dm.deviceRamRom,
        dm.deviceFullName,
        pcn.productCondition,
        kt.kitCode,
        kt.kitType,
        w.warranty,
        IFNULL(ct.chargerType,'-') as chargertypeName
        FROM stockEntrys as ste
        inner join deviceModels as dm on ste.productModel = dm._id 
        inner join productConditions as pcn on ste.productCondition = pcn._id 
        inner join kitTypes as kt on ste.productKit = kt._id 
        inner join warrantys as w on ste.productWarranty = w._id 
        left join chargerTypes as ct on ste.productCharger = ct._id 
         where stockDate >= :stdate and stockDate <= :enddate order by stockDate desc";
        $this->cm = $this->cn->prepare($this->sql);
        $this->cm->execute($params);
        $stockEntrys = [];
        while($rows = $this->cm->fetch(PDO::FETCH_ASSOC)){
            $stockEntry = (array)$this->IstockEntrys($rows);
            extract($rows);
            $stockEntry['deviceType'] = $deviceType;
            $stockEntry['deviceBrand'] = $deviceBrand;
            $stockEntry['deviceModel'] = $deviceModel;
            $stockEntry['deviceRamRom'] = $deviceRamRom;
            $stockEntry['deviceFullName'] = $deviceFullName;
            $stockEntry['productCondition'] = $productCondition;
            $stockEntry['kitCode'] = $kitCode;
            $stockEntry['kitType'] = $kitType;
            $stockEntry['warranty'] = $warranty;
            $stockEntry['chargertypeName'] = $chargertypeName;
            $stockEntrys[] = $stockEntry;
        }
        unset($this->sql,$this->cm,$rows);
        return $stockEntrys;
        
    }

    public function GetAllStockEntry(array $params):string{
        $stockEntrys = (array) $this->_getstockEntry($params);
        return $this->res(true,"ok",$stockEntrys,200);
        exit;
    }

    //for save action

    private function _checkimeistatus(string $imeino):int{
        $this->sql = "SELECT COUNT(imeiNo) as cnt FROM IMEIS where imeiNo = :imeiNo and imeiStatus in (1,3)";
        $this->cm = $this->cn->prepare($this->sql);
        $this->cm->bindParam(":imeiNo",$imeino);
        $this->cm->execute();
        $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
        $cnt = (int)$rows['cnt'];
        unset($this->sql,$this->cm,$rows);
        return $cnt;
    }

    private function _checkimei(string $imeino):int{
        $this->sql = "SELECT COUNT(imeiNo) as cnt FROM IMEIS where imeiNo = :imeiN";
        $this->cm = $this->cn->prepare($this->sql);
        $this->cm->bindParam(":imeiNo",$imeino);
        $this->cm->execute();
        $rows = $this->cm->fetch(PDO::FETCH_ASSOC);
        $cnt = (int)$rows['cnt'];
        unset($this->sql,$this->cm,$rows);
        return $cnt;
    }

    private function _saveStockEntry(array $IstockEntry):bool{
        $this->sql = "INSERT INTO stockEntrys values(
            null,
            :stockDate,
            :productModel,
            :productImei,
            :productCondition,
            :productBattery,
            :productDisplaySize,
            :productProcessor,
            :productCharger,
            :productKit,
            :productWarranty,
            :cBy,
            :eBy,
            now(),
            now(),
            1,
            :devicePrice,
            :priceType,
            :shopCode
        )";
        $this->cm = $this->cn->prepare($this->sql);
        $isSavedstockEntry = $this->cm->execute($IstockEntry);
        unset($this->sql,$this->cm,$rows);
        return $isSavedstockEntry;
    }

    private function _saveImeis(array $Iimeis):bool{
        $this->sql = "INSERT INTO IMEIS values(
            null,
            :imeiNo,
            :imeiModel,
            :imeiCondition,
            :imeiBattery,
            :imeiDisplaySize,
            :imeiProcessor,
            :imeiChargerType,
            :imeiKitStatus,
            :imeiNlc,
            :imeiMxprice,
            :imeiSoldPrice,
            :imeiCurrencyType,
            :imeiStockInDate,
            1,
            '',
            '',
            :imeiShopCode,
            :cBy,
            :eBy,
            now(),
            now
        )";
        $this->cm = $this->cn->prepare($this->sql);
        $isSavedImei = $this->cm->execute($Iimeis);
        unset($this->sql,$this->cm,$rows);
        return $isSavedImei;
    }

    private function _updateimei(array $Iimeis){
        $this->sql = "UPDATE IMIES set 
        imeiModel = :imeiModel,
        imeiCondition = :imeiCondition,
        imeiBattery = :imeiBattery,
        imeiDisplaySize = :imeiDisplaySize,
        imeiProcessor = :imeiProcessor,
        imeiChargerType = :imeiChargerType,
        imeiKitStatus = :imeiKitStatus,
        imeiNlc = :imeiNlc,
        imeiMxprice = :imeiMxprice,
        imeiSoldPrice = :imeiSoldPrice,
        imeiCurrencyType = :imeiCurrencyType,
        imeiStockInDate = :imeiStockInDate,
        imeiStatus = :imeiStatus,
        imeiSoldDate = '',
        imeisoldInvoiceNo = '',
        imeiShopCode = :imeiShopCode,
        eBy = :eBy,
        eDate = now() 
        where 
        imeiNo = :imeiNo";
        $this->cm = $this->cn->prepare($this->sql);
        $isUpdateImeiinfo = $this->cm->execute($Iimeis);
        unset($this->sql,$this->cm,$rows);
        return $isUpdateImeiinfo;
    }

    public function SaveAction(array $Ipurchase,array $Iimeis,array $Iimeiupdate){
        //check imei status
        (string)$imei = (string)$Ipurchase[':productImei'];
        $cnt = (int)$this->_checkimeistatus($imei);
        if($cnt !== 0){
            return $this->res(false,"Dublicate IMEI Found",[],409);
            exit;
        }
        $saveStockEntry = $this->_saveStockEntry($Ipurchase);
        if(!$saveStockEntry){
            return $this->res(false,"Error on Saving Stock Entry",[],500);
            exit;
        }
        $cnt_imei = $this->_checkimei($imei);
        if($cnt_imei === 0){
            //save new imei 
            $issaveImei = $this->_saveImeis($Iimeis);
            if(!$issaveImei){
                return $this->res(false,"Saved , but Error on saving Imei Informations",[],500);
                exit;
            }
            return $this->res(true,"ok",[],200);
        }else{
            (bool) $isUpdateimei = (bool)$this->_updateimei($Iimeiupdate);
            if(!$isUpdateimei){
                echo $this->res(false,"Saved, But Error on Update Imei Informaitons",[],500);
                exit;
            }
            return $this->res(true,"ok",[],200);
        }
    }
 }
?>