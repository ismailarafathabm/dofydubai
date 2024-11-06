<div class="modal" id="conditiondia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-click="conditionmodel_closemodel($event)">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 550px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{conditionModel.title}}</h5>
                <button type="button" class="close" ng-click="deviceconditionshohide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="modalconditions" id="conditionsmodel" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="productCondition" class="col-form-label">Description</label>
                                <input type="text" class="form-control" id="productCondition" name="productCondition" ng-model="conditionModel.data.productCondition" ng-keydown="movenxtedit($event,'saveconditions')" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="deviceconditionshohide('none')">Close</button>
                    <button type="button" ng-click="devicecondition_action()" class="btn btn-primary" ng-disabled="modalconditions.$invalid">
                        {{conditionModel.mode === 1 ? "Save" : "Update"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>