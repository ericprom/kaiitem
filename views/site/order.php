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
                        </div>
                    </div>
                </div>
                <div id="sale" class="tab-pane">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>รายการขายทั้งหมด</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
</div>

