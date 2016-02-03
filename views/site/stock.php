<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);

?>
<div class="site-stock" ng-controller="StockController" ng-cloak>
<div class="row">
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
