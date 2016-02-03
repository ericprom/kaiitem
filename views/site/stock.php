<?php

/* @var $this yii\web\View */
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
        <!-- <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="alert alert-info" role="alert">ขายง่าย ขายเร็ว ขายไอเท็ม ต้องใส่รายละเอียด</div>
                <h1>ขายไอเท็ม</h1>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div> -->
        <div class="strike" style="margin:40px 0 40px;">
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
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label>รายละเอียดสินค้า</label>
                    <textarea name="item-desc" class="form-control input" ng-model="Item.detail" rows="9"></textarea>
                </div>
            </div>
             <div class="col-md-2 col-sm-2 col-xs-12">
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
                <div class="alert alert-info" role="alert">คำแนะนำ: ขนาดรูปที่เหมาะสม 613x409</div>
                <div class="stock-item-thumb">
                    <?=Html::img(Yii::getAlias('@web').'/armory/box.png', ['class' => 'img-responsive'])?>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 hidden-xs"></div>
        </div>

        <div class="strike" style="margin-top:40px;">
           <span>&bull;</span>
        </div>
    </div>
</div>
