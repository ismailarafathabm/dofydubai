import API_Services from "../../../src/apiservices.js";
import { ProductModel,ProductModelGrid } from "../models/productmodels.js";
export default function ModelListController($scope) {
    const haveAccessPage = useraccess?.devicesettings?.models?.viewaccess ?? false;
    if (!haveAccessPage) {
        location.href = `${url}/index.php`;
        return;
    }
    $scope.haveAccessnewmodel = useraccess?.devicesettings?.models?.new ?? false;
    // if (useraccess.devicesettings.models.viewaccess) {
    //     location.href = `${url}/index.php`;
    //     return;
    // }
    // $scope.isAccessnewmodel = useraccess.devicesettings.models.new;

    menuactive("product_menu","model_submenu");
    $scope.isLoading = false;
    const apis = new API_Services();
    const cols = ProductModelGrid();
    const gridOptions = apis._gridOptions(cols);
    gridOptions.onCellClicked = onEditClick;
    const gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    gridOptions.api.setRowData([]);

    getallmodels();
    async function getallmodels() {
        if ($scope.isLoading) return;
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.GET(`products/index.php`);
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
    async function onEditClick(event) {
        const { data, colDef } = event;
        
        if (colDef.field === "_edit") {
            EditUserFun(data);
            return;
        }
        if (colDef.field === "_delete") {
            await DeleteItemFun(data._id);
            return;
        }

    }
    async function DeleteItemFun(id) {

        m === "0" ? console.log(id) : "";
        if ($scope.isLoading) return;
        var c = confirm("Are You Sure Remove This Data?");
        if (!c) return;
        $scope.isLoading = true;
        const res = await apis.GET(`products/delete.php?id=${id}`);
        if (!res.isSuccess) {
            alert(res.data);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.$apply();
        return;
        
    }

    $scope.devicemodel = {
        mode : 1,
        title: "Add New Product Model",
        data : ProductModel()
    }
    const productmodal = document.getElementById("productmodal");
    function productmodalshowhidefun(disp) {
        productmodal.style.display = disp;
    }
    productmodalshowhidefun("none");
    $scope.productmodalshowhide = (disp) => productmodalshowhidefun(disp);
    $scope.addnewdevice = () => {
        $scope.devicemodel = {
            mode : 1,
            title: "Add New Product Model",
            data : ProductModel
        }
        
        productmodalshowhidefun("flex");
        document.getElementById("deviceType").focus();
    }

    function EditUserFun(data) {
        $scope.devicemodel = {
            mode: 2,
            title: "Edit Product Informaitons",
            data: data
        }
        productmodalshowhidefun("flex");
        document.getElementById("deviceType").focus();
        $scope.$apply();
    }

    $scope.movenxtedit = async ($event, nxt) => {
        if ($event.which === 27) {
            productmodalshowhidefun("none");
            return;
        }
        if ($event.which === 13) {
            if (nxt === "product_actions") {
                await productSaveUpdatefun();   
            } else {
                const ele = document.getElementById(nxt);
                ele.focus();ele.select();
                
            }
        }
    }
    $scope.devicemodel_action = async () => productSaveUpdatefun();
    async function productSaveUpdatefun() {
        if ($scope.isLoading) return;
        if ($scope.devicemodel.mode === 1) {
            await ProductSave();
            return;
        }
        await ProductUpdate();
        return;
    }

    async function ProductSave() {
        const fd = new FormData(
            document.getElementById("productmodelid")
        );
        $scope.isLoading = true;
        const res = await apis.POST(`products/new.php`, fd);
        if (!res?.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        alert("data has Saved")
        $scope.devicemodel = {
            mode : 1,
            title: "Add New Product Model",
            data : ProductModel()
        }
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.$apply();
        document.getElementById("deviceType").focus();
        return;
    }

    async function ProductUpdate() {
        const fd = new FormData(
            document.getElementById("productmodelid")
        );
        $scope.isLoading = true;
        const res = await apis.POST(`products/update.php?id=${$scope.devicemodel.data._id}`, fd);
        if (!res?.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        alert("data has updated");
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.$apply();
        document.getElementById("deviceType").focus();
        return;
    }

    $scope.productmodeldia_closemodal = ($event) => {
        var target = $($event.target);
        if (!target.closest('.modal-dialog').length && !target.closest('[data-toggle="modal"]').length) {
            console.log("called");
            productmodalshowhidefun("none");
        }
    }

}