<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\icons\Icon;
Icon::map($this);
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="app">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>KaiiteM | item code market for Thai gammers</title>
    <?php $this->head() ?>
    <script>paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-minimal.css" rel="stylesheet" />
    <script src="https://www.youtube.com/iframe_api"></script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<span class="ChunkFive">KaiiteM</span>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-inverse navbar-fixed-top',
            'role' => 'navigation',
        ],
    ]);
    if(Yii::$app->user->isGuest){
        echo '<span class="dropdown pull-right dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="margin: 0.5em 0em;">'. yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth']]).'</span><div class="clearfix visible-xs"></div>';
    }
    else{
        echo '<ul class="nav navbar-nav navbar-right">
        <li>'.Html::a(' '.Yii::$app->user->identity->name, ['site/profile'],['data' => ['method' => 'post']]).'</li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle hidden-xs" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.Icon::show('cog').'</a>
            <a href="#" class="dropdown-toggle visible-xs" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.Icon::show('cog').' ตั้งค่า</a>
            <ul class="dropdown-menu">
                <li>'.Html::a(Icon::show('user').' ตั้งค่าบัญชีผู้ใช้', ['site/setting'],['data' => ['method' => 'post']]).'</li>
                <li>'.Html::a(Icon::show('shopping-basket').' จัดการคลังสินค้า', ['site/stock'],['data' => ['method' => 'post']]).'</li>
                <li>'.Html::a(Icon::show('clipboard').' รายการซื้อขาย', ['site/order'],['data' => ['method' => 'post']]).'</li>
                <li>'.Html::a(Icon::show('money').' รายรับ/รายจ่าย', ['site/payment'],['data' => ['method' => 'post']]).'</li>
                <li role="separator" class="divider"></li>
                <li>'.Html::a(Icon::show('sign-out').' ออกจากระบบ', ['site/logout'],['data' => ['method' => 'post']]).'</li>
            </ul>
        </li>
      </ul>';
    }
    echo '<form class="navbar-form" role="search" ng-controller="SearchBoxController">
        <div class="form-group has-feedback">
            <input id="searchbox" type="text" placeholder="Search" class="form-control" ng-focus="searchModalOpen()">
        </div>
    </form>';
    NavBar::end();
    ?>
    <div style="margin-bottom:30px;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?=$content?>
        <toaster-container></toaster-container>
        <div id="searchModal" ng-controller="SearchModalController"
            class="modal animated bounceIn"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myModalLabel"
            aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <h1 id="myModalLabel"
                                    class="modal-title">
                                    Search Items
                                </h1>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <button class="btn btn-default pull-right" data-dismiss="modal">
                                  <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body center-block">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" placeholder="Search for..." ng-model="keyword" ng-change="searchNow()">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-lg" type="button" ng-click="searchNow()"><i class="fa fa-search"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-xs-12" ng-repeat="get in Items" style="padding-top:25px;">
                                <div class="item-list">
                                    <div class="item-shop">
                                        <i class="fa fa-user"></i> {{get.shops[0].name}}
                                    </div>
                                    <div class="item-drift">
                                        <div class="item-poster">
                                            <a href="web/item/{{get.id}}"  ng-show="get.thumb!=''">
                                                <img data-ng-src="{{get.thumb}}" class="img-responsive"/>
                                            </a>
                                            <a href="item/{{get.id}}" ng-show="get.youtube!=''">
                                                <img data-ng-src="http://img.youtube.com/vi/{{get.youtube | GetYouTubeID}}/0.jpg" alt="{{get.title}}" class="img-responsive"/>
                                            </a>
                                        </div>
                                        <div class="item-caption">
                                            <span class="item-title">{{get.title}}</span>
                                        </div>
                                    </div>
                                    <div class="item-review">
                                        <!-- <i class="fa fa-heart-o"></i> {{get.liked}} -->
                                        <i class="fa fa-eye"></i> {{get.seen | AbbreviateNumber}}
                                        <?php if(!Yii::$app->user->isGuest){ ?>
                                            <span class="item-price">‎฿ {{get.transfer_price}}</span>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row" style="margin-top:5px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p class="pull-left">&copy; <?= date('Y') ?> KaiiteM All Rights Reserved.</p>
            </div>
        </div>
        <!-- <div class="row" style="margin-top:20px;">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-warning">DONATE NOW</button>
            </div>
        </div> -->
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
