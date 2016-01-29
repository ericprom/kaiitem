<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);  

// $this->title = 'Checkout';
// $this->params['breadcrumbs'][] = $this->title;
?>
<!-- <script type="text/javascript" src='https://www.tmtopup.com/topup/3rdTopup.php?uid=177427'></script> -->
<div class="site-checkout" ng-controller="CheckoutController" ng-cloak>
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="checkout-header">
                        เลือกวิธีการจ่ายเงิน
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row payment-list" ng-repeat=" get in Checkout.method" ng-click="paymentSelect(get);">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table>
                                <tr class="payment-method">
                                    <td width="59px">
                                        <span class="payment-check-box">
                                          <i class="fa" ng-class="(Checkout.payment.code==get.code)?'fa-check-square-o check-box-color':'fa-square-o '"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <span ng-repeat="bank in get.bank" class="payment-bank-icon" ng-click="selectedBank(get,bank);">
                                            <?=Html::img('@web/images/{{bank.account.code}}.png', ['alt'=>'{{bank.account.name}}'], ['class'=>'img-responsive']);?>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="checkout-header">
                        สรุปยอด
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="checkout-item-thumb">
                                <?=Html::img(Yii::getAlias('@web').'/armory/{{Item.thumb}}', ['class' => 'img-responsive'])?>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                            <div class="checkout-item-title">
                                {{Item.name}}
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div ng-show="Checkout.payment.code == 'tmtopup'">
                        <div class="row checkout-form-input" ng-repeat="get in TMTopup">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>{{get.title}}</label>
                                <input type="text" name="tmt-{{get.id}}" class="form-control input" id="tmt-{{get.id}}">
                            </div>
                        </div>
                    </div>
                    <div ng-show="Checkout.payment.code == 'transfer'">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <span  class="payment-bank-icon">
                                    <?=Html::img(Yii::getAlias('@web').'/images/{{Checkout.bank.account.code}}.png', ['class' => 'img-responsive'])?>
                                </span>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <div><b>{{Checkout.bank.account.name}}</b></div>
                                <div>ชื่อบัญชี: <b>{{Checkout.bank.name}}</b></div>
                                <div>เลขที่บัญชี: <b>{{Checkout.bank.number}}</b></div>
                            </div>
                        </div>
                    </div>
                    <div class="row checkout-total checkout-form-input">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            Total: 
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <span class="pull-right">{{Checkout.payment.cost | number}} บาท</span>
                        </div>
                    </div>
                    <button class="btn btn-block btn-success btn-lg">
                    <i class="fa fa-send" ng-show="Checkout.payment.code == 'transfer'"></i>
                        {{Checkout.payment.button}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
