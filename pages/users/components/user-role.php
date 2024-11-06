<style>
    .table tr {
        word-break: break-all;
    }
</style>
<div class="modal" id="useraccessModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">User Access</h5>
                <button type="button" class="close" ng-click="useraccessmodalshowhide('none')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form name="useraccessave" id="saveuseraccess">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12" style="max-height: 400px;overflow: auto;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Pages - Functions</th>
                                        <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Home Page - Summary</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.homepagesummary">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Home Page - Low Stock</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.homepagelowstock">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sales - new</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.salesnew">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sales - View</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.salesview">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sales - Edit</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.salesedit">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Purchase - New</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.purchasenew">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Purchase - View</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.purchaseview">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Purchase - Edit</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.purchaseedit">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Product - View</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.productview">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Product - New</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.productnew">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Product - Edit</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.productedit">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Product - Remove</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.productremove">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Supplier - View</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.supplierview">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Supplier - New</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.suppliernew">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Customer - View</td>
                                        <td>
                                            <input type="checkbox" ng-model="useraccess.customerview">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="useraccessmodalshowhide('none')">Close</button>
                    <button type="button" ng-click="saveuseraccess_fun()" class="btn btn-primary" ng-disabled="useraccessave.$invalid">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>