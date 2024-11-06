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
<div id="global-loader" ng-show="isLoading">
    <div class="whirly-loader"> </div>
</div>
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Password</h4>
            <h6>Change Password Wizard</h6>
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" style="height: 100%;">
                        <div style="display: flex;flex-direction: column;align-items: center;justify-content: center;width: 100%;">  
                            <form name="changepasswordfrm" id="passwordchangefrm">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="brandName" class="col-form-label">Current Password</label>
                                            <input type="text" class="form-control" id="currentpassword" name="currentpassword" ng-model="changepass.currentpassword" ng-keydown="movenxt($event,'userId')" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label for="brandName" class="col-form-label">New Password</label>
                                            <input type="text" class="form-control" id="newpassword" name="newpassword" ng-model="changepass.newpassword" ng-keydown="movenxt($event,'userId')" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-6 col-12">
                                        <div class="form-group" style="margin-top:22px">
                                            <button class="btn btn-primary" type="button" ng-disabled="changepasswordfrm.$invalid" ng-click="changepassword()" style="width: 100%;">
                                                <i class="fa fa-check"></i>
                                                Change Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once './user-new.php';
include_once './user-role.php';
?>