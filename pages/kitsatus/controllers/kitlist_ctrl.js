import API_Services from "../../../src/apiservices.js";
import { netKitModel, kitGrid } from './../models/kitscontroller.js';
export default function KitStatusController($scope) {
    const haveAccessKitStatusPage = useraccess?.devicesettings?.kitstatus?.viewaccess ?? false;
    if (!haveAccessKitStatusPage) {
        location.href = `${url}/index.php`;
        return;
    }
    $scope.haveAccessKitstatusNew = useraccess?.devicesettings?.kitstatus?.new ?? false;
    menuactive("product_menu","kitstatus_submenu");
    $scope.isLoading = false;
    const apis = new API_Services();
    const cols = kitGrid();
    const gridOptions = apis._gridOptions(cols);
    gridOptions.onCellClicked = onEditClick;
    const gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    gridOptions.api.setRowData([]);

    async function LoadDatas() {
        if ($scope.isLoading) false;
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.GET(`devicekits/index.php`);
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
    $scope.kitdia = {
        mode: 1,
        title: "Add New Device Kits",
        data: netKitModel
    };
    LoadDatas()
    const kitdiamodal = document.getElementById("kitdiamodal");
    function kitdiamodalshowhidefun(disp) {
        kitdiamodal.style.display = disp;
    }
    kitdiamodalshowhidefun("none");
    $scope.kitdiamodalshowhide = (disp) => kitdiamodalshowhidefun(disp);
    $scope.addnewkits = () => {
        $scope.kitdia = {
            mode: 1,
            title: "Add New Device Kits",
            data: netKitModel(),
        };
        kitdiamodalshowhidefun("flex");
        document.getElementById("kitCode").focus();
    }
    async function onEditClick(event) {
        m === "0" ? console.log(event) : '';
        const { data, colDef } = event;
        if (colDef.field === "_edit") {
            EditKits(data);
            return;
        }
        if (colDef.field === "_delete") {
            await DeleteItemFun(data._id);
            return;
        }
    }

    function EditKits(data) {
        m === "0" ? console.log(data) : "";
        $scope.kitdia = {
            mode: 2,
            title: "Edit Device Kits",
            data: data
        };
        kitdiamodalshowhidefun("flex");
        document.getElementById("kitCode").focus();
        document.getElementById("kitCode").select();
        $scope.$apply();
    }

    async function KitStatusAction() {
        if ($scope.isLoading) return;
        if ($scope.kitdia.mode === 1) {
            await KitSaveAction();
            return;
        }
        await KitUpdateAction();
        return;
    }
    $scope.divicekit_action = async () => await KitStatusAction();
  
    $scope.movenxtkitdia = async ($event, nxt) => {
        if ($event.which === 27) {
            kitdiamodalshowhidefun("none");
            return;
        }
        if ($event.which === 13) {
            if (nxt === "savekits") {
                await KitStatusAction();
            } else {
                const ele = document.getElementById(nxt);
                ele.focus();
                ele.select();
            }
        }
    }
    async function KitSaveAction() {
        const fd = new FormData(
            document.getElementById("savekitdai")
        );
        $scope.isLoading = true;
        const res = await apis.POST(`devicekits/new.php`, fd);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        gridOptions.api.setRowData([]);
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.kitdia = {
            mode: 1,
            title: "Add New Device Kits",
            data: netKitModel(),
        };
        document.getElementById("kitCode").focus();
        m === "0" ? console.log($scope.kitdia) : "";
        $scope.$apply();
        return;
    }

    async function KitUpdateAction() {
        const fd = new FormData(
            document.getElementById("savekitdai")
        );
        $scope.isLoading = true;
        const res = await apis.POST(`devicekits/update.php?id=${$scope.kitdia.data._id}`, fd);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        gridOptions.api.setRowData([]);
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        
        m === "0" ? console.log($scope.kitdia) : "";
        $scope.$apply();
        return;
    }


    $scope.kitstatusdia_closemodal = ($event) => {
        var target = $($event.target);
        if (!target.closest('.modal-dialog').length && !target.closest('[data-toggle="modal"]').length) {
            console.log("called");
            kitdiamodalshowhidefun("none");
        }
    }

    async function DeleteItemFun(id) {

        m === "0" ? console.log(id) : "";
        if ($scope.isLoading) return;
        var c = confirm("Are You Sure Remove This Data?");
        if (!c) return;
        $scope.isLoading = true;
        const res = await apis.GET(`devicekits/delete.php?id=${id}`);
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