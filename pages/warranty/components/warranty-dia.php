<div class="modal" id="warrantydia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-click="warrantydia_closemodel($event)"> 
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 550px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{warrantymodel.title}}</h5>
                <button type="button" class="close" ng-click="warrantydiashowhide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="warranymodel" id="modelwarranty" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="warranty" class="col-form-label">Description</label>
                                <input type="text" class="form-control" id="warranty" name="warranty" ng-model="warrantymodel.data.warranty" ng-keydown="movenxtwarrany($event,'saveconditions')" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="warrantydiashowhide('none')">Close</button>
                    <button type="button" ng-click="savewarranty_action()" class="btn btn-primary" ng-disabled="warranymodel.$invalid">
                        {{warrantymodel.mode === 1 ? "Save" : "Update"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>