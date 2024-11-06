<div class="modal" id="kitdiamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-click="kitstatusdia_closemodal($event)">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 550px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{kitdia.title}}</h5>
                <button type="button" class="close" ng-click="kitdiamodalshowhide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="kitdiasave" id="savekitdai" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="kitCode" class="col-form-label">Code</label>
                                <input type="text" class="form-control" id="kitCode" name="kitCode" ng-model="kitdia.data.kitCode" ng-keydown="movenxtkitdia($event,'kitType')" required/>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="kitType" class="col-form-label">Description</label>
                                <input type="text" class="form-control" id="kitType" name="kitType" ng-model="kitdia.data.kitType" ng-keydown="movenxtkitdia($event,'savekits')" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="kitdiamodalshowhide('none')">Close</button>
                    <button type="button" ng-click="divicekit_action()" class="btn btn-primary" ng-disabled="kitdiasave.$invalid">
                        {{kitdia.mode === 1 ? "Save" : "Update"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>