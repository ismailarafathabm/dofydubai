import API_Services from "../../../src/apiservices.js";
export default function ChangePasswordController($scope) {
    menuactive("changepassword_menu");
    const apis = new API_Services();
    $scope.changepass = {
        currentpassword: "",
        newpassword : "",
    }
    $scope.isloading = false;
    $scope.changepassword = async () => Changepasswordfun();
    async function Changepasswordfun() {
        if ($scope.isloading) return;
        const fd = new FormData(document.getElementById("passwordchangefrm"));
        $scope.isloading = true;
        const res = await apis.POST('users/changepassword.php', fd);
        m === "0" ? console.log(res) : "";
        if (!res.isSuccess) {
            $scope.isloading = false;
            $scope.$apply();
            return;
        }
        location.href = `${url}/logout.php`;
        $scope.$apply();
        return;
    }
}