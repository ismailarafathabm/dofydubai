<div class="row" ng-show="summaryaccess">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget">
            <div class="dash-widgetimg">
                <span><img src="assets/img/icons/dash1.svg" alt="img" /></span>
            </div>
            <div class="dash-widgetcontent">
                <h5>
                    <span class="counters" >{{dashboarddata.purchase.countOfPurhcase}}</span>
                </h5>
                <h6>Total Purchase</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget dash1">
            <div class="dash-widgetimg">
                <span><img src="assets/img/icons/dash2.svg" alt="img" /></span>
            </div>
            <div class="dash-widgetcontent">
                <h5>
                    <span class="counters">{{(+dashboarddata.purchase.sumOfPurchase).toLocaleString(undefined,{maximumFractionDigits:2})}}</span>
                </h5>
                <h6>Total Purchase Amount</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget dash2">
            <div class="dash-widgetimg">
                <span><img src="assets/img/icons/dash3.svg" alt="img" /></span>
            </div>
            <div class="dash-widgetcontent">
                <h5>
                    <span class="counters">{{dashboarddata.sales.cntBills}}</span>
                </h5>
                <h6>Total Sale Bills</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="dash-widget dash3">
            <div class="dash-widgetimg">
                <span><img src="assets/img/icons/dash4.svg" alt="img" /></span>
            </div>
            <div class="dash-widgetcontent">
                <h5>
                    <span class="counters" >{{(+dashboarddata.sales.sumofBills).toLocaleString(undefined,{maximumFractionDigits:2})}}</span>
                </h5>
                <h6>Total Sale Amount</h6>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count">
            <div class="dash-counts">
                <h4>{{dashboarddata.sales.cntCustomer}}</h4>
                <h5>Customers</h5>
            </div>
            <div class="dash-imgs">
                <i data-feather="user"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count das1">
            <div class="dash-counts">
                <h4>{{dashboarddata.suppliers.countOfSuppliers}}</h4>
                <h5>Suppliers</h5>
            </div>
            <div class="dash-imgs">
                <i data-feather="user-check"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count das2">
            <div class="dash-counts">
                <h4>{{dashboarddata.purchase.countOfPurhcase}}</h4>
                <h5>Purchase Invoice</h5>
            </div>
            <div class="dash-imgs">
                <i data-feather="file-text"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12 d-flex">
        <div class="dash-count das3">
            <div class="dash-counts">
                <h4>{{dashboarddata.sales.cntBills}}</h4>
                <h5>Sales Invoice</h5>
            </div>
            <div class="dash-imgs">
                <i data-feather="file"></i>
            </div>
        </div>
    </div>
</div>