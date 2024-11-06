<?php
include_once './../../../db/conf.php';
session_start();
$gbuser = !isset($_SESSION['gbusername']) || trim($_SESSION['gbusername']) === "" ? "" : trim($_SESSION['gbusername']);
$gbtoken = !isset($_SESSION['gbtoken']) || trim($_SESSION['gbtoken']) === "" ? "" : trim($_SESSION['gbtoken']);
$gbrole = !isset($_SESSION['gbrole']) || trim($_SESSION['gbrole']) === "" ? "" : trim($_SESSION['gbrole']);
if ($gbuser === "") {
?>
  <script>
    location.href = "<?php echo $url ?>login.php";
  </script>
<?php
  exit();
}

?>
<div class="content">
  <div class="page-header">
    <div class="page-title">
      <h4>Dashboard</h4>

    </div>
    <div ng-show="summaryaccess" class="page-btn" style="
        display: flex;
    flex-direction: row;
    /* align-items: center; */
    justify-content: start;
    gap: 10px;
        ">
      <div class="form-group">
        <div style="width: 100%;">
          <input type="text" ng-model="dashboard.stdate" class="form-control" placeholder="dd-mm-yyyy" ng-hijri-gregorian-datepicker datepicker-config="gregorianDatepickerConfig" selected-date="val_arrivaldate" />
        </div>
      </div>
      <div class="form-grooup">
        <div style="width: 100%;">
          <input type="text" ng-model="dashboard.enddate" class="form-control" placeholder="dd-mm-yyyy" ng-hijri-gregorian-datepicker datepicker-config="gregorianDatepickerConfig" selected-date="val_xarrivaldate" />
        </div>
      </div>
      <button ng-click="getrpt()" type="button" class="btn btn-added"><img src="assets/img/icons/purchase1.svg" alt="img" class="me-1">GET</button>
    </div>
  </div>
  <?php
  include_once './toppage.php';
  include_once './lowstock.php';
  ?>
</div>