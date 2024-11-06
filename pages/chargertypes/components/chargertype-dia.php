<div class="modal" id="chargertypedia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" ng-click="chargertypemodal_closemodel($event)">
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 550px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{chargertypemodel.title}}</h5>
                <button type="button" class="close" ng-click="chargertypediashowhide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="modelchargertype" id="chargertypemodel" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="chargerType" class="col-form-label">Charger Type</label>
                                <input type="text" class="form-control" id="chargerType" name="chargerType" ng-model="chargertypemodel.data.chargerType" ng-keydown="movenxtchargertype($event,'saveconditions')" required/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="chargertypediashowhide('none')">Close</button>
                    <button type="button" ng-click="chargertype_actions()" class="btn btn-primary" ng-disabled="modelchargertype.$invalid">
                        {{chargertypemodel.mode === 1 ? "Save" : "Update"}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>