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
    echo '<form class="navbar-form" role="search" ng-controller="SearchController" ng-submit="searchItem()">
        <div class="form-group has-feedback">
            <input id="searchbox" type="text" placeholder="Search" class="form-control" ng-model="keyword" ng-change="searchItem()">
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
        <div id="searchModal"
            class="modal animated bounceIn"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myModalLabel"
            aria-hidden="true" ng-controller="SearchResultController">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 id="myModalLabel"
                            class="modal-title">
                            Search Modal
                        </h1>
                    </div>
                    <div class="modal-body">
                        <h2>1. Modal sub-title</h2>

                        <p>Liquor ipsum dolor sit amet bearded lady, grog murphy's bourbon lancer. Kamikaze vodka gimlet; old rip van winkle, lemon drop martell salty dog tom collins smoky martini ben nevis man o'war. Strathmill grand marnier sea breeze b & b mickey slim. Cactus jack aberlour seven and seven, beefeater early times beefeater kalimotxo royal arrival jack rose. Cutty sark scots whisky b & b harper's finlandia agent orange pink lady three wise men gin fizz murphy's. Chartreuse french 75 brandy daisy widow's cork 7 crown ketel one captain morgan fleischmann's, hayride, edradour godfather. Long island iced tea choking hazard black bison, greyhound harvey wallbanger, "gibbon kir royale salty dog tonic and tequila."</p>

                        <h2>2. Modal sub-title</h2>

                        <p>The last word drumguish irish flag, hurricane, brandy manhattan. Lemon drop, pulteney fleischmann's seven and seven irish flag pisco sour metaxas, hayride, bellini. French 75 wolfram christian brothers, calvert painkiller, horse's neck old bushmill's gin pahit. Monte alban glendullan, edradour redline cherry herring anisette godmother, irish flag polish martini glen spey. Abhainn dearg bloody mary amaretto sour, ti punch black cossack port charlotte tequila slammer? Rum swizzle glen keith j & b sake bomb harrogate nights 7 crown! Hairy virgin tomatin lord calvert godmother wolfschmitt brass monkey aberfeldy caribou lou. Macuá, french 75 three wise men.</p>

                        <h2>3. Modal sub-title</h2>

                        <p>Pisco sour daiquiri lejon bruichladdich mickey slim sea breeze wolfram kensington court special: pink lady white lady or delilah. Pisco sour glen spey, courvoisier j & b metaxas glenlivet tormore chupacabra, sambuca lorraine knockdhu gin and tonic margarita schenley's." Bumbo glen ord the macallan balvenie lemon split presbyterian old rip van winkle paradise gin sling. Myers black bison metaxa caridan linkwood three wise men blue hawaii wine cooler?" Talisker moonwalk cosmopolitan wolfram zurracapote glen garioch patron saketini brandy alexander, singapore sling polmos krakow golden dream. Glenglassaugh usher's wolfram mojito ramos gin fizz; cactus jack. Mai-tai leite de onça bengal; crown royal absolut allt-á-bhainne jungle juice bacardi benrinnes, bladnoch. Cointreau four horsemen aultmore, "the amarosa cocktail vodka gimlet ardbeg southern comfort salmiakki koskenkorva."</p>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary"
                                data-dismiss="modal">
                          close
                        </button>
                        <button class="btn btn-default">
                          Default
                        </button>
                        <button class="btn btn-primary">
                          Primary
                        </button>
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
