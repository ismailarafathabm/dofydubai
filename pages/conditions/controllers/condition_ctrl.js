import API_Services from "../../../src/apiservices.js";
import { conditionGrid,newConditionModel } from "../models/conditionmodel.js";
export default function ConditionController($scope) {
    const haveaccessconditionpage = useraccess?.devicesettings?.conditions?.viewaccess ?? false;
    if (!haveaccessconditionpage) {
        location.href = `${url}/index.php`;
        return;
    }
    $scope.haveaccessnewcondition = useraccess?.devicesettings?.conditions?.new ?? false;
    menuactive("product_menu","condition_submenu");
    $scope.isLoading = false;
    const apis = new API_Services();
    const cols = conditionGrid();
    const gridOptions = apis._gridOptions(cols);
    gridOptions.onCellClicked = onEditClick;
    const gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    gridOptions.api.setRowData([]);
    async function onEditClick(event) {
        m === '0' ? console.log(event) : '';
        const { data, colDef } = event;
        if (colDef.field === "_edit") {
            EditUserFun(data);
        }
        if (colDef.field === "_delete") {
            await DeleteItemFun(data._id);
            return;
        }
    }
    function EditUserFun(data) {
        m === "0" ? console.log(data) : "";
        conditiondiashowhidefun("flex");
        $scope.conditionModel = {
            mode: 2,
            title: "Edit Device Condition",
            data : data
        }
        $scope.$apply();
        document.getElementById("productCondition").focus();
        document.getElementById("productCondition").select();
    }
    $scope.conditionModel = {
        mode : 1,
        title: "Add New Device Condition",
        data : newConditionModel
    }
    getallmodels();
    async function getallmodels() {
        if ($scope.isLoading) return;
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.GET(`deviceconditions/index.php`);
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

    const conditiondia = document.getElementById("conditiondia");
    function conditiondiashowhidefun(disp) {
        conditiondia.style.display = disp;
    }
    conditiondiashowhidefun("none");
    $scope.deviceconditionshohide = (disp) => conditiondiashowhidefun(disp);
    $scope.addnewcondtions = () => {
        conditiondiashowhidefun("flex");
        $scope.conditionModel = {
            mode : 1,
            title: "Add New Device Condition",
            data : newConditionModel()
        }
        document.getElementById("productCondition").focus();
    }
    $scope.movenxtedit = async ($event, nxt) => {
        if ($event.which === 27) {
            conditiondiashowhidefun("none");
            return;
        }
        if ($event.which === 13) {
            await conditionactions();
        }
    }
    $scope.devicecondition_action =  async () =>  await conditionactions();
    async function conditionactions() {
        if ($scope.isLoading) return;
        if ($scope.conditionModel.mode === 1) {
            await conditionSave();
            return;
        }
        await conditionUpdate();
        return;
    }

    async function conditionSave() {
        const fd = new FormData(document.getElementById("conditionsmodel"));
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.POST(`deviceconditions/new.php`, fd);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        alert("Data has saved");
        $scope.isLoading = false;
        $scope.conditionModel = {
            mode : 1,
            title: "Add New Device Condition",
            data : newConditionModel()
        }
        gridOptions.api.setRowData(res.data);
        document.getElementById("productCondition").focus();
        $scope.$apply();
        return;
    }
    async function conditionUpdate() {
        const fd = new FormData(document.getElementById("conditionsmodel"));
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.POST(`deviceconditions/update.php?id=${$scope.conditionModel.data._id}`, fd);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        alert("Data has Updated");
        $scope.isLoading = false;
        gridOptions.api.setRowData(res.data);
        document.getElementById("productCondition").focus();
        $scope.$apply();
        return;
    }

    $scope.conditionmodel_closemodel = ($event) => {
        var target = $($event.target);
        if (!target.closest('.modal-dialog').length && !target.closest('[data-toggle="modal"]').length) {
            console.log("called");
            conditiondiashowhidefun("none");
        }
    } 
    async function DeleteItemFun(id) {

        m === "0" ? console.log(id) : "";
        if ($scope.isLoading) return;
        var c = confirm("Are You Sure Remove This Data?");
        if (!c) return;
        $scope.isLoading = true;
        const res = await apis.GET(`deviceconditions/delete.php?id=${id}`);
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
}