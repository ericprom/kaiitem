<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="container" style="margin-top:70px;">
<div class="site-login">
    <?= yii\authclient\widgets\AuthChoice::widget(['baseAuthUrl' => ['site/auth']])?>
</div>
</div>
