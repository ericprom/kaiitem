<?php

/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);

?>
<div class="site-stock" ng-controller="StockController" ng-cloak>
    <div ng-hide="newItem">
        <div class="row" ng-hide="newItem">
            <div class="col-md-3 col-sm-4 col-xs-12" ng-repeat="get in Items" style="padding-top:25px;">
                <div class="stock-list">
                    <div class="stock-poster">
                        <a href="item/{{get.id}}">
                        <?=Html::img('@web/armory/{{get.thumb}}', ['alt'=>'{{get.title}}'], ['class'=>'img-responsive'])?>
                        </a>
                    </div>
                    <div class="stock-caption">
                        <span class="stock-title">{{get.title}}</span>
                    </div>
                    <div class="stock-manage">
                        <span class="iosSwitch" ng-model="get.available" ng-class="{checked: get.available}" ng-click="makeAvailable(get)" ios-switch></span>
                        <span class="stock-edit">‎
                            <button type="button" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-default btn-xs"><i class="fa fa-trash"></i></button>
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
    <div  ng-show="newItem">
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
                            <textarea name="item-desc" class="form-control input" ng-model="Item.detail" rows="9"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>จำนวนไอเทม</label>
                                <div class="form-group">
                                    <input type="text" name="item-inventory" class="form-control input" ng-model="Item.inventory">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>ราคาบัตรทรู</label>
                                <div class="input-group">
                                    <input type="text" name="item-true-price" class="form-control input" ng-model="Item.true_price">
                                    <span class="input-group-addon" id="basic-addon2">บาท</span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>ราคาโอน</label>
                                <div class="input-group">
                                    <input type="text" name="item-transfer-price" class="form-control input" ng-model="Item.transfer_price">
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
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn" ng-class="(sourceFile=='local')?'btn-primary':'btn-default';" ng-click="selectSource('local')">รูปจากเครื่อง</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn" ng-class="(sourceFile=='link')?'btn-primary':'btn-default';" ng-click="selectSource('link')">รูปจากลิงค์</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn" ng-class="(sourceFile=='youtube')?'btn-primary':'btn-default';" ng-click="selectSource('youtube')">Youtube วิดีโอ</button>
                    </div>
                </div>
                <div class="stock-item-thumb" style="margin-top:40px;">
                    <input class="btn btn-primary" type="file" img-cropper-fileread image="cropper.sourceImage" ng-click="resetCropSencor()"/>
                    <div ng-show="cropper.sourceImage">
                         <canvas width="613" height="409" id="canvas" image-cropper image="cropper.sourceImage" cropped-image="cropper.croppedImage" crop-width="613" crop-height="409" keep-aspect="true" touch-radius="30" crop-area-bounds="bounds"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>

        <div class="row" style="margin-top:40px;">
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <button class="btn btn-success pull-right" ng-click="saveToStore()"><?=Icon::show('save')?> ลงขาย</button>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>
        <div class="strike" style="margin-top:40px;">
           <span>&bull;</span>
        </div>
    </div>
</div>
