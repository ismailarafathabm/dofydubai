import API_Services from "../../../src/apiservices.js";
import * as models from './../models/userlistmodel.js';
export default function userListController($scope, $compile) {
    menuactive("user_menu");
    $scope.useraccess = {};
    const apis = new API_Services();
    var filterParams = {
        comparator: function (filterLocalDateAtMidnight, cellValue) {
            var dateAsString = cellValue;
            var dateParts = dateAsString.split('-');
            var cellDate = new Date(
                Number(dateParts[0]),
                Number(dateParts[1]) - 1,
                Number(dateParts[2])
            );

            if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
                return 0;
            }

            if (cellDate < filterLocalDateAtMidnight) {
                return -1;
            }

            if (cellDate > filterLocalDateAtMidnight) {
                return 1;
            }
        },
    };
    const cols = models.userslist($scope,$compile);
    const gridOptions = apis._gridOptions(cols);
    gridOptions.onCellClicked = onEditClick;
    const gridDiv = document.querySelector('#myGrid');
    new agGrid.Grid(gridDiv, gridOptions);
    gridOptions.api.setRowData([]);

    //get all users 
    $scope.isLoading = false;
    GetAllusers();
    async function GetAllusers() {
        
        if ($scope.isLoading) return;
        gridOptions.api.setRowData([]);
        $scope.isLoading = true;
        const res = await apis.GET("users/index.php");
        if (!res?.isSuccess) {
            $scope.isLoading = false;
            alert(res.msg);
            $scope.$apply();
            return;
        }
       
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.$apply();
        return;
    }

    $scope.newusermodalshowhide = (disp) => newusermodalshowhidefun(disp);
    const newuserModal = document.getElementById("newuserModal");
    newusermodalshowhidefun('none');
    function newusermodalshowhidefun(dip) {
        newuserModal.style.display = dip;
    }
    $scope.showNewBrandModal = () => {
        newusermodalshowhidefun('flex');
        $scope.newuser = models.IUserModel();
        document.getElementById("userName").focus();
        document.getElementById("userName").select();
    }
    $scope.movenxt = async ($event, nxt) => {
        if ($event.which === 13) {
            if (nxt === 'saveUser') {
                await SaveNewUserfun();
            } else {
                const ele = document.getElementById(nxt);
                ele.focus();
                ele.select();
            }
        }
    }
    $scope.newuser = models.IUserModel();
    m === "0" ? console.log($scope.newuser) : "";
    $scope.savenewuser_fun = async () => await  SaveNewUserfun();
    async function SaveNewUserfun() {
        gridOptions.api.setRowData([]);
        if ($scope.isLoading) return;
        const frm = document.getElementById("savenewuser");
        const fd = new FormData(frm);
        fd.append('useraccess', JSON.stringify($scope.useraccess));
        $scope.isLoading = true;
        const res = await apis.POST('users/new.php', fd);
        m === "0" ? console.log(res) : "";
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            return;
        }
        alert("User has Create Success fully");
        gridOptions.api.setRowData(res.data);
        $scope.isLoading = false;
        $scope.newuser = models.IUserModel();
        document.getElementById("userName").focus();
        $scope.$apply();
        return;
    }

    //user access modal

    const useraccessModal = document.getElementById("useraccessModal");
    showhideuseraccessmodelfun("none");
    $scope.useraccessmodalshowhide = (disp) => showhideuseraccessmodelfun(disp);
    function showhideuseraccessmodelfun(disp) {
        useraccessModal.style.display = disp;
    }
    let currentuserid = "";
    function setUserAccess(x) {
        $scope.useraccess = {
            "homepagesummary" : x?.homepagesummary ?? false,
            "homepagelowstock" : x?.homepagelowstock ?? false,
            "salesnew" : x?.salesnew ?? false,
            "salesview" : x?.salesview ?? false,
            "salesedit" : x?.salesedit ?? false,
            "purchasenew" : x?.purchasenew ?? false,
            "purchaseview" : x?.purchaseview ?? false,
            "purchaseedit" : x?.purchaseedit ?? false,
            "productview" : x?.productview ?? false,
            "productnew" : x?.productnew ?? false,
            "productedit" : x?.productedit ?? false,
            "productremove" : x?.productremove ?? false,
            "supplierview" : x?.supplierview ?? false,
            "suppliernew" : x?.suppliernew ?? false,
            "customerview" : x?.customerview ?? false,
        }
        console.log($scope.useraccess);
    }
    $scope.edituseraccess = async (userId) => {
        currentuserid = userId;
        if ($scope.isLoading) return;
        const res = await apis.GET(`users/getaccess.php?getuserId=${userId}`);
        
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        $scope.isLoading = false;
        m === "0" ? console.log(res.data.useraccess) : "";
        setUserAccess(JSON.parse(res.data.useraccess));
        $scope.$apply();
        showhideuseraccessmodelfun("flex");
        return;

    }
    $scope.saveuseraccess_fun = async () => await SaveNewUserAccessFunction();
    async function SaveNewUserAccessFunction() {
        if ($scope.isLoading) return;
        const fd = new FormData();
        fd.append("updateuserId", currentuserid);
        fd.append("useraccess", JSON.stringify($scope.useraccess));
        $scope.isLoading = true;
        const res = await apis.POST(`users/updateuseraccess.php`, fd);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        alert("Data has updated");
        $scope.isLoading = false;
        $scope.$apply();
        location.reload();
        return;

    }   

    function onEditClick(event) {
        const { data, colDef } = event;
        
        if (colDef.field === "_edit") {
            EditUserFun(data);
        }
    }
    $scope.edituser = {
        userName: "",
        userPass: "",
        userId: "",
        userStatus: "",
        shopCode : ""
    }
    const edituserModal = document.getElementById("edituserModal");
    edituserModalshowhidefun("none")
    function edituserModalshowhidefun(disp) {
        edituserModal.style.display = disp;
    }
    $scope.edituserModalshowhide = (disp) => edituserModalshowhidefun(disp)
    async function EditUserFun(x) { 
        m === "0" ? console.log(x) : "";
        $scope.edituser = {
            userName: x.userName,
            userPass: x.userPass,
            userId: x.userId,
            userStatus: x.userStatus.toString(),
            shopCode : x.shopCode
        }
        m === "0" ? console.log($scope.edituser) : "";
        $scope.$apply();
        edituserModalshowhidefun("flex");
    }

    $scope.movenxtedit = async ($event, nxt) => {
        if ($event.which === 13) {
            if (nxt === "updateuser") {
                await UpdateUserInfo();
            } else {
                const ele = document.getElementById(nxt);
                ele.focus();
                if (nxt !== "edit_userStatus") {
                    ele.select();
                }
            }
        }
    }
    $scope.updateuser_fun = async () => await UpdateUserInfo();
    async function UpdateUserInfo() {
        if ($scope.isLoading) return;
        const fd = new FormData(
            document.getElementById("userupdate")
        );
        $scope.isLoading = true;
        const res = await apis.POST('users/update.php', fd);
        if (!res.isSuccess) {
            alert(res.msg);
            $scope.isLoading = false;
            $scope.$apply();
            return;
        }
        $scope.isLoading = false;
        $scope.$apply();
        location.reload();
        return;
    }
}