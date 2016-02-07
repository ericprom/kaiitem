<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use yii\jui\DatePicker;
Icon::map($this);

?>
<div class="container" style="margin-top:70px;">
<div class="site-checkout" ng-controller="CheckoutController" ng-cloak>
    <div class="row" ng-show="Checkout.method!=''">
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
            <div class="alert alert-info" role="alert"  ng-show="userNote!=''">
                  {{userNote}}
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
                        <div class="row checkout-form-input" ng-show="TMTopup.ref1 != ''">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>{{TMTopup.ref1}}</label>
                                <input type="text" class="form-control input" ng-model="TMN.ref1" name="ref1" id="ref1">
                            </div>
                        </div>

                        <div class="row checkout-form-input" ng-show="TMTopup.ref2 != ''">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>{{TMTopup.ref2}}</label>
                                <input type="text" class="form-control input" ng-model="TMN.ref2" name="ref2" id="ref2">
                            </div>
                        </div>

                        <div class="row checkout-form-input" ng-show="TMTopup.ref3 != ''">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label>{{TMTopup.ref3}}</label>
                                <input type="text" class="form-control input" ng-model="TMN.ref3" name="ref3" id="ref3">
                            </div>
                        </div>
                    </div>
                    <div ng-show="Checkout.payment.code == 'transfer'">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <span  class="payment-bank-icon">
                                    <?=Html::img(Yii::getAlias('@web').'/images/{{Checkout.account.account.code}}.png', ['class' => 'img-responsive'])?>
                                </span>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <div><b>{{Checkout.account.account.name}}</b></div>
                                <div>ชื่อบัญชี: <b>{{Checkout.account.name}}</b></div>
                                <div>เลขที่บัญชี: <b>{{Checkout.account.number}}</b></div>
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

    <div class="modal fade" id="payment-notice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form name="paymentForm" ng-submit="submitForm()" novalidate>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-send"></i>  <b>ระบบแจ้งโอนเงิน</b>
                </div>
                <div class="modal-body" style="padding-right:25px;">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-4">
                            <span  class="payment-bank-icon">
                                <?=Html::img(Yii::getAlias('@web').'/images/{{Checkout.account.account.code}}.png', ['class' => 'img-responsive'])?>
                            </span>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-8">
                            <div><b>{{Checkout.account.account.name}}</b></div>
                            <div>ชื่อบัญชี: <b>{{Checkout.account.name}}</b></div>
                            <div>เลขที่บัญชี: <b>{{Checkout.account.number}}</b></div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-6 col-sm-6 col-xs-12" style="margin-top:10px;">
                            <label>จำนวนเงินที่โอน<span style="color:red;">*</span></label>
                            <div class="input-group">
                            <input type="text" name="location" class="form-control input" ng-model="Transfer.transfer_amount" placeholder="100.13" valid-number>
                            <span class="input-group-addon">บาท</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12" style="margin-top:10px;">
                            <label>วันที่โอน<span style="color:red;">*</span></label>
                            <?=DatePicker::widget(['id' => 'transferDate','name' => 'transferDate','dateFormat' => 'MM-dd-yyyy','options'=>['class'=>'form-control']]) ?>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12" style="margin-top:10px;">
                            <label>เวลาที่โอน<span style="color:red;">*</span></label>
                            <input type="text" name="location" class="form-control input" ng-model="Transfer.transfer_time" placeholder="10:30">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
        </form>
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
</div>
