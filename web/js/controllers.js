var controllers = angular.module('controllers', ['toaster', 'ngAnimate']);
controllers.factory('API', function($window,$q,$timeout,$http,$rootScope,toaster){
    var Profile = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post("../web/user", param).success(function(results) {
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
    var Toaster = function(type,title,message){
        toaster.pop({
            type: type,
            title: title,
            body: message,
            showCloseButton: true
        });
    }
    return {
        Profile:Profile,
        Update:Update,
        Toaster:Toaster
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
            var criteria = {filter: {section:"request", "data":"profile" }};
            API.Profile(criteria).then(function (result) {
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
        $scope.Profile = {};
        $scope.initializingData = function(){
            var criteria = {filter: {section:"request", "data":"profile" }};
            API.Profile(criteria).then(function (result) {
                if(result.status){
                    $scope.Profile = result.data;
                }
                else{

                }
            });
        }
        $scope.initializingData();
        $scope.TMTopup = {
            uid: '177427',
            ref_1: '',
            ref_2: '',
            ref_3: '',
            passkey: ''
        }
        $scope.Banks =  [{
            code:'bay',
            name: 'ธนาคารกรุงศรีอยุธยา'
        },{
            code:'bbank',
            name: 'ธนาคารกรุงเทพ'
        },{
            code:'cimb',
            name: 'ธนาคาร ซีไอเอ็มบี ไทย'
        },{
            code:'gsb',
            name: 'ธนาคารออมสิน'
        },{
            code:'kbank',
            name: 'ธนาคารกสิกร'
        },{
            code:'ktb',
            name: 'ธนาคารกรุงไทย'
        },{
            code:'scb',
            name: 'ธนาคารไทยพาณิชย์'
        },{
            code:'tmb',
            name: 'ธนาคารทหารไทย'
        },{
            code:'tnc',
            name: 'ธนาคารธนชาต'
        },{
            code:'uob',
            name: 'ธนาคาร ยูโอบี'
        }];
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
            $scope.isAccount = false;
            $scope.Accounts.push($scope.Bank);
            $scope.initialBank();
        }
        $scope.Status = 'Online';
        $scope.switchOnOff = function(){
            if($scope.Status == 'Online'){
                $scope.Status = 'Offline';
            }
            else{
                $scope.Status = 'Online';
            }
        }
        $scope.updateProfile = function(){
            var criteria = {filter: {section:"update", "data":$scope.Profile }};
            API.Update(criteria).then(function (result) {
                console.log(result);
                if(result.status){
                    $scope.Profile = result.data;
                }
                API.Toaster(result.toast,'KaiiteM',result.message);
            });
        }
    }
]);
