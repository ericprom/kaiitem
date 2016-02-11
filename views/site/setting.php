<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\icons\Icon;
Icon::map($this);

// $this->title = 'Setting';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" style="margin-top:70px;">
<div class="site-setting" ng-controller="SettingController" ng-cloak>
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12 setting-bar">
            <ul class="nav nav-pills nav-stacked hidden-xs">
                <li class="active"><a href="#profile" data-toggle="tab">ตั้งค่าโปรไฟล์</a></li>
                <li><a href="#payment" data-toggle="tab">ตั้งค่าการเงิน</a></li>
                <li><a href="#account" data-toggle="tab">จัดการบัญชี</a></li>
            </ul>
            <ul class="nav nav-pills visible-xs">
                <li class="active"><a href="#profile" data-toggle="tab">ตั้งค่าโปรไฟล์</a></li>
                <li><a href="#payment" data-toggle="tab">ตั้งค่าการเงิน</a></li>
                <li><a href="#account" data-toggle="tab">จัดการบัญชี</a></li>
            </ul>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <div class="tab-content">
                <div id="profile" class="tab-pane active">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="setting-header">
                                ตั้งค่าข้อมูลส่วนตัว
                            </div>
                            <div class="row setting-input">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label>ชื่อ Steam</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="steam" class="form-control input" ng-model="Profile.username">
                                </div>
                            </div>
                            <div class="row setting-input">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label>อีเมล์</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div  ng-class="(Profile.verified_email==1)?'input-group':'';">
                                        <span ng-class="(Profile.verified_email==1)?'input-group-addon':'';"><i class="fa" ng-class="(Profile.verified_email==1)?'fa-check user-verified':'fa-times';" ng-show="Profile.verified_email==1"></i></span>
                                        <input type="text" name="email" class="form-control input" ng-model="Profile.email" ng-disabled="Profile.verified_email==1">
                                    </div ng-show="Profile.verified_email==1">
                                </div>
                            </div>
                            <div class="row setting-input">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label>เบอร์ติดต่อ</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div ng-class="(Profile.verified_phone==1)?'input-group':'';">
                                        <span ng-class="(Profile.verified_phone==1)?'input-group-addon':'';"><i class="fa" ng-class="(Profile.verified_phone==1)?'fa-check user-verified':'fa-times';" ng-show="Profile.verified_phone==1"></i></span>
                                        <input type="text" name="phone-number" class="form-control input" ng-model="Profile.phone" ng-disabled="Profile.verified_phone==1">
                                    </div>
                                </div>
                            </div>
                            <div class="row setting-input">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label>จังหวัดที่อยู่อาศัย</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="location" class="form-control input" ng-model="Profile.location">
                                </div>
                            </div>
                            <div class="strike" style="margin: 20px 0;">
                               <span>&bull;</span>
                            </div>
                            <div class="row setting-input">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label>ข้อมูลส่วนตัว</label>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control"  name="bio" rows="5" ng-model="Profile.bio"></textarea>
                                </div>
                            </div>
                            <div class="strike" style="margin: 20px 0">
                               <span>&bull;</span>
                            </div>
                            <div class="row setting-input" style="margin-bottom:20px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <button class="btn btn-success pull-right"
                                        ng-click="updateProfile()"
                                        ng-disabled="processing">
                                        <i class="fa" ng-class="(processing)?'fa-spinner fa-spin':' fa-save';"></i> บันทึกการแก้ไข
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="payment" class="tab-pane">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="setting-header">
                                ตั้งค่าช่องทางชำระเงิน
                            </div>
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#online-payment" data-toggle="tab">บัญชีออนไลน์</a></li>
                                <li><a href="#bank-transfer" data-toggle="tab">บัญชีธนาคาร</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="online-payment" class="tab-pane active">
                                    <div class="row setting-input">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?=Html::img(Yii::getAlias('@web').'/images/tmtopup.png', ['alt'=>'tmtopup'], ['class' => 'img-responsive'])?>
                                            <div class="alert alert-info" role="alert">
                                              ตัวอย่าง: https://www.tmtopup.com/topup/?uid=<span style="color:red;" ng-hide="TMTopup.uid">178002</span><span style="color:red;" ng-show="TMTopup.uid">{{TMTopup.uid}}</span>
                                            </div>
                                            <div class="row setting-input">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label>UID</label>
                                                    <input type="text" name="uid" class="form-control input" id="uid" ng-model="TMTopup.uid">
                                                </div>
                                            </div>
                                            <div class="row setting-input">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label>ชื่อตัวแปร 1</label>
                                                    <input type="text" name="ref-1" class="form-control input" id="ref-1" ng-model="TMTopup.ref1">
                                                </div>
                                            </div>
                                            <div class="row setting-input">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label>ชื่อตัวแปร 2</label>
                                                    <input type="text" name="ref-2" class="form-control input" id="ref-2"  ng-model="TMTopup.ref2">
                                                </div>
                                            </div>
                                            <div class="row setting-input">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label>ชื่อตัวแปร 3</label>
                                                    <input type="text" name="ref-3" class="form-control input" id="ref-3" ng-model="TMTopup.ref3">
                                                </div>
                                            </div>
                                            <div class="row setting-input">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <button class="btn btn-success"
                                                      ng-disabled="processing"
                                                      ng-click="updateTmtopup()">
                                                        <i class="fa" ng-class="(processing)?'fa-spinner fa-spin':' fa-save';"></i>  บันทึกการตั้งค่า
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <?=Html::img(Yii::getAlias('@web').'/images/paysbuy.png', ['alt'=>'paysbuy'], ['class' => 'img-responsive'])?>
                                            <div class="alert alert-warning" role="alert">ยังไม่เปิดให้บริการ</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="bank-transfer" class="tab-pane">
                                    <table width="100%">
                                        <tr ng-repeat="bank in Accounts">
                                            <td class="bank-list" width="100">
                                                <span  class="setting-bank-icon">
                                                    <?=Html::img(Yii::getAlias('@web').'/images/{{bank.account.code}}.png', ['class' => 'img-responsive'])?>
                                                </span>
                                            </td>
                                            <td class="bank-list">
                                                <div><b>{{bank.account.name}}</b></div>
                                                <div>ชื่อบัญชี: <b>{{bank.name}}</b></div>
                                                <div>เลขที่บัญชี: <b>{{bank.number}}</b></div>
                                            </td>
                                            <td>
                                              <span class="manage">
                                                <i class="fa fa-edit" ng-click="editAccount(bank)"></i>
                                                <i class="fa fa-trash" ng-click="confirmDelete(bank)"></i>
                                              </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bank-list" width="100">
                                                <span  class="setting-bank-icon" ng-click="addNewAccount()" style="cursor:pointer;">
                                                    <?=Html::img(Yii::getAlias('@web').'/images/{{Bank.account.code}}.png', ['class' => 'img-responsive'])?>
                                                </span>
                                            </td>
                                            <td class="add-new-bank">
                                                <div class="row setting-input" ng-show="isAccount">
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        ธนาคาร:
                                                        <select id="bank_list" class="form-control"
                                                            ng-model="Bank.account"
                                                            ng-options="item as item.name for item in Banks"></select>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        ชื่อบัญชี: <input type="text" name="account-name" class="form-control input" ng-model="Bank.name" >
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        เลขที่บัญชี: <input type="text" name="account-number" class="form-control input"  ng-model="Bank.number">
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        &nbsp;
                                                        <button class="btn btn-success btn-block"
                                                          ng-disabled="processing"
                                                          ng-click="saveNewAccount()">
                                                          <i class="fa" ng-class="(processing)?'fa-spinner fa-spin':' fa-save';"></i> บันทึก
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="account" class="tab-pane">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="setting-header">
                                จัดการบัญชีผู้ใช้งาน
                            </div>
                            <div style="height:200px;">
                                <div class="row" style="margin-top:100px;">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-default center-block" ng-click="switchOnOff()">
                                            <i class="fa" ng-class="(Status.action)?'fa-toggle-on':'fa-toggle-off';"></i> Your are {{Status.text}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <span class="pull-right" style="cursor:pointer;color:#e4e4e4;" ng-click="confirmDeactive()">
                                Deactivate Account
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="modal fade" id="confirm-deactive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-cogs"></i>  <b>ระบบยกเลิกบัญชีผู้ใช้งาน</b>
                </div>
                <div class="modal-body">
                    GG?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok" ng-click="oKDeactive()">Deactivate</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-trash"></i>  <b>ระบบลบบัญชีธนาคาร</b>
                </div>
                <div class="modal-body">
                    คุณต้องการที่จะลบ <b>{{deletedObj.account.name}}</b> ใช่หรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok" ng-click="oKDelete()">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="update-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form name="accountForm" ng-submit="submitForm()" novalidate>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-edit"></i>  <b>ระบบแก้ไขบัญชีธนาคาร</b>
                </div>
                <div class="modal-body" style="padding-right:25px;">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            ธนาคาร:
                            <select id="bank_list" class="form-control"
                                ng-model="updateObject.account"
                                ng-options="item as item.name for item in Banks"></select>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            ชื่อบัญชี: <input type="text" name="account-name" class="form-control input" ng-model="updateObject.name" >
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            เลขที่บัญชี: <input type="text" name="account-number" class="form-control input"  ng-model="updateObject.number">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <a class="btn btn-default" data-dismiss="modal">Cancel</a>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>

