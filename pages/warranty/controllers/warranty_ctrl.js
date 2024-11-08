import API_Services from "../../../src/apiservices.js";
import { newWarranty, warranyGrid } from './../models/warrantymodel.js'
export default function WarrantyController($scope) {
    const haveAccesswarrantypage = useraccess?.devicesettings?.warranty?.viewaccess ?? false;
    const haveAccesswarrantynew = useraccess?.devicesettings?.warranty?.new ?? false;
    if (!haveAccesswarrantypage) {
        location.href = `${url}/index.php`;
        return;
    }
    $scope.haveAccessWarrantyNew = haveAccesswarrantynew;
    menuactive("product_menu","warranty_submenu");
    $scope.isLoading = false;
    const apis = new API_Services();
    const cols = warranyGrid();
    const gridOptions = apis._gridOptions(cols);
    gridOptions.onCellClicked = onEditClick;
    const gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    gridOptions.api.setRowData([]);

    async function GetAllWarrantys() {
        if ($scope.isLoading) return;
        $scope.isLoading = true;
        gridOptions.api.setRowData([]);
        const res = await apis.GET(`warranty/index.php`);
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

    GetAllWarrantys();

    $scope.warrantymodel = {
        mode: 1,
        title: "Add New Warrany List",
        data: newWarranty()

    }
    const warrantydia = document.getElementById("warrantydia");
    function warrantydiashowhidefun(disp) {
        warrantydia.style.display = disp;
    }
    $scope.warrantydiashowhide = (disp) => warrantydiashowhidefun(disp);
    warrantydiashowhidefun("none");
    $scope.addnewwarrantydia = () => {
        $scope.warrantymodel = {
            mode: 1,
            title: "Add New Warrany List",
            data: newWarranty()
        };
        warrantydiashowhidefun("flex");
        document.getElementById("warranty").focus();
        document.getElementById("warranty").select();

    }
    async function onEditClick(event) {
        const { data, colDef } = event;
        if (colDef.field === "_edit") {
            EditWarrantyFun(data);
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
        const res = await apis.GET(`warranty/delete.php?id=${id}`);
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
    function EditWarrantyFun(data) {
        $scope.warrantymodel = {
            mode: 2,
            title: "Edit Warrany ",
            data: data
        };
        $scope.$apply();
        warrantydiashowhidefun("flex");

        document.getElementById("warranty").focus();
        document.getElementById("warranty").select();
    }
    $scope.savewarranty_action = async () => await warrantyAction();
    $scope.movenxtwarrany = async ($event, nxt) => {
        if ($event.which === 27) {
            warrantydiashowhidefun("none");
            return;
        }
        if ($event.which === 13) {
            await warrantyAction();
        }
    }
    async function warrantyAction() {
        if ($scope.isLoading) return;
        if ($scope.warrantymodel.mode === 1) {
            await WarrantySaveAction();
            return;
        }
        await WarrantyUpdateAction()
        return;
    }

    async function WarrantySaveAction() {
        const fd = new FormData(
            document.getElementById("modelwarranty")
        );

        const res = await apis.POST(`warranty/new.php`, fd);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        $scope.warrantymodel = {
            mode: 1,
            title: "Add New Warrany List",
            data: newWarranty()
        };
        gridOptions.api.setRowData(res.data);
        document.getElementById("warranty").focus();
        document.getElementById("warranty").select();
        $scope.isLoading = false;
        $scope.$apply();
        return;

    }
    async function WarrantyUpdateAction() {
        const fd = new FormData(
            document.getElementById("modelwarranty")
        );

        const res = await apis.POST(`warranty/update.php?id=${$scope.warrantymodel.data._id}`, fd);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }

        gridOptions.api.setRowData(res.data);
        document.getElementById("warranty").focus();
        document.getElementById("warranty").select();
        $scope.isLoading = false;
        $scope.$apply();
        return;
    }
    $scope.warrantydia_closemodel = ($event) => {
        var target = $($event.target);
        if (!target.closest('.modal-dialog').length && !target.closest('[data-toggle="modal"]').length) {
            ///console.log("called");
            warrantydiashowhidefun("none");
        }
    }
    // $(document).ready(function () {
    //     // Listen for clicks outside the modal dialog
    //     $(document).on('click', function (event) {
    //         var target = $(event.target);
    //         // Check if the target is outside the modal
    //         if (!target.closest('.modal-dialog').length && !target.closest('[data-toggle="modal"]').length) {
    //             $('.modal').modal('hide');
    //         }
    //     });
    // });

}