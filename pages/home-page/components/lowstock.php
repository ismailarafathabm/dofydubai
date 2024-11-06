<div class="card mb-0" ng-if="lowstockaccess">
    <div class="card-body">
        <h4 class="card-title">Low Stock </h4>
        <div class="table-responsive dataview">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <th>Barcode</th>
                        <th>Product Name</th>
                        <th>Brand Name</th>
                        <th>Category Name</th>
                        <th>Avilable</th>
                        <th>MiniQty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="x in dashboarddata.products.lowStocks">
                        <td>{{$index+1}}</td>
                        <td>{{x.productBarcode}}</td>
                        <td>{{x.productName}}</td>
                        <td>{{x.productBrandName}}</td>
                        <td>{{x.productTypeNamedisp}}</td>
                        <td>{{x.balqty}}</td>
                        <td>{{x.productMinQty}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>