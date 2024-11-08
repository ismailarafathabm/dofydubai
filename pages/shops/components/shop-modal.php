<div class="modal" id="shopmodaldia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-click="shopmodaldia_closemodal($event)">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{shopmodel.title}}</h5>
                <button type="button" class="close" ng-click="shopmodaldiashohide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="shopmodel" id="shopmodelid" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="shopCode" class="col-form-label">Code</label>
                                <input type="text" class="form-control" id="shopCode" name="shopCode" ng-model="shopmodel.data.shopCode" ng-keydown="shopkeypress($event,'shopName')" required ng-readonly="shopmodel.mode === 2"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="shopName" class="col-form-label">Name</label>
                                <input type="text" class="form-control" id="shopName" name="shopName" ng-model="shopmodel.data.shopName" ng-keydown="shopkeypress($event,'shopLocation')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="shopLocation" class="col-form-label">Location</label>
                                <input type="text" class="form-control" id="shopLocation" name="shopLocation" ng-model="shopmodel.data.shopLocation" ng-keydown="shopkeypress($event,'shopCurrencyType')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="shopCurrencyType" class="col-form-label">Currency Type</label>
                                
                                <select class="form-control" id="shopCurrencyType" name="shopCurrencyType" ng-model="shopmodel.data.shopCurrencyType" ng-keydown="shopkeypress($event,'saveshop_action')" required>
                                    <option value="">-select-</option>
                                    <option ng-repeat="x in currencyTypes" value="{{x}}">{{x | uppercase}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="shopmodaldiashohide('none')">Close</button>
                    <button type="button" ng-click="newshop_save()" class="btn btn-primary" ng-disabled="productmodel.$invalid">
                        {{shopmodel.mode === 1 ? "Save" : "Update"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>