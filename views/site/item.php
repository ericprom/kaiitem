<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);

?>
<div class="site-item" ng-controller="ItemController" ng-cloak>
    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="store-item-title">
                        Operation Phoenix Weapon Case
                    </div>
                </div>
                <div class="panel-body">
                    <div class="store-item-thumb">
                    <?=Html::img(Yii::getAlias('@web').'/armory/box.png', ['class' => 'img-responsive'])?>
                    </div>
                </div>
            </div>
            <?php if(!Yii::$app->user->isGuest){ ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="store-header">ข้อมูลสินค้า</span>
                </div>
                <div class="panel-body">
                    <pre>
    Contains one of the following:
    AK-47 | Elite Build
    MP7 | Armor Core
    Desert Eagle | Bronze Deco
    P250 | Valence
    Negev | Man-o'-war
    Sawed-Off | Origami
    AWP | Worm God
    MAG-7 | Heat
    CZ75-Auto | Pole Position
    UMP-45 | Grand Prix
    Five-SeveN | Monkey Business
    Galil AR | Eco
    FAMAS | Djinn
    M4A1-S | Hyper Beast
    MAC-10 | Neon Rider
    or an Exceedingly Rare Special Item!
                    </pre>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="store-header">คอมเม้น</span>
                </div>
                <div class="panel-body">
                </div>
            </div>
            <?php }?>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <?php if(!Yii::$app->user->isGuest){ ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <?=Html::a(Icon::show('shopping-cart').' ซื้อเลย', ['site/checkout'], [
                        'class'=>'btn btn-block btn-success btn-lg',
                        'data'=>[
                            'method'=>'post',
                            'params'=>[
                                'item'=>'1',
                            ],
                        ]
                    ])?>
                </div>
            </div>
            <div class="social-panel">
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
                    <i class="fa fa-envelope-o"></i>
                </button>
                <div class="clearfix"></div>
            </div>
            <?php }?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="card hovercard">
                        <div style="height:50px;"></div>
                        <div class="avatar">
                            <?= Html::img('http://graph.facebook.com/{{Store.owner.fbid}}/picture?width=100&height=100', ['alt'=>'{{Store.owner.name}}']);?>
                        </div>
                        <div class="info">
                            <div class="title">
                                {{Store.owner.name}}
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!Yii::$app->user->isGuest){ ?>
                <div class="panel-footer">
                    <a class="btn btn-info" href="../store/{{Store.owner.fbid}}">
                      <i class="fa fa-cubes"></i> สินค้าทั้งหมด
                    </a>
                    <a class="btn btn-default pull-right" href="../store/{{Store.owner.fbid}}">
                      <i class="fa fa-comments-o"></i> ติดต่อผู้ขาย
                    </a>
                    <div class="clearfix"></div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
