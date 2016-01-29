<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index" ng-controller="MainController" ng-cloak>
    <div class="body-content">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-12" ng-repeat="get in Items" style="padding-top:25px;">
                <div class="item-list">
                    <div class="item-shop">
                        <i class="fa fa-user"></i> {{get.shop}} 
                    </div>
                    <div class="item-drift">
                        <div class="item-poster">
                            <?=Html::a(Html::img('@web/armory/{{get.thumb}}', ['alt'=>Yii::$app->name], ['class'=>'img-responsive']), ['site/store'], [
                                'class'=>'',
                                'data'=>[
                                    'method'=>'post',
                                    'params'=>[
                                        'item'=>'1',
                                    ],
                                ]
                            ])?>
                            <!-- <img src="{{get.thumb}}" alt="{{get.title}}" class="img-responsive"> -->
                        </div>
                        <div class="item-caption">
                            <span class="item-title">{{get.title}}</span>
                        </div>
                    </div>
                    <div class="item-review">
                        <i class="fa fa-heart-o"></i> {{get.like}} 
                        <i class="fa fa-eye"></i> {{get.seen}}
                        <?php if(!Yii::$app->user->isGuest){ ?>
                            <span class="item-price">‎฿ {{get.price}}</span>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
