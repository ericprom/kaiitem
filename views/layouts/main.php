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
                <li role="separator" class="divider"></li>
                <li>'.Html::a(Icon::show('sign-out').' ออกจากระบบ', ['site/logout'],['data' => ['method' => 'post']]).'</li>
            </ul>
        </li>
      </ul>';
    }
    echo '<form class="navbar-form" role="search">
        <div class="form-group has-feedback">
            <input id="searchbox" type="text" placeholder="Search" class="form-control">
        </div>
    </form>';
    NavBar::end();
    ?>
    <div class="container" style="margin-bottom:30px;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?=$content?>
        <toaster-container></toaster-container>
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
            <div class="col-md-12 col-sm-12 col-xs-12">
                <button class="btn btn-warning">DONATE NOW</button>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
