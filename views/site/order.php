<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
Icon::map($this);
?>

<div class="container" style="margin-top:70px;">
<div class="site-order" ng-controller="OrderController" ng-cloak>
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12 setting-bar">
            <ul class="nav nav-pills nav-stacked hidden-xs">
                <li class="active"><a href="#purchase" data-toggle="tab">รายการซื้อ</a></li>
                <li><a href="#sale" data-toggle="tab">รายการขาย</a></li>
            </ul>
            <ul class="nav nav-pills visible-xs">
                <li><a href="#sale" data-toggle="tab">รายการขาย</a></li>
                <li class="active"><a href="#purchase" data-toggle="tab">รายการซื้อ</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="tab-content">
                <div id="purchase" class="tab-pane active">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>รายการสั่งซื้อทั้งหมด</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="15%">วันที่ซื้อ</th>
                                        <th width="75%">ชื่อสินค้า</th>
                                        <th width="10%">จำนวนสินค้า</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="get in Order.purchase">
                                        <td>
                                            <i class="fa fa-calendar"></i> {{get.created_on*1000 | date:'dd/MM/yyyy'}}
                                        </td>
                                        <td>
                                            <a href="checkout/{{get.id}}">
                                                {{get.items[0].title}}
                                            </a>
                                        </td>
                                        <td class="text-center">{{get.amount}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" colspan="3">
                                            <button class="btn btn-info" style="width:100%;" ng-click="loadMore('purchase')"> <i class="fa fa-chevron-circle-down"></i> Load more</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="sale" class="tab-pane">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>รายการขายทั้งหมด</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="15%">วันที่ขาย</th>
                                        <th width="75%">ชื่อสินค้า</th>
                                        <th width="10%">จำนวนสินค้า</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="get in Order.sale">
                                        <td>
                                            <i class="fa fa-calendar"></i> {{get.created_on*1000 | date:'dd/MM/yyyy'}}
                                        </td>
                                        <td>
                                            {{get.items[0].title}}
                                        </td>
                                        <td class="text-center">{{get.amount}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" colspan="3">
                                            <button class="btn btn-info" style="width:100%;" ng-click="loadMore('sale')"> <i class="fa fa-chevron-circle-down"></i> Load more</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
</div>

