<?php

use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);

?>
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
                        <div class="col-md-4 col-sm-12 col-xs-4">
                            <div class="checkout-item-thumb">
                                <div  ng-show="Item.items[0].thumb!=''">
                                    <img data-ng-src="{{Item.items[0].thumb}}" class="img-responsive"/>
                                </div>
                                <div ng-show="Item.items[0].youtube!=''">
                                    <img data-ng-src="http://img.youtube.com/vi/{{Item.items[0].youtube | GetYouTubeID}}/0.jpg" class="img-responsive"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-8">
                            <div class="checkout-item-title">
                                {{Item.items[0].title}}
                            </div>
                        </div>
                    </div>
                    <hr>
                     <div class="row  checkout-form-input">
                        <div class="col-md-6 col-sm-12 col-xs-6">
                            <label style="margin-top: 8px;">จำนวนที่สั่งซื้อ</label>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-6">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" ng-click="subtract()"><i class="fa fa-minus"></i></button>
                                </span>
                                <input type="text" class="form-control text-center" ng-model="Item.amount" readonly>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" ng-click="increase()"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div ng-show="Checkout.payment.code == 'tmtopup'">
                        <div class="row checkout-form-input">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>รหัสบัตรเติมเงิน 14 หลัก</label>
                                <input type="text" class="form-control input" ng-model="TMN.password" name="tmn_password" id="tmn_password" maxlength="14" valid-number>
                            </div>
                        </div>
                        <div class="row checkout-form-input" ng-show="TMTopup.ref_1 != ''">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>{{TMTopup.ref_1}}</label>
                                <input type="text" class="form-control input" ng-model="TMN.ref1" name="ref1" id="ref1">
                            </div>
                        </div>

                        <div class="row checkout-form-input" ng-show="TMTopup.ref_2 != ''">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>{{TMTopup.ref_2}}</label>
                                <input type="text" class="form-control input" ng-model="TMN.ref2" name="ref2" id="ref2">
                            </div>
                        </div>

                        <div class="row checkout-form-input" ng-show="TMTopup.ref_3 != ''">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>{{TMTopup.ref_3}}</label>
                                <input type="text" class="form-control input" ng-model="TMN.ref3" name="ref3" id="ref3">
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
                            <span class="pull-right">{{Checkout.payment.cost*Item.amount | number}} บาท</span>
                        </div>
                    </div>
                    <button class="btn btn-block btn-success btn-lg" ng-show="Checkout.payment.code == 'tmtopup'" ng-click="makePayment()">
                        {{Checkout.payment.button}}
                    </button>
                    <button class="btn btn-block btn-success btn-lg" ng-show="Checkout.payment.code == 'transfer'" ng-click="makePayment()">
                        <i class="fa fa-send"></i>
                        {{Checkout.payment.button}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($model)){
            $this->registerJsFile(
                'https://www.tmtopup.com/topup/3rdTopup.php?uid='.$model->uid.'',
                ['depends' => [\yii\web\JqueryAsset::className()]]
            );
        }
    ?>
</div>
