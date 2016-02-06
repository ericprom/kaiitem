<?php

/* @var $this yii\web\View */
use kartik\social\FacebookPlugin;
use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);

?>
<div class="site-item" ng-controller="ItemController" ng-cloak >
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="store-item-title">
                        {{Item.title}}
                    </div>
                </div>
                <div class="panel-body">
                    <div class="store-item-thumb">
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
                    <span class="store-header">ข้อมูลสินค้า</span>
                </div>
                <div class="panel-body">
                    <pre>{{Item.detail}}</pre>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="store-header">คอมเม้น</span>
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
                            <a href="../checkout/{{Item.id}}" class="btn btn-block btn-success btn-lg">
                                <?=Icon::show('shopping-cart')?> ซื้อเลย
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <label>จำนวนสินค้าที่ต้องการ</label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" class="form-control input text-center" name="amount" ng-model="Item.amount">
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="social-panel">
                <button class="btn social-btn-facebook btn-sm social-btn">
                    <i class="fa fa-facebook"></i>
                 </button>
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
                    <a class="btn btn-info" href="../store/{{Item.shops[0].fbid}}">
                      <i class="fa fa-cubes"></i> สินค้าทั้งหมด
                    </a>
                    <a class="btn btn-default pull-right" href="../store/{{Item.shops[0].fbid}}">
                      <i class="fa fa-comments-o"></i> ติดต่อผู้ขาย
                    </a>
                    <div class="clearfix"></div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
