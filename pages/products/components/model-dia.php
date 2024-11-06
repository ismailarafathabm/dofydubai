<div class="modal" id="productmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-click="productmodeldia_closemodal($event)">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{devicemodel.title}}</h5>
                <button type="button" class="close" ng-click="productmodalshowhide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="productmodel" id="productmodelid" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="deviceType" class="col-form-label">Type</label>
                                <input type="text" class="form-control" id="deviceType" name="deviceType" ng-model="devicemodel.data.deviceType" ng-keydown="movenxtedit($event,'deviceBrand')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="deviceBrand" class="col-form-label">Brand</label>
                                <input type="text" class="form-control" id="deviceBrand" name="deviceBrand" ng-model="devicemodel.data.deviceBrand" ng-keydown="movenxtedit($event,'deviceModel')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="deviceModel" class="col-form-label">Model</label>
                                <input type="text" class="form-control" id="deviceModel" name="deviceModel" ng-model="devicemodel.data.deviceModel" ng-keydown="movenxtedit($event,'deviceRamRom')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="deviceRamRom" class="col-form-label">RAM/ROM</label>
                                <input type="text" class="form-control" id="deviceRamRom" name="deviceRamRom" ng-model="devicemodel.data.deviceRamRom" ng-keydown="movenxtedit($event,'product_actions')" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="productmodalshowhide('none')">Close</button>
                    <button type="button" ng-click="devicemodel_action()" class="btn btn-primary" ng-disabled="productmodel.$invalid">
                        {{devicemodel.mode === 1 ? "Save" : "Update"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>