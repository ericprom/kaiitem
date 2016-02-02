var controllers = angular.module('controllers', ['toaster', 'ngAnimate']);
controllers.factory('API', function($window,$q,$timeout,$http,$rootScope,toaster){
    var Select = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post("../web/select", param).success(function(results) {
            deferred.resolve(results);
            $rootScope.processing = false;
        });
        return deferred.promise;
    }
    var Insert = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post("../web/insert", param).success(function(results) {
            deferred.resolve(results);
            $rootScope.processing = false;
        });
        return deferred.promise;
    }
    var Update = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post("../web/update", param).success(function(results) {
            deferred.resolve(results);
            $rootScope.processing = false;
        });
        return deferred.promise;
    }
    var Delete = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post("../web/delete", param).success(function(results) {
            deferred.resolve(results);
            $rootScope.processing = false;
        });
        return deferred.promise;
    }
    var Toaster = function(type,title,message){
        toaster.pop({
            type: type,
            title: title,
            body: message,
            showCloseButton: true
        });
    }
    var Remove = function (list, item) {
        var index = list.indexOf(item);
        list.splice(index, 1);
    };
    return {
        Select:Select,
        Insert:Insert,
        Update:Update,
        Delete:Delete,
        Toaster:Toaster,
        Remove:Remove
    };
});
controllers.controller('MainController', ['API','$scope', '$location', '$window',
    function (API, $scope, $location, $window) {
        $scope.Items = [
            {
                shop:"Noob",
                title:"Chroma 2 Case Key",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                seen: 100,
                like: 100,
            },
            {
                shop:"Grean",
                title:"Operation Phoenix Weapon Case",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                seen: 100,
                like: 100,
            },
            {
                shop:"Light",
                title:"AWP | Asiimov",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                seen: 100,
                like: 100,
            },
            {
                shop:"DKS",
                title:"Kinetic Gem",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                seen: 100,
                like: 100,
            },
            {
                shop:"Joker",
                title:"Summer Skull",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                seen: 100,
                like: 100,
            },
            {
                shop:"X Man",
                title:"Tan Boots",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                seen: 100,
                like: 100,
            },
            {
                shop:"Eric Prom",
                title:"Horzine Supply Crate | Series #1",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                seen: 100,
                like: 100,
            },
            {
                shop:"MAN",
                title:"Dino Crate #2",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                seen: 100,
                like: 100,
            },
        ];
    }
]);
controllers.controller('StoreController', ['$scope', '$location', '$window',
    function ($scope, $location, $window) {
        $scope.Store = {
            owner: {
                fbid:'10156502635205529',
                name:'Eric Prom'
            }
        }
    }
]);
controllers.controller('ProfileController', ['API','$scope', '$location', '$window',
    function (API, $scope, $location, $window) {
        $scope.Profile = {};
        $scope.initializingData = function(){
            var criteria = {filter: {section:"profile"}};
            API.Select(criteria).then(function (result) {
                if(result.status){
                    $scope.Profile = result.data;
                }
                else{

                }
            });
        }
        $scope.initializingData();
    }
]);
controllers.controller('CheckoutController', ['$scope', '$location', '$window',
    function ($scope, $location, $window) {
        $scope.Checkout = {
            method : [{
                code:'tmtopup',
                title: 'TMTopup',
                bank: [{
                    account:{
                        code:'tmtopup',
                        name:'TMTopup'
                    }
                }],
                cost: '1000',
                button: 'จ่ายเงิน'
            },{
                code:'transfer',
                title: 'Money Transfer',
                bank: [{
                    account:{
                        code:'bay',
                        name: 'ธนาคารกรุงศรีอยุธยา'
                    },
                    number:'165-2-46735-2',
                    name:'Eric Prom'
                }],
                cost: '1750',
                button: 'แจ้งโอนเงิน'
            }]
        };
        $scope.Checkout.payment = $scope.Checkout.method[0];
        $scope.TMTopup = [
            {
                id:1,
                title : 'รหัสบัตรเงินสดทรูมันนี่ (14 หลัก)',
                value:''
            },{
                id:2,
                title : 'ชื่อ Steam (Ref.1)',
                value:''
            },{
                id:3,
                title : 'เบอร์โทรศัพท์มือถือ (Ref.2)',
                value:''
            },{
                id:4,
                title : 'ชื่อลูกค้า (Ref.3)',
                value:''
            }
        ];
        $scope.Item = {
            name: 'Operation Phoenix Weapon Case',
            thumb:'box.png'
        }
        $scope.paymentSelect = function(method){
            $scope.Checkout.payment = method;
        }
        $scope.selectedBank = function(method, bank){
            $scope.Checkout.payment = method;
            $scope.Checkout.bank = bank;
        }
    }
]);
controllers.controller('SettingController', ['API','$scope', '$http', '$window', '$location',
    function (API,$scope, $http, $window, $location) {
        $scope.Accounts =  [];
        $scope.Banks = [];
        $scope.Profile = {};
        $scope.TMTopup = {};
        $scope.Status = {}
        $scope.setupTMTopup = false;
        $scope.initializingData = function(){
            API.Select({filter: {section:"profile"}}).then(function (result) {
                if(result.status){
                    $scope.Profile = result.data;
                    $scope.Status.action=parseInt($scope.Profile.online);
                    if($scope.Status.action){
                        $scope.Status.text = 'Online';
                    }
                    else{
                        $scope.Status.text = 'Offline';
                    }
                }
            });
            API.Select({filter: {section:"bank"}}).then(function (result) {
                if(result.status){
                    $scope.Banks = result.data;
                }
            });
            API.Select({filter: {section:"account"}}).then(function (result) {
                if(result.status){
                    angular.forEach(result.data, function (element, index, array) {
                        element.account = element.banks[0];
                        $scope.Accounts.push(element);
                    });
                }
            });
            API.Select({filter: {section:"tmtopup"}}).then(function (result) {
                if(result.status){
                    $scope.TMTopup = result.data;
                    if(result.data == null){
                        $scope.setupTMTopup = true;
                    }
                }
            });
        }
        $scope.initializingData();
        $scope.initialBank = function(){
            $scope.Bank = {
                account:{
                    code:'bank'
                }
            };
        }
        $scope.initialBank();
        $scope.isAccount = false;
        $scope.addNewAccount = function(){
            $scope.isAccount = true;
        }
        $scope.saveNewAccount = function(){
            var criteria = {filter: {section:"account", "data":$scope.Bank}};
            if($scope.Bank.name&& $scope.Bank.number){
                API.Insert(criteria).then(function (result) {
                    if(result.status){
                        if(result.data != null){
                            $scope.isAccount = false;
                            $scope.Accounts.push(result.data);
                            $scope.initialBank();
                        }
                        else{
                            $scope.initialBank();
                        }
                    }
                    API.Toaster(result.toast,'KaiiteM',result.message);
                });
            }
            else{
                API.Toaster('warning','KaiiteM','กรุณากรอกชื่อ และเลขบัญชีธนาคาร');
            }
        }
        $scope.switchOnOff = function(){
            if($scope.Status.action){
                $scope.Status.text = 'Offline';
                $scope.Status.action = 0;
            }
            else{
                $scope.Status.text = 'Online';
                $scope.Status.action = 1;
            }
            var criteria = {filter: {section:"online", "data":$scope.Status }};
            API.Update(criteria).then(function (result) {
                API.Toaster(result.toast,'KaiiteM',result.message);
            });
        }
        $scope.updateProfile = function(){
            var criteria = {filter: {section:"profile", "data":$scope.Profile }};
            API.Update(criteria).then(function (result) {
                if(result.status){
                    if(result.data != null){
                        $scope.Profile = result.data;
                    }
                    else{
                        $scope.Profile = { };
                    }
                }
                API.Toaster(result.toast,'KaiiteM',result.message);
            });
        }
        $scope.updateTmtopup = function(){
            var criteria = {filter: {section:"tmtopup", "data": $scope.TMTopup }};
            if($scope.setupTMTopup == true){
                if($scope.TMTopup !== null && $scope.TMTopup.uid != '' && $scope.TMTopup.passkey !== ''){
                    API.Insert(criteria).then(function (result) {
                        if(result.status){
                            if(result.data != null){
                                $scope.TMTopup = result.data;
                            }
                            else{
                                $scope.TMTopup = { };
                            }
                        }
                        API.Toaster(result.toast,'KaiiteM',result.message);
                    });
                }
                else{
                    API.Toaster('warning','KaiiteM','กรุณากรอก UID และ Passkey');
                }
            }
            else{
                if($scope.TMTopup !== null && $scope.TMTopup.uid != '' && $scope.TMTopup.passkey !== ''){
                    API.Update(criteria).then(function (result) {
                        if(result.status){
                            if(result.data != null){
                                $scope.TMTopup = result.data;
                            }
                            else{
                                $scope.TMTopup = { };
                            }
                        }
                        API.Toaster(result.toast,'KaiiteM',result.message);
                    });
                }
                else{
                    API.Toaster('warning','KaiiteM','กรุณากรอก UID และ Passkey');
                }
            }
        }
        $scope.updateObject = {};
        $scope.editAccount = function (data) {
            $('#update-form').modal('show');
            $scope.updateObject = data;
             angular.forEach($scope.Banks, function (element, index, array) {
                if(element.id == data.account.id){
                    $scope.updateObject.account = element;
                }
            });

        };
        $scope.submitForm = function(){
            if ($scope.updateObject.id != ''){
                API.Update({filter: {section:"account", "data":$scope.updateObject }}).then(function (result) {
                    if (result.status) {
                        $('#update-form').modal('hide');
                    }
                    else{
                        $('#update-form').modal('hide');
                    }
                    API.Toaster(result.toast,'KaiiteM',result.message);
                });
            }
        }

        $scope.deletedObj = {};
        $scope.confirmDelete = function (data) {
            $('#confirm-delete').modal('show');
            $scope.deletedObj = data;
        };
        $scope.oKDelete = function () {
            API.Remove($scope.Accounts,$scope.deletedObj);
            $('#confirm-delete').modal('hide');
            var criteria = {filter: {section:"account", "data":$scope.deletedObj}};
            API.Delete(criteria).then(function(result){
                if (result.status) {
                    API.Toaster(result.toast,'KaiiteM',result.message);
                }
            });
        };

        $scope.confirmDeactive = function () {
            $('#confirm-deactive').modal('show');
        };
        $scope.oKDeactive = function () {
            $('#confirm-deactive').modal('hide');
            var criteria = {filter: {section:"user", "data":"me"}};
            API.Delete(criteria).then(function(result){
                if (result.status) {
                    API.Toaster(result.toast,'KaiiteM',result.message);
                }
            });
        };
    }
]);

controllers.controller('StockController', ['API','$scope', '$http', '$window', '$location',
    function (API,$scope, $http, $window, $location) {
      $scope.Items = [
            {
                title:"Chroma 2 Case Key",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                available: true,
            },
            {
                title:"Operation Phoenix Weapon Case",
                thumb:"box.png",
                quntity: 6120,
                price: 100,
                available: false,
            },
            {
                title:"AWP | Asiimov",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                available: true,
            },
            {
                title:"Kinetic Gem",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                available: true,
            },
            {
                title:"Summer Skull",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                available: true,
            },
            {
                title:"Tan Boots",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                available: true,
            },
            {
                title:"Horzine Supply Crate | Series #1",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                available: true,
            },
            {
                title:"Dino Crate #2",
                thumb:"box.png",
                quntity: 20,
                price: 100,
                available: true,
            },
        ];
    }
]);
