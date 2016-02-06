<?php

/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);

?>

<div class="container" style="margin-top:70px;">
<div class="site-stock" ng-controller="StockController" ng-cloak>
    <div ng-hide="newItem==true || updateItem==true">
        <div class="row" ng-hide="newItem">
            <div class="col-md-3 col-sm-4 col-xs-12" ng-repeat="get in Items" style="padding-top:25px;">
                <div class="stock-list">
                    <div class="stock-poster">
                        <a href="item/{{get.id}}" ng-show="get.thumb!=''">
                            <img data-ng-src="{{get.thumb}}" class="img-responsive" ng-show="get.thumb!=''"/>
                        </a>
                        <a href="item/{{get.id}}" ng-show="get.youtube!=''">
                            <img data-ng-src="http://img.youtube.com/vi/{{get.youtube | GetYouTubeID}}/0.jpg" class="img-responsive"  ng-show="get.youtube!=''"/>
                        </a>
                    </div>
                    <div class="stock-caption">
                        <span class="stock-title">{{get.title}}</span>
                    </div>
                    <div class="stock-manage">
                        <span class="iosSwitch" ng-model="get.available" ng-class="{checked: get.available}" ng-click="makeAvailable(get)" ios-switch></span>
                        <span class="stock-edit">‎
                            <button type="button" class="btn btn-default btn-xs" ng-click="editItem(get)"><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-default btn-xs" ng-click="confirmDelete(get)"><i class="fa fa-trash"></i></button>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-4 col-xs-12" style="padding-top:25px;">
                <div class="add-new-stock center-block">
                    <h1><i class="fa fa-plus" ng-click="addNewItem()"></i></h1>
                </div>
            </div>
        </div>
    </div>
    <div  ng-show="newItem==true || updateItem==true">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-12"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <i class="fa fa-times pull-right" ng-click="cancelSale()" style="cursor:pointer;color:#ccc;"></i>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>
        <div class="strike" style="margin:10px 0 40px;">
           <span>ขายไอเท็ม</span>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-12"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="form-group">
                    <label>ชื่อสินค้า</label>
                    <input type="text" name="item-name" class="form-control input" ng-model="Item.title">
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="form-group">
                            <label>รายละเอียดสินค้า</label>
                            <textarea name="item-detail" class="form-control input" ng-model="Item.detail" rows="9"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>จำนวนไอเทม</label>
                                <div class="form-group">
                                    <input type="text" name="item-quantity" class="form-control input" ng-model="Item.quantity" valid-number>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>ราคาบัตรทรู</label>
                                <div class="input-group">
                                    <input type="text" name="item-true-price" class="form-control input" ng-model="Item.online_price" valid-number>
                                    <span class="input-group-addon" id="basic-addon2">บาท</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>ราคาโอน</label>
                                <div class="input-group">
                                    <input type="text" name="item-transfer-price" class="form-control input" ng-model="Item.transfer_price" valid-number>
                                    <span class="input-group-addon" id="basic-addon2">บาท</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="strike" style="margin:40px 0 40px;">
                   <span>ภาพประกอบ</span>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <!-- <div class="alert alert-warning" role="alert">หมายเหตุ: ระบบยังไม่รองรับรูปภาพจากลิงค์</div> -->
                <div class="btn-group btn-group-justified" role="group">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn" ng-class="(sourceFile=='local')?'btn-primary':'btn-default';" ng-click="selectSource('local')">รูปจากเครื่อง</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn" ng-class="(sourceFile=='youtube')?'btn-primary':'btn-default';" ng-click="selectSource('youtube')">Youtube วิดีโอ</button>
                    </div>
                </div>
                <div class="stock-item-thumb" style="margin-top:40px;" ng-show="sourceFile=='local'">
                    <input class="hidden" type="file" img-cropper-fileread image="cropper.sourceImage" id="itemImage"/>
                    <div ng-show="cropper.sourceImage" class="image-cropper">
                        <canvas class="image-canvas"
                            width="640" height="480"
                            id="canvas"
                            image-cropper
                            image="cropper.sourceImage"
                            cropped-image="cropper.croppedImage"
                            crop-width="640" crop-height="480"
                            keep-aspect="true" touch-radius="30"
                            crop-area-bounds="bounds"></canvas>
                    </div>
                </div>

                <div class="row" style="margin-top:40px;" ng-show="sourceFile=='youtube'">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <label>Youtube URL</label>
                        <div class="form-group">
                            <input type="text" name="item-video-link" class="form-control input" ng-model="Item.youtube" placeholder="https://www.youtube.com/watch?v=cmuqV9nHxN4">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>

        <div class="row" style="margin-top:40px;">
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <button class="btn btn-success pull-right"
                    ng-click="stockItem()"
                    ng-show="newItem && cropper.croppedImage || newItem && sourceFile=='youtube' && Item.youtube!=''">
                        <?=Icon::show('save')?> ลงขาย
                </button>
                <button class="btn btn-success pull-right"
                    ng-click="updateStock()"
                    ng-show="updateItem && cropper.croppedImage || updateItem &&  sourceFile=='youtube' && Item.youtube!=''">
                        <?=Icon::show('save')?> บันทึกการแก้ไข
                </button>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>
        <div class="strike" style="margin-top:40px;">
           <span>&bull;</span>
        </div>
    </div>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-trash"></i>  <b>ระบบลบสินค้า</b>
                </div>
                <div class="modal-body">
                    คุณต้องการที่จะลบ <b>{{deletedObj.title}}</b> ใช่หรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok" ng-click="oKDelete()">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
