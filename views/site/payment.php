<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
Icon::map($this);
?>

<div class="container" style="margin-top:70px;">
<div class="site-payment" ng-controller="PaymentController" ng-cloak>
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12 setting-bar">
            <ul class="nav nav-pills nav-stacked hidden-xs">
                <li class="active"><a href="#income" data-toggle="tab">บัญชีรายรับ</a></li>
                <li><a href="#expense" data-toggle="tab">บัญชีรายจ่าย</a></li>
            </ul>
            <ul class="nav nav-pills visible-xs">
                <li class="active"><a href="#income" data-toggle="tab">บัญชีรายรับ</a></li>
                <li><a href="#expense" data-toggle="tab">บัญชีรายจ่าย</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="tab-content">
                <div id="income" class="tab-pane active">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>รายการแสดงที่มาการเงิน</h3>
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#online-payment" data-toggle="tab">บัญชีออนไลน์ ({{total.money}} รายการ)</a></li>
                                <li><a href="#bank-transfer" data-toggle="tab">บัญชีธนาคาร ({{total.notify}} รายการ)</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="online-payment" class="tab-pane active">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="15%">วันที่จ่าย</th>
                                                <th width="70%">หมายเลขบัตรเติมเงิน</th>
                                                <th width="15%" class="text-center">ตรวจสอบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="get in True.money" ng-class="get.status==2?'success':(get.status==3?'danger':'')">
                                                <td>
                                                    {{get.created_on*1000 | date:'dd/MM/yyyy'}}
                                                </td>
                                                <td>
                                                    <b>{{get.cash_card}}</b>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        จัดการ <span class="caret"></span>
                                                      </button>
                                                      <ul class="dropdown-menu">
                                                        <li><a href="#" ng-click="topupAccept(get)">ได้รับ</a></li>
                                                        <li><a href="#" ng-click="topupFraud(get)">ไม่ได้รับ</a></li>
                                                      </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="5">
                                                    <button class="btn btn-info" style="width:100%;" ng-click="loadMoreTrue('money')" ng-disabled="total.money<skip.money">
                                                        <i class="fa" ng-class="(processing)?'fa-spinner fa-spin':'fa-chevron-circle-down';"></i>
                                                        Load more
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="bank-transfer" class="tab-pane">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="15%">วันที่แจ้ง</th>
                                                <th width="45%">ชื่อบัญชีที่โอนเข้า</th>
                                                <th width="15%">วันที่โอน</th>
                                                <th width="15%" class="text-center">จำนวนเงิน</th>
                                                <th width="15%" class="text-center">ตรวจสอบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="get in Money.notify" ng-class="get.status==2?'success':(get.status==3?'danger':'')">
                                                <td>
                                                    {{get.created_on*1000 | date:'dd/MM/yyyy'}}
                                                </td>
                                                <td>
                                                    <div><b>{{get.accounts[0].banks[0].name}}</b></div>
                                                    <b>ชื่อบัญชี:</b> {{get.accounts[0].name}}
                                                    <b>หมายเลขบัญชี:</b> {{get.accounts[0].number}}
                                                </td>
                                                <td>
                                                    {{get.transfer_date*1000 | date:'dd/MM/yyyy'}} {{get.transfer_time}}
                                                </td>
                                                <td class="text-center">{{get.transfer_amount | number}} บาท</td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        จัดการ <span class="caret"></span>
                                                      </button>
                                                      <ul class="dropdown-menu">
                                                        <li><a href="#" ng-click="moneyAccept(get)">ได้รับ</a></li>
                                                        <li><a href="#" ng-click="moneyFraud(get)">ไม่ได้รับ</a></li>
                                                      </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="5">
                                                    <button class="btn btn-info" style="width:100%;" ng-click="loadMoreTransfer('notify')" ng-disabled="total.notify<skip.notify">
                                                        <i class="fa" ng-class="(processing)?'fa-spinner fa-spin':'fa-chevron-circle-down';"></i>
                                                        Load more
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="expense" class="tab-pane">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>รายการสั่งจ่ายทั้งหมด</h3>
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#online-topup" data-toggle="tab">บัญชีออนไลน์ ({{total.topup}} รายการ)</a></li>
                                <li><a href="#money-transfer" data-toggle="tab">บัญชีธนาคาร ({{total.transfer}} รายการ)</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="online-topup" class="tab-pane active">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="15%">วันที่จ่าย</th>
                                                <th width="70%">หมายเลขบัตรเติมเงิน</th>
                                                <th width="15%" class="text-center">ตรวจสอบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="get in True.topup" ng-class="get.status==2?'success':(get.status==3?'danger':'')">
                                                <td>
                                                    {{get.created_on*1000 | date:'dd/MM/yyyy'}}
                                                </td>
                                                <td>
                                                    <b>{{get.cash_card}}</b>
                                                </td>
                                                <td class="text-center">
                                                    <span ng-show="get.status==1"><i class="fa fa-clock-o"></i></span>
                                                    <span ng-show="get.status==2"><i class="fa fa-thumbs-o-up text-success"></i></span>
                                                    <span ng-show="get.status==3"><i class="fa fa-thumbs-o-down text-danger"></i></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="5">
                                                    <button class="btn btn-info" style="width:100%;" ng-click="loadMoreTrue('topup')" ng-disabled="total.topup<skip.topup">
                                                        <i class="fa" ng-class="(processing)?'fa-spinner fa-spin':'fa-chevron-circle-down';"></i>
                                                        Load more
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="money-transfer" class="tab-pane">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="15%">วันที่แจ้ง</th>
                                                <th width="45%">ชื่อบัญชีที่โอนเข้า</th>
                                                <th width="15%">วันที่โอน</th>
                                                <th width="15%" class="text-center">จำนวนเงิน</th>
                                                <th width="15%" class="text-center">สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="get in Money.transfer">
                                                <td>
                                                    {{get.created_on*1000 | date:'dd/MM/yyyy'}}
                                                </td>
                                                <td>
                                                    <div><b>{{get.accounts[0].banks[0].name}}</b></div>
                                                    <b>ชื่อบัญชี:</b> {{get.accounts[0].name}}
                                                    <b>หมายเลขบัญชี:</b> {{get.accounts[0].number}}
                                                </td>
                                                <td>
                                                    {{get.transfer_date*1000 | date:'dd/MM/yyyy'}} {{get.transfer_time}}
                                                </td>
                                                <td class="text-center">{{get.transfer_amount | number}} บาท</td>
                                                <td class="text-center">
                                                    <span ng-show="get.status==1"><i class="fa fa-clock-o"></i></span>
                                                    <span ng-show="get.status==2"><i class="fa fa-thumbs-o-up text-success"></i></span>
                                                    <span ng-show="get.status==3"><i class="fa fa-thumbs-o-down text-danger"></i></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center" colspan="5">
                                                    <button class="btn btn-info" style="width:100%;" ng-click="loadMoreTransfer('transfer')" ng-disabled="total.transfer<skip.transfer">
                                                        <i class="fa" ng-class="(processing)?'fa-spinner fa-spin':'fa-chevron-circle-down';"></i>
                                                        Load more
                                                    </button>
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
        </div>
    </div>
    <div class="clearfix"></div>
</div>
</div>

