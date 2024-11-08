import API_Services from "../../../src/apiservices.js";
import { shopModelGrid, newShopModel } from './../models/shopmodels.js';
export default function ShopListControllers($scope) {
    //access menu 
    const haveAccessShopListPage = useraccess?.shops?.view ?? false;
    if (!haveAccessShopListPage) {
        location.href = `${url}/index.php`;
        return;
    }
    menuactive("shop_menu","");
    $scope.haveAccessAddNewShop = useraccess?.shops?.new ?? false;

    $scope.isLoading = false;
    const apis = new API_Services();
    const cols = shopModelGrid();
    const gridOptions = apis._gridOptions(cols);
    gridOptions.onCellClicked = onEditClick;
    const gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    gridOptions.api.setRowData([]);
    $scope.currencyTypes = [];
    getAllCurrencyTypes();
    async function getAllCurrencyTypes() {
        if ($scope.isLoading) return;
        try {
            const req = await fetch(`${url}/api/currencys/currency.json`);
            console.log(req);
            if (req.status === 200) {
                const ctypes = await req.json();
                $scope.currencyTypes = ctypes;
                $scope.$apply();
                m === "0" ? console.log($scope.currencyTypes) : "";

            } else {
                m === "0" ? console.log("Error") : "";
            }
        } catch (e) {
            m === "0" ? console.log(e.message) : "";
        }
       
    }
    GetAllShops();
    async function GetAllShops() {
        if ($scope.isLoading) return;
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.GET(`shops/index.php`);
        if (!res?.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false; 
        $scope.$apply();
        return;
    }

    const shopmodaldia = document.getElementById("shopmodaldia");
    function shopmodaldiashowhideFun(disp){
        shopmodaldia.style.display = disp;
    }
    $scope.shopmodaldiashohide = (disp) => shopmodaldiashowhideFun(disp);
    shopmodaldiashowhideFun("none")
    async function onEditClick(event) {
        const { data, colDef } = event;
        if (colDef.field === '_edit') {
            EditShopFun(data);
            return;
        }
        if (colDef.field === "_delete") {
            DeleteShopFun(data.shopCode);
            return;
        }
        
    }
    
    $scope.shopmodel = {
        mode: 1,
        title: "Add New Shop",
        data: newShopModel()
    };
    $scope.addnewshop = () => {
        $scope.shopmodel = {
            mode: 1,
            title: "Add New Shop",
            data: newShopModel()
        };
        shopmodaldiashowhideFun("flex");
        document.getElementById("shopCode").focus();
        return;
    }
    function EditShopFun(data) {
        $scope.shopmodel = {
            mode: 2,
            title: "Edit Shop Informatoins",
            data: data
        };
        shopmodaldiashowhideFun("flex");
        document.getElementById("shopName").focus();
        $scope.$apply();
        return;
    }
    $scope.shopkeypress = async ($event, nxt) => {
        if ($event.which === 27) {
            shopmodaldiashowhideFun("none");
            return;
        }
        if ($event.which === 13) {
            if (nxt === "saveshop_action") {
                await ShopActions();
                return;
            } else {
                const ele = document.getElementById(nxt);
                ele.focus();
                if (nxt !== "shopCurrencyType") {
                    ele.select();
                }
                return;
            }
        }
    }
    $scope.newshop_save = async () => await ShopActions();
    async function ShopActions() {
        if ($scope.isLoading) return;
        if ($scope.shopmodel.mode === 1) {
            await ShopSaveAction();
            return;
        }
        await ShopUpdateAction();
        return;

    }

    async function ShopSaveAction() {
        const frm = document.getElementById("shopmodelid");
        const fd = new FormData(frm);
        $scope.isLoading = true;
        const res = await apis.POST(`shops/new.php`, fd);
        if (!res?.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false; 
        $scope.shopmodel = {
            mode: 1,
            title: "Add New Shop",
            data: newShopModel()
        };
        document.getElementById("shopCode").focus();
        $scope.$apply();
        return;

    }

    async function ShopUpdateAction() {
        const frm = document.getElementById("shopmodelid");
        const fd = new FormData(frm);
        $scope.isLoading = true;
        const res = await apis.POST(`shops/update.php?shop=${$scope.shopmodel.data.shopCode}`, fd);
        if (!res?.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false; 
        document.getElementById("shopName").focus();
        $scope.$apply();
        return;
    }

    async function DeleteShopFun(id) {

        m === "0" ? console.log(id) : "";
        if ($scope.isLoading) return;
        var c = confirm("Are You Sure Remove This Data?");
        if (!c) return;
        $scope.isLoading = true;
        const res = await apis.GET(`shops/delete.php?shopCode=${id}`);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.$apply();
        return;
        
    }

    $scope.shopmodaldia_closemodal = ($event) => {
        var target = $($event.target);
        if (!target.closest('.modal-dialog').length && !target.closest('[data-toggle="modal"]').length) {
            
            shopmodaldiashowhideFun("none")
        }
    } 

}