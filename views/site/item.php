<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use kartik\social\FacebookPlugin;
use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);

?>
<div class="container" style="margin-top:70px;">
<div class="site-item" ng-controller="ItemController" ng-cloak>
    <div class="row" ng-show="Item.title">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="item-header">
                        {{Item.title}}
                    </div>
                </div>
                <div class="panel-body">
                    <div class="item-thumb">
                        <div ng-show="Item.thumb!=''">
                            <img data-ng-src="{{Item.thumb}}" class="img-responsive"/>
                        </div>
                        <div class="embed-responsive embed-responsive-16by9" ng-show="Item.youtube!=''">
                          <youtube-video class="embed-responsive-item" video-url="Item.youtube"></youtube-video>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(!Yii::$app->user->isGuest){ ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="item-header">ข้อมูลสินค้า</span>
                </div>
                <div class="panel-body">
                    <pre>{{Item.detail}}</pre>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="item-header">คอมเม้น</span>
                </div>
                <div class="panel-body">
                    <?=FacebookPlugin::widget(['type'=>FacebookPlugin::COMMENT, 'settings' => ['data-width'=>'100%', 'data-numposts'=>5]]);?>
                </div>
            </div>
            <?php }?>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <?php if(!Yii::$app->user->isGuest){ ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-block btn-success btn-lg" ng-click="confirmCheckout()">
                                <i class="fa" ng-class="(ordering && processing)?'fa-spinner fa-spin':' fa-shopping-cart';"></i> ซื้อเลย
                            </button>
                        </div>
                    </div>
                    <hr>

                     <div class="row" style="margin-top:10px;">
                        <div class="col-md-6 col-sm-12 col-xs-6">
                            <label style="margin-top: 8px;">จำนวนที่ต้องการ</label>
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
                </div>
            </div>
            <!-- <div class="social-panel">
                <a class="btn social-btn-facebook btn-sm social-btn" href="http://www.fb.com/{{Item.shops[0].fbid}}" target="_blank">
                    <i class="fa fa-facebook"></i>
                 </a>
                <button class="btn social-btn-twitter  btn-sm social-btn">
                    <i class="fa fa-twitter"></i>
                </button>
                <button class="btn social-btn-google  btn-sm social-btn">
                    <i class="fa fa-google-plus"></i>
                </button>
                <button class="btn social-btn-linkedin btn-sm social-btn">
                    <i class="fa fa-linkedin"></i>
                </button>
                <button class="btn btn-default btn-sm social-btn">
                    <i class="fa fa-heart-o"></i>
                </button>
                <div class="clearfix"></div>
            </div> -->
            <?php }?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="card hovercard">
                        <div style="height:50px;"></div>
                        <div class="avatar">
                            <?= Html::img('http://graph.facebook.com/{{Item.shops[0].fbid}}/picture?width=100&height=100', ['alt'=>'{{Store.owner.name}}']);?>
                        </div>
                        <div class="info">
                            <div class="title">
                                {{Item.shops[0].name}}
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!Yii::$app->user->isGuest){ ?>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <a class="btn btn-info" href="<?=Url::to(['site/store'])?>/{{Item.shops[0].fbid}}">
                              <i class="fa fa-cubes"></i> สินค้าทั้งหมด
                            </a>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <a class="btn btn-default pull-right" href="http://www.fb.com/{{Item.shops[0].fbid}}" target="_blank">
                              <i class="fa fa-facebook"></i>
                            </a>
                            <button class="btn btn-default pull-right" ng-show="Item.shops[0].email!=''" style="margin-right: 10px;" ng-click="contactForm(Item.shops[0].email)">
                              <i class="fa fa-envelope-o"></i>
                            </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="modal fade" id="contact-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-envelope-o"></i>  <b>ติดต่อร้านค้า</b>
                </div>
                <div class="modal-body">
                    <div class="row setting-input">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>หัวข้อ</label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="email" class="form-control input" ng-model="Message.topic">
                        </div>
                    </div>
                    <div class="row setting-input">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <label>ข้อความ</label>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="form-control"  ng-model="Message.body" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <a class="btn btn-success btn-ok" ng-click="contactShop()"><i class="fa fa-send"></i> ส่ง</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-checkout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-check-square-o"></i>  <b>ยืนยันการสั่งซื้อ</b>
                </div>
                <div class="modal-body">
                    คุณต้องการที่จะสั่งซื้อ <b>{{Item.title}}</b> ใช่หรือไม่?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                    <a class="btn btn-success btn-ok" ng-click="orderNow()">ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
