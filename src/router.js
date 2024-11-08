app.config(function($routeProvider)  { 
    $routeProvider
        .when('/', {
            templateUrl: "./pages/home-page/components/home-page.php",
            controller: 'dashboard_controller'
        })
        .when('/users-list', {
            templateUrl: "./pages/users/components/userslist.php",
            controller: 'userslist_controller'
        })
        .when('/changepassword', {
            templateUrl: "./pages/users/components/changepassword.php",
            controller : 'changpasswordctrl'
        })

        .when('/product-model', {
            templateUrl: "./pages/products/components/models-list.php",
            controller : "modellist_ctrl"
        })
        .when('/product-conditions', {
            templateUrl: "./pages/conditions/components/condition-list.php",
            controller : "condition_ctrl"
        })
        .when('/kits-status', {
            templateUrl: "./pages/kitsatus/components/kits-list.php",
            controller : "kitlist_ctrl"
        })
        .when('/warrantys', {
            templateUrl: "./pages/warranty/components/warranty-list.php",
            controller : "warranty_ctrl"
        })
        .when('/charger-types', {
            templateUrl: "./pages/chargertypes/components/charger-list.php",
            controller : "charger_ctrl"
        })
        //shops 
        .when('/shop-list', {
            templateUrl: "./pages/shops/components/shops-list.php",
            controller : "shoplist_ctrl"
        })
        //stock entry
        .when('/stockentry-new', {
            templateUrl : "./pages/stockentry/components/stockentry-new.php"
        })

        .otherwise({ redirectTo: '/' })
});