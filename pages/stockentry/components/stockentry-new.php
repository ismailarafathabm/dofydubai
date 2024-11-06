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
            <h4>Stock Entry</h4>

        </div>
        <div class="page-btn">

        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Date </label>
                        <div class="input-groupicon" style="width: 100%;">
                            <input
                                type="text"
                                placeholder="dd-mm-yyyy" ng-hijri-gregorian-datepicker datepicker-config="gregorianDatepickerConfig" selected-date="val_arrivaldate"
                                class="form-control" id="stockDate" name="stockDate" ng-model="stockentry.stockDate" ng-keydown="movenextstockentryform($event,'shopCode')" />
                            <div class="addonset">
                                <img src="assets/img/icons/calendars.svg" alt="img" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Shop Code</label>
                        <select class="form-control" type="text" id="shopCode" name="shopCode" ng-model="stockentry.shopCode" ng-keydown="movenextstockentryform($event,'priceType')">
                            <option value="">-select-</option>
                            <option value="dubai1">Dubai - 1</option>
                        </select>

                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Currency Type</label>
                        <select class="form-control" type="text" id="priceType" name="priceType" ng-model="stockentry.priceType" ng-keydown="movenextstockentryform($event,'search_productQty')">
                            <option value="">-select-</option>
                            <option value="INR"><span>&#8377;</span> INR</option>
                            <option value="AED">AED</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card" style="margin-top:20px">

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-8 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Product</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">

                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="form-group">
                                <label>IMEI No :</label>
                                <div class="input-groupicon">
                                    <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                                    <div class="addonset">
                                        <img src="assets/img/icons/scanners.svg" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Type</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')" readonly>

                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Brand</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Model</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Ram/Rom</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Device Condition</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Battery %</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Display Size </label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Processor </label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Charger Type </label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>NLC</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Sprice</label>
                                <Input class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-6 col-12">
                            <div class="form-group">
                                <label>No of Prints </label>
                                <select class="form-control" id="search_productQty" name="productQty" ng-model="searchitem.productQty" type="text" ng-keydown="searchitemaddtolist($event,'purchasePrice')">
                                    <option value="">-select-</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1 col-sm-6 col-12">
                            <div class="form-group">
                                <button type="button" ng-click="additemtolist()" class="btn btn-primary" style="margin-top:20px">
                                    <i class="fa fa-plus"></i>
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>