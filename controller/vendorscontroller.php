<?php
require_once "mac.php";
class VendorsController extends mac
{
    private object $cn;
    private object $cm;
    private string $sql;
    function __construct($db)
    {
        $this->cn = $db;
    }

    private function IVendors(array $rows): array
    {
        (array)$cols = [];
        extract($rows);
        $cols['_id'] = $_id;
        $cols['vendorCode'] = $vendorCode;
        $cols['vendorName'] = $vendorName;
        $cols['vendorPhone'] = $vendorPhone;
        $cols['vendorAddress'] = $vendorAddress;
        $cols['status'] = $status;
        $cols['cBy'] = $cBy;
        $cols['eBy'] = $eBy;
        $cols['cDate'] = $cDate;
        $cols['eDate'] = $eDate;
        return $cols;
    }

    private function _getallvendors(bool $haveaccessprice = false): array
    {
        $this->sql = "SELECT *FROM vendors order by vendorName asc";
        $this->cm = $this->cn->prepare($this->sql);
        $this->cm->execute();
        (array)$vendors = [];
        while ($rows = $this->cm->fetch(PDO::FETCH_ASSOC)) {
            (array)$vendor = $this->IVendors($rows);
            $vendors[] = $vendor;
        }
        unset($this->sql, $this->cm, $rows);
        return $vendors;
    }

    public function GetAllVendors(bool $haveaccessprice = false)
    {
        (array)$vendors = $this->_getallvendors($haveaccessprice);
        return $this->res(true, "ok", $vendors, 200);
    }

    private function _checkvendor(string $vendorCode): int
    {
        $this->sql = "SELECT COUNT(vendorCode) as cnt from vendors where vendorCode = :vendorCode";
        $this->cm = $this->cn->prepare($this->sql);
        $this->cm->bindParam(":vendorCode", $vendorCode);
        $this->cm->execute();
        (array)$rows = $this->cm->fetch(PDO::FETCH_ASSOC);
        (int)$cnt = $rows['cnt'];
        unset($this->sql, $this->cm, $rows);
        return $cnt;
    }

    private function _saveVendor(array $Ivendor, bool $haveaccessprice = false): bool
    {
        $this->sql = "INSERT INTO vendors values(
                null,
                :vendorCode,
                :vendorName,
                :vendorPhone,
                :vendorAddress,
                :cBy,
                :eBy,
                now(),
                now()
            )";
        $this->cm = $this->cn->prepare($this->sql);
        $isSaved = $this->cm->execute($Ivendor);
        unset($this->sql, $this->cm);
        return $isSaved;
    }

    public function SaveAction(array $Ivendor, bool $ac = false): string
    {
        $vendorcode = $Ivendor[':vendorCode'];
        (int) $cnt = $this->_checkvendor($vendorcode);
        if ($cnt !== 0) {
            return $this->res(false, "Dublicate found", [], 409);
        }
        (bool)$isSaved = $this->_saveVendor($Ivendor);
        if (!$isSaved) {
            return $this->res(true, "Error on saving data", [], 500);
        }
        (array)$vendors = $this->_getallvendors($ac);
        return $this->res(true, "ok", $vendors, 200);
    }
    private function _updateVendor(array $Ivendor): bool
    {
        $this->sql = "UPDATE vendor set vendorName = :vendorName, 
            vendorPhone = :vendorPhone,
            vendorAddress = :vendorAddress,
            status = :status,
            eBy = :eBy,
            eDate = now() 
            where 
            vendorCode = :vendorCode";
        $this->cm = $this->cn->prepare($this->sql);
        (bool) $isUpdate = $this->cm->execute($Ivendor);
        unset($this->sql, $this->cm);
        return $isUpdate;
    }

    public function updateAction(array $Ivendor, bool $a): string
    {
        (bool)$isUpdated = $this->_updateVendor($Ivendor);
        if (!$isUpdated) {
            return $this->res(false, "Error on Update", [], 500);
        }
        (array)$vendors = $this->_getallvendors($a);
        return $this->res(true, "ok", $vendors, 200);
    }

    private function _deleteVendor(string $vendorCode): string
    {
        try {
            $this->sql = "DELETE FROM vendors where vendorCode = :vendorCode limit 1";
            $this->cm = $this->cn->prepare($this->sql);
            $this->cm->bindParam(":vendorCode", $vendorCode);
            (bool)$isDeleted = $this->cm->execute();
            unset($this->sql, $this->cm);
            return $isDeleted ? "ok" : "Error on update" ;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function DeleteAction(string $vendorCode, bool $a = false): string
    {
        //check delete 

        (string)$isDeleted = $this->_deleteVendor($vendorCode);
        if ($isDeleted !== "ok") {
            return $this->res(false, $isDeleted, [], 500);
        }
        (array)$vendors = $this->_getallvendors($a);
        return $this->res(true, "ok", $vendors, 200);
    }
}
