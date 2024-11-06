<div class="modal" id="edituserModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update User Informations</h5>
                <button type="button" class="close" ng-click="edituserModalshowhide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="updateuser" id="userupdate" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="brandName" class="col-form-label">User Display Name</label>
                                <input type="text" class="form-control" id="edit_userName" name="edit_userName" ng-model="edituser.userName" ng-keydown="movenxtedit($event,'edit_userPass')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="brandName" class="col-form-label">User Id</label>
                                <input type="text" class="form-control" id="edit_userId" name="edit_userId" ng-model="edituser.userId" ng-keydown="movenxtedit($event,'edit_userPass')" required readonly/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="brandName" class="col-form-label">Password</label>
                                <input type="text" class="form-control" id="edit_userPass" name="edit_userPass" ng-model="edituser.userPass" ng-keydown="movenxtedit($event,'edit_userStatus')" required/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="brandName" class="col-form-label">Status</label>
                                <select type="text" class="form-control" id="edit_userStatus" name="edit_userStatus" ng-model="edituser.userStatus" ng-keydown="movenxtedit($event,'edit_shopCode')" required>
                                    <option value="1">Active</option>
                                    <option value="0">In-Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="edit_shopCode" class="col-form-label">Shop</label>
                                <select type="text" class="form-control" id="edit_shopCode" name="edit_shopCode" ng-model="edituser.shopCode" ng-keydown="movenxt($event,'saveUser')" required>
                                    <option value="">-select-</option>
                                    <option value="dubai1">Dubai-1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="edituserModalshowhide('none')">Close</button>
                    <button type="button" ng-click="updateuser_fun()" class="btn btn-primary" ng-disabled="updateuser.$invalid">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>