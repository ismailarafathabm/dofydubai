import API_Services from "../../../src/apiservices.js";
import { newChargerModels,chargerModelGrid } from "../models/chargertypemodel.js";
export default function ChargerController($scope) {
    //access 
    const chargeraccess = useraccess?.devicesettings?.chargertype ?? false;
    if (!chargeraccess.viewaccess ?? false) {
        location.href = `${url}/index.php`;
        return;
    }
    $scope.newchargemodelacces = chargeraccess?.new ?? false;
    //access
    menuactive("product_menu","chargertype_submenu");
    $scope.isLoading = false;
    const apis = new API_Services();
    const cols = chargerModelGrid();
    const gridOptions = apis._gridOptions(cols);
    gridOptions.onCellClicked = onEditClick;
    const gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    gridOptions.api.setRowData([]);

    async function GetAllChargerTypeFun() {
        if ($scope.isLoading) return;
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.GET(`chargertypes/index.php`);
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
    GetAllChargerTypeFun();
    async function onEditClick(event) {
        const { data, colDef } = event;
        if (colDef.field === "_edit") {
            EditChargerTypeFun(data);
            return;
        }
        if (colDef.field === "_delete") {
            await DeleteItemFun(data._id);
            return;
        }
    }
    async function DeleteItemFun(id) {
        if (!chargeraccess?.delete ?? false) {
            alert("You can not delete");
            return;
        }
        m === "0" ? console.log(id) : "";
        if ($scope.isLoading) return;
        var c = confirm("Are You Sure Remove This Data?");
        if (!c) return;
        $scope.isLoading = true;
        const res = await apis.GET(`chargertypes/delete.php?id=${id}`);
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

    $scope.chargertypemodel = {
        mode: 1,
        title: "Add New Charger Type",
        data: newChargerModels()
    }

    const chargertypedia = document.getElementById("chargertypedia");
    function chargertypediashowhidefun(disp) {
        chargertypedia.style.display = disp;
    }
    chargertypediashowhidefun("none");
    $scope.chargertypediashowhide = (disp) => chargertypediashowhidefun(disp);
    $scope.addnewchargertype = () => {
        $scope.chargertypemodel = {
            mode: 1,
            title: "Add New Charger Type",
            data: newChargerModels()
        }
        chargertypediashowhidefun("flex");
        document.getElementById("chargerType").focus();
        return;
    }

    function EditChargerTypeFun(data) {
        $scope.chargertypemodel = {
            mode: 2,
            title: "Edit Charger Type",
            data: data
        }
        chargertypediashowhidefun("flex");
        document.getElementById("chargerType").focus();
        $scope.$apply();
        return;
    }

    $scope.chargertype_actions = async () => await ChargerTypeActions();
    $scope.movenxtchargertype = async($event, nxt) => {
        const keycode = $event.which;
        switch (keycode) {
            case 27:
                chargertypediashowhidefun("none");
                return;
            case 13:
                await ChargerTypeActions();
                return;
            default:

                return;
        }
    }

    async function ChargerTypeActions() {
        if ($scope.isLoading) return;
        if ($scope.chargertypemodel.mode === 1) {
            await saveChargerTypeFun();
            return;
        }
        await updateChargerTypeFun();
        return;
    }


    async function saveChargerTypeFun() {
        const frm = document.getElementById("chargertypemodel");
        const fd = new FormData(frm);
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.POST(`chargertypes/new.php`, fd);
        if (!res?.isSuccess) {
            alert(res?.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        $scope.chargertypemodel = {
            mode: 1,
            title: "Add New Charger Type",
            data: newChargerModels()
        }
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.$apply();
        document.getElementById("chargerType").focus();
        return;
    }
    async function updateChargerTypeFun() {
        const frm = document.getElementById("chargertypemodel");
        const fd = new FormData(frm);
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.POST(`chargertypes/update.php?id=${$scope.chargertypemodel.data._id}`, fd);
        if (!res?.isSuccess) {
            alert(res?.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
       
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.$apply();
        document.getElementById("chargerType").focus();
        return;
    }


    $scope.conditionmodel_closemodel = ($event) => {
        var target = $($event.target);
        if (!target.closest('.modal-dialog').length && !target.closest('[data-toggle="modal"]').length) {
            console.log("called");
            conditiondiashowhidefun("none");
        }
    } 
}