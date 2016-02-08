var controllers = angular.module('controllers', ['toaster', 'ngAnimate','angular-img-cropper','youtube-embed']);
controllers.directive('validNumber', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if(!ngModelCtrl) {
                return;
            }

            ngModelCtrl.$parsers.push(function(val) {
                if (angular.isUndefined(val)) {
                        var val = '';
                }
                var clean = val.replace(/[^0-9\.]/g, '');
                var decimalCheck = clean.split('.');

                if(!angular.isUndefined(decimalCheck[1])) {
                        decimalCheck[1] = decimalCheck[1].slice(0,2);
                        clean =decimalCheck[0] + '.' + decimalCheck[1];
                }

                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function(event) {
                if(event.keyCode === 32) {
                    event.preventDefault();
                }
            });
        }
    };
});
controllers.filter("GetYouTubeID", function ($sce) {
  return function (text) {
    var video_id;
    if(text){
        video_id = text.split('v=')[1].split('&')[0];
    }
    return video_id;
  }
});
controllers.factory('API', function($window,$q,$timeout,$http,$rootScope,toaster,$location){
    var Select = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post($window.location.href.split('web')[0]+"web/select", param).success(function(results) {
            deferred.resolve(results);
            $rootScope.processing = false;
        });
        return deferred.promise;
    }
    var Insert = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post($window.location.href.split('web')[0]+"web/insert", param).success(function(results) {
            deferred.resolve(results);
            $rootScope.processing = false;
        });
        return deferred.promise;
    }
    var Update = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post($window.location.href.split('web')[0]+"web/update", param).success(function(results) {
            deferred.resolve(results);
            $rootScope.processing = false;
        });
        return deferred.promise;
    }
    var Delete = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post($window.location.href.split('web')[0]+"web/delete", param).success(function(results) {
            deferred.resolve(results);
            $rootScope.processing = false;
        });
        return deferred.promise;
    }
    var Mark = function(param) {
        $rootScope.processing = true;
        var deferred = $q.defer();
        $http.post($window.location.href.split('web')[0]+"web/mark", param).success(function(results) {
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
        Mark:Mark,
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
        API.Select({filter: {section:"item"}}).then(function (result) {
            console.log(result);
            if(result.status){
                $scope.Items = result.data;
            }
        });
    }
]);
controllers.controller('ItemController', ['API','$scope', '$location', '$window','$timeout',
    function (API,$scope, $location, $window,$timeout) {
        $scope.itemID = $window.location.pathname.split('/item/')[1];
        $scope.Item = {};
        var criteria = {filter: {section:"detail", item:$scope.itemID}};
        API.Select(criteria).then(function (result) {
            if(result.status){
                if(result.data.length>0){
                    $scope.Item = result.data[0];
                    $scope.Item.amount = 1;
                    $scope.markAsSeen($scope.itemID);
                }
            }
        });

        $scope.increase = function(method){
            if($scope.Item.amount < $scope.Item.quantity){
                $scope.Item.amount += 1;
            }
            else{
                API.Toaster('info','KaiiteM','สินค้าไม่พอตามจำนวนที่คุณต้องการ');
            }
        }
        $scope.subtract = function(method){
            if($scope.Item.amount > 1){
                $scope.Item.amount -= 1;
            }
            else{
                API.Toaster('warning','KaiiteM','คุณไม่สามารถสั่งต่ำกว่าจำนวนขั้นต่ำได้');
            }
        }
        $scope.ordering = false;
        $scope.orderNow = function(){
            $scope.ordering = true;
            var criteria = {filter: {section:"order", "data":$scope.Item}};
            API.Insert(criteria).then(function (result) {
                $scope.ordering = false;
                if(result.status){
                    if(result.data != null){
                        $window.location=$window.location.pathname.split('/item/')[0]+'/checkout/'+result.data.id;
                    }
                }
                API.Toaster(result.toast,'KaiiteM',result.message);
            });
        }
        $scope.markAsSeen = function(){
            var number = Math.floor(Math.random() * 30) + 13;
            var random = number*1000;
            $timeout(function() {
                var criteria = {filter: {section:"item", "data":{id:$scope.itemID}}};
                API.Mark(criteria).then(function(result){
                    if (result.status) {
                        //API.Toaster(result.toast,'KaiiteM',result.message);
                    }
                });
            }, random);
        }
    }
]);
controllers.controller('StoreController', ['API','$scope', '$location', '$window',
    function (API,$scope, $location, $window) {
        $scope.storeID = $window.location.pathname.split('/store/')[1];
        $scope.Store = {};
        $scope.Items = {};
        $scope.isFound = false;
        $scope.initializingData = function(){
            var criteria = {filter: {section:"store", store:$scope.storeID}};
            API.Select(criteria).then(function (result) {
                console.log(result);
                if(result.status){
                    if(result.data != null){
                        $scope.Store = result.data.profile;
                        $scope.Items = result.data.items;
                        $scope.isFound = true;
                    }
                }
            });
        }
        $scope.initializingData();
    }
]);
controllers.controller('ProfileController', ['API','$scope', '$location', '$window',
    function (API, $scope, $location, $window) {
        $scope.Profile = {};
        $scope.initializingData = function(){
            var criteria = {filter: {section:"profile"}};
            API.Select(criteria).then(function (result) {
              console.log(result);
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
controllers.controller('CheckoutController', ['API', '$scope', '$location', '$window',
    function (API, $scope, $location, $window) {
        $scope.orderID = $window.location.pathname.split('/checkout/')[1];
        $scope.Transfer = {
            order_id: $scope.orderID
        };
        $scope.Truemoney = {
            order_id: $scope.orderID
        };
        $scope.Checkout = {
            method: []
        }
        $scope.Item = {}
        var criteria = {filter: {section:"checkout", order:$scope.orderID}};
        API.Select(criteria).then(function (result) {
            if(result.status){
                if(result.data.length > 0){
                    $scope.Item = result.data[0];
                    $scope.initializingPaymentMethod($scope.Item);
                }
            }
        });
        $scope.initializingPaymentMethod = function(method){
            var online_price = method.items[0].online_price;
            var transfer_price = method.items[0].transfer_price;
            var hasTmt = false;
            if(method.tmtopup.length > 0){
                hasTmt = true;
                $scope.TMTopup = method.tmtopup[0];
                var tmtopup = {
                    code:'tmtopup',
                    title: 'TMTopup',
                    bank: [{
                        account:{
                            code:'tmtopup',
                            name:'TMTopup'
                        }
                    }],
                    cost: online_price,
                    button: 'จ่ายเงิน'
                }
                if($scope.TMTopup.uid != ''){
                    $scope.Checkout.method.push(tmtopup);
                }
            }
            if(method.accounts.length > 0){
                var transfer = {
                    code:'transfer',
                    title: 'Money transfer',
                    bank: [],
                    cost: transfer_price,
                    button: 'แจ้งโอนเงิน'
                }
                angular.forEach(method.accounts, function (element, index, array) {
                    var bank = {
                        id:element.id,
                        account:{
                            code:element.banks[0].code,
                            name:element.banks[0].name
                        },
                        number:element.number,
                        name:element.name
                    }
                    transfer.bank.push(bank);
                });
                $scope.Checkout.method.push(transfer);
            }
            if(!hasTmt){
                $scope.Checkout.account = $scope.Checkout.method[0].bank[0];
            }
            $scope.paymentSelect($scope.Checkout.method[0]);
        }

        $scope.increase = function(method){
            if($scope.Item.amount < $scope.Item.items[0].quantity){
                $scope.Item.amount = parseInt($scope.Item.amount)+1;
                API.Update({filter: {section:"order", "data":$scope.Item }}).then(function (result) {
                    console.log(result);
                });
            }
            else{
                API.Toaster('info','KaiiteM','สินค้าไม่พอตามจำนวนที่คุณต้องการ');
            }
        }
        $scope.subtract = function(method){
            if($scope.Item.amount > 1){
                $scope.Item.amount = parseInt($scope.Item.amount)-1;
                API.Update({filter: {section:"order", "data":$scope.Item }}).then(function (result) {
                    console.log(result);
                });

            }
            else{
                API.Toaster('warning','KaiiteM','คุณไม่สามารถสั่งต่ำกว่าจำนวนขั้นต่ำได้');
            }
        }
        $scope.userNote = '';
        $scope.paymentSelect = function(method){
            $scope.Checkout.payment = method;
            switch(method.code){
                case 'tmtopup':
                  $scope.userNote = 'หมายเหตุ : การชำระด้วย TMTopup คุณต้องจ่ายจะกว่าจะครบรายการสินค้า เช่น ซื้อไอเทมราคา 300 จ่ายด้วยบัตรทรู ราคาใบละ 100 ต้องจ่าย 3 ครั้งจนครบจำนวนเงินที่ต้องชำระ';
                  break;
                case 'transfer':
                  $scope.userNote = 'หมายเหตุ : กรุณาโอนเงินให้เรียบร้อยก่อนกด "แจ้งโอนเงิน" การโอนเงินเป็นเศษสตางค์ จะทำให้คุณได้รับของเร็วขึ้น เช่น 100.13 บาท';
                  break;
            }
        }
        $scope.selectedBank = function(method, account){
            $scope.paymentSelect(method);
            $scope.Checkout.account = account;
        }
        $scope.makePayment = function(){
            switch($scope.Checkout.payment.code){
                case 'tmtopup':
                    if($scope.TMN && $scope.TMN.password && $scope.TMN.ref1 && $scope.TMN.ref2 && $scope.TMN.ref3){
                        if($scope.TMN.password.length == 14){
                            $scope.Truemoney.shop_id = $scope.Item.shop_id;
                            $scope.Truemoney.tmt_id = $scope.TMTopup.id;
                            $scope.Truemoney.cash_card = $scope.TMN.password;
                            console.log($scope.Truemoney);
                            // submit_tmnc();
                        }
                        else{
                            API.Toaster('warning','KaiiteM','หมายเลขเติมเงินไม่ครบ 14 หลัก');
                        }
                    }
                    else{
                        angular.element('#tmn_password').focus();
                        API.Toaster('warning','KaiiteM','กรุณากรอกข้อมูลให้ครบ');
                    }
                    break;
                case "transfer":
                    $('#payment-notice').modal('show');
                    break;
            }
        }
        $scope.submitForm = function(){
            $scope.Transfer.shop_id = $scope.Item.shop_id;
            $scope.Transfer.account_id = $scope.Checkout.account.id;
            var _date_picker = angular.element('#transferDate').val();
            var _transfer_date= new Date(_date_picker);
            var _payment_date = moment(_transfer_date).unix();
            $scope.Transfer.transfer_date = _payment_date;
            if($scope.Transfer.transfer_amount && $scope.Transfer.transfer_date && $scope.Transfer.transfer_time){
                var criteria = {filter: {section:"transfer", "data":$scope.Transfer}};
                API.Insert(criteria).then(function (result) {
                    if(result.status){
                      $('#payment-notice').modal('hide');
                    }
                    API.Toaster(result.toast,'KaiiteM',result.message);
                });
            }
            else{
                API.Toaster('warning','KaiiteM','กรุณากรอกข้อมูลให้ครบ');
            }
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
                if($scope.TMTopup && $scope.TMTopup.uid && $scope.TMTopup.ref1 && $scope.TMTopup.ref2 && $scope.TMTopup.ref3){
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
                    API.Toaster('warning','KaiiteM','กรุณากรอกข้อมูลให้ครบ');
                }
            }
            else{
                if($scope.TMTopup && $scope.TMTopup.uid && $scope.TMTopup.ref1 && $scope.TMTopup.ref2 && $scope.TMTopup.ref3){
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
                    API.Toaster('warning','KaiiteM','กรุณากรอกข้อมูลให้ครบ');
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
                if($scope.updateObject.name&& $scope.updateObject.number){
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
                else{
                    API.Toaster('warning','KaiiteM','กรุณากรอกชื่อ และเลขบัญชีธนาคาร');
                }
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
        $scope.newItem = false;
        $scope.updateItem = false;
        $scope.Item = {};
        $scope.Items = [];
        API.Select({filter: {section:"stock"}}).then(function (result) {
            if(result.status){
                angular.forEach(result.data, function (element, index, array) {
                    element.available = parseInt(element.available);
                    $scope.Items.push(element);
                });
            }
        });
        $scope.makeAvailable = function(get){
            if(get.available){
                get.available = 0;
            }else{
                get.available = 1;
            }

            if (get.id != ''){
                API.Update({filter: {section:"available", "data":get }}).then(function (result) {
                   API.Toaster(result.toast,'KaiiteM',result.message);
                });
            }
            else{
                API.Toaster('warning','KaiiteM','เกิดข้อผิดพลาด');
            }
        }
        $scope.addNewItem = function(){
             $scope.newItem = true;
        }
        $scope.resetCropSencor = function(){
            angular.element('#itemImage').value = '';
            $scope.cropper = {};
            $scope.cropper.sourceImage = null;
            $scope.cropper.croppedImage   = null;
            $scope.bounds = {};
            $scope.bounds.left = 0;
            $scope.bounds.right = 640;
            $scope.bounds.top = 0;
            $scope.bounds.bottom = 480;
        }
        $scope.resetCropSencor();
        $scope.selectSource = function(src){
            $scope.resetCropSencor();
            switch(src){
                case "local":
                    angular.element('#itemImage').trigger('click');
                    $scope.Item.youtube = '';
                    break;
                case "youtube":
                    $scope.Item.thumb = '';
                    break;
                case "link":
                    break;
            }
            $scope.sourceFile = src;
        }
        $scope.stockItem = function(){
            $scope.Item.thumb = $scope.cropper.croppedImage;
            var criteria = {filter: {section:"item", "data":$scope.Item}};
            if($scope.sourceFile == 'local' && $scope.Item.thumb && $scope.Item.title || $scope.sourceFile == 'youtube' && $scope.Item.title){
                API.Insert(criteria).then(function (result) {
                    if(result.status){
                        if(result.data != null){
                            $scope.cancelSale();
                            $scope.Items.push(result.data);
                        }
                    }
                    API.Toaster(result.toast,'KaiiteM',result.message);
                });
            }
            else{
                API.Toaster('warning','KaiiteM','กรุณากรอกข้อมูลให้ครบ');
            }
        }
        $scope.cancelSale = function(){
            $scope.Item = {};
            $scope.newItem = false;
            $scope.updateItem = false;
            $scope.sourceFile = "";
            $scope.resetCropSencor();
        }
        $scope.editItem = function (data) {
            $scope.Item = data;
            if(data.youtube != ''){
                $scope.sourceFile ='youtube';
            }
            else{
                $scope.sourceFile = 'local';
                $scope.resetCropSencor();
                $scope.cropper.sourceImage = data.thumb;
            }
            $scope.updateItem = true;

        };

        $scope.updateStock = function(){
            $scope.Item.thumb = $scope.cropper.croppedImage;
            var criteria = {filter: {section:"item", "data":$scope.Item}};
            if($scope.sourceFile == 'local' && $scope.Item.thumb && $scope.Item.title || $scope.sourceFile == 'youtube' && $scope.Item.title){
                API.Update(criteria).then(function (result) {
                    if(result.status){
                        if(result.data != null){
                            $scope.cancelSale();
                        }
                    }
                    API.Toaster(result.toast,'KaiiteM',result.message);
                });
            }
            else{
                API.Toaster('warning','KaiiteM','กรุณากรอกข้อมูลให้ครบ');
            }
        }
        $scope.deletedObj = {};
        $scope.confirmDelete = function (data) {
            $('#confirm-delete').modal('show');
            $scope.deletedObj = data;
        };
        $scope.oKDelete = function () {
            API.Remove($scope.Items,$scope.deletedObj);
            $('#confirm-delete').modal('hide');
            var criteria = {filter: {section:"item", "data":$scope.deletedObj}};
            API.Delete(criteria).then(function(result){
                if (result.status) {
                    API.Toaster(result.toast,'KaiiteM',result.message);
                }
            });
        };
    }
]);

controllers.controller('OrderController', ['API','$scope', '$http', '$window', '$location',
    function (API,$scope, $http, $window, $location) {
        $scope.Order = {
            sale:[],
            purchase:[]
        };
        $scope.limit = 10;
        $scope.skip = {
            sale:0,
            purchase:0
        }
        $scope.total = {
            purchase:0,
            sale:0
        }
        $scope.feedContent = function(action,skip,limit){
            API.Select({filter: {section:"order", action:action,skip:skip,limit:limit}}).then(function (result) {
                if(result.status){
                    switch(action){
                        case "sale":
                            if(result.data.sale.length>0){
                                $scope.total.sale = result.data.total_sale;
                                angular.forEach(result.data.sale, function (element, index, array) {
                                    $scope.Order.sale.push(element);
                                });
                            }
                            break;
                        case "purchase":
                            if(result.data.purchase.length>0){
                                $scope.total.purchase = result.data.total_purchase;
                                angular.forEach(result.data.purchase, function (element, index, array) {
                                    $scope.Order.purchase.push(element);
                                });
                            }
                            break;
                    }
                }
            });
        }
        $scope.feedContent('sale',$scope.skip.sale,$scope.limit);
        $scope.feedContent('purchase',$scope.skip.purchase,$scope.limit);
        $scope.loadMore = function(action){
            $scope.skip[action] += 10;
            $scope.feedContent(action,$scope.skip[action],$scope.limit);
        }
        $scope.deletedObj = {};
        $scope.cencelOrder = function (data) {
            $('#confirm-delete').modal('show');
            $scope.deletedObj = data;
        };
        $scope.oKDelete = function () {
            API.Remove($scope.Order.purchase,$scope.deletedObj);
            $('#confirm-delete').modal('hide');
            var criteria = {filter: {section:"order", "data":$scope.deletedObj}};
            API.Delete(criteria).then(function(result){
                if (result.status) {
                    $scope.total.purchase -= 1;
                    API.Toaster(result.toast,'KaiiteM',result.message);
                }
            });
        };
    }
]);
controllers.controller('PaymentController', ['API','$scope', '$http', '$window', '$location',
    function (API,$scope, $http, $window, $location) {
      $scope.Money = {
            transfer:[],
            notify:[]
        };
        $scope.limit = 10;
        $scope.skip = {
            transfer:0,
            notify:0
        }
        $scope.total = {
            transfer:0,
            notify:0
        }
        $scope.feedContent = function(action,skip,limit){
            API.Select({filter: {section:"money", action:action,skip:skip,limit:limit}}).then(function (result) {
                if(result.status){
                    switch(action){
                        case "transfer":
                            if(result.data.transfer.length>0){
                                $scope.total.transfer = result.data.total_transfer;
                                angular.forEach(result.data.transfer, function (element, index, array) {
                                    $scope.Money.transfer.push(element);
                                });
                            }
                            break;
                        case "notify":
                            if(result.data.notify.length>0){
                                $scope.total.notify = result.data.total_notify;
                                angular.forEach(result.data.notify, function (element, index, array) {
                                    $scope.Money.notify.push(element);
                                });
                            }
                            break;
                    }
                }
            });
        }
        $scope.feedContent('transfer',$scope.skip.transfer,$scope.limit);
        $scope.feedContent('notify',$scope.skip.notify,$scope.limit);
        $scope.loadMore = function(action){
            $scope.skip[action] += 10;
            $scope.feedContent(action,$scope.skip[action],$scope.limit);
        }
        $scope.moneyAccept = function(data){
            var criteria = {filter: {section:"transfer",action:"accept", "data":data}};
            API.Update(criteria).then(function (result) {
                if(result.status){
                    data.status = 2;
                }
                API.Toaster(result.toast,'KaiiteM',result.message);
            });
        }
        $scope.moneyFraud = function(data){
            var criteria = {filter: {section:"transfer",action:"fraud", "data":data}};
            API.Update(criteria).then(function (result) {
                if(result.status){
                    data.status = 3;
                }
                API.Toaster(result.toast,'KaiiteM',result.message);
            });
        }
    }
]);
