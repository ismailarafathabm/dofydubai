<div class="modal" id="newuserModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New User</h5>
                <button type="button" class="close" ng-click="newusermodalshowhide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="newuser" id="savenewuser" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="brandName" class="col-form-label">User Display Name</label>
                                <input type="text" class="form-control" id="userName" name="userName" ng-model="newuser.userName" ng-keydown="movenxt($event,'userId')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="brandName" class="col-form-label">User Id</label>
                                <input type="text" class="form-control" id="newuser" name="newuser" ng-model="newuser.userId" ng-keydown="movenxt($event,'userPass')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="brandName" class="col-form-label">Password</label>
                                <input type="text" class="form-control" id="userPass" name="userPass" ng-model="newuser.userPass" ng-keydown="movenxt($event,'shopCode')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="shopCode" class="col-form-label">Shop</label>
                                <select type="text" class="form-control" id="shopCode" name="shopCode" ng-model="newuser.shopCode" ng-keydown="movenxt($event,'saveUser')" required>
                                    <option value="">-select-</option>
                                    <option value="dubai1">Dubai-1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="newusermodalshowhide('none')">Close</button>
                    <button type="button" ng-click="savenewuser_fun()" class="btn btn-primary" ng-disabled="newuser.$invalid">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>