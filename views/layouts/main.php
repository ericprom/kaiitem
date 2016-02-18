<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\icons\Icon;
use cybercog\yii\googleanalytics\widgets\GATracking;
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
    <?php $this->head() ?>
    <!-- made by www.metatags.org -->
    <title>KaiiteM | ตลาดไอเทมออนไลน์ สำหรับเกมเมอร์ไทย</title>
    <meta name="keywords" content="ขายไอเทม, เกมออนไลน์, kaiitem" />
    <meta name="description" content="KaiiteM เป็นศูนย์การในการค้าขายแลกเปลี่ยนไอเทมเกมออนไลน์ สำหรับเกมเมอร์ไทย ที่สำคัญขายฟรีและไม่มีค่าสมาชิก" />
    <meta name="author" content="metatags generator">
    <meta name="robots" content="index, follow">
    <meta name="revisit-after" content="7 days">
    <!-- ขายไอเทม, เกมออนไลน์, kaiitem -->

    <link rel="apple-touch-icon" sizes="57x57" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=Yii::$app->request->baseUrl; ?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?=Yii::$app->request->baseUrl; ?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=Yii::$app->request->baseUrl; ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=Yii::$app->request->baseUrl; ?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=Yii::$app->request->baseUrl; ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?=Yii::$app->request->baseUrl;?>/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?=Yii::$app->request->baseUrl;?>/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script>paceOptions = {ajax: {trackMethods: ['GET', 'POST']}};</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/red/pace-theme-minimal.css" rel="stylesheet" />
  <script src="https://www.youtube.com/iframe_api"></script>
  <?= $this->registerJs(
    GATracking::widget([
        'trackingId' => 'UA-73685503-1',
        'omitScriptTag' => true
    ]), \yii\web\View::POS_END
  ); ?>
  <!-- start Mixpanel -->
  <script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
  for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
  mixpanel.init("e6f7210df6d7d70d86606f2b02f55ffc");</script>
  <!-- end Mixpanel -->
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
        <li>'.Html::a(Icon::show('user').' '.Yii::$app->user->identity->name, ['site/profile'],['data' => ['method' => 'post']]).'</li>
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
            class="modal modal-x animated bounceIn"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myModalLabel"
            aria-hidden="true" >
            <div class="modal-dialog modal-dialog-x">
                <div class="modal-content modal-content-x">
                    <div class="modal-header modal-header-x">
                        <div class="row">
                            <div class="col-md-10 col-sm-10 col-xs-10">
                                <h1 id="myModalLabel"
                                    class="modal-title modal-title-x">
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
                    <div class="modal-body modal-body-x center-block ">
                      <div class="container">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg" placeholder="Search for..." ng-model="keyword" ng-model-options="{debounce: 500}" ng-change="searchNow()">
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
                                            <a href="<?=Url::to(['site/item'])?>/{{get.id}}"  ng-show="get.thumb!=''">
                                                <img data-ng-src="{{get.thumb}}" class="img-responsive"/>
                                            </a>
                                            <a href="<?=Url::to(['site/item'])?>/{{get.id}}" ng-show="get.youtube!=''">
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
                            <div class="col-md-3 col-sm-4 col-xs-12" style="padding-top:25px;" ng-hide="skip >= total">
                              <div class="add-new-stock center-block">
                                  <h1><i class="fa" ng-class="(processing)?'fa-spinner fa-spin':'fa-plus';" ng-click="loadMoreSearch()"></i></h1>
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
        <div class="row" style="margin-top:20px;">
            <div class="col-md-4 col-sm-4 col-xs-4">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="25X7B8D3FMBNW">
                    <input type="image" src="https://www.paypalobjects.com/en_GB/TH/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-8">
                <table class="pull-right">
                    <tr>
                        <td width="135">
                             <span id="siteseal" class="pull-right"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=utJxpeZRRfeYzTBhtVOIuZau7RJHWJKDtSP3nm1YsEKPHDlPldoN1r7FBg4m"></script></span>
                        </td>
                        <td width="125">
                            <a href="https://mixpanel.com/f/partner" rel="nofollow" class="pull-right"><img src="//cdn.mxpnl.com/site_media/images/partner/badge_blue.png" alt="Mobile Analytics" /></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
