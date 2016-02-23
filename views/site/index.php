<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div style="margin-top:51px;">
    <div class="site-index" ng-controller="MainController" ng-cloak>
        <div class="body-content">
            <?php
            if(Yii::$app->user->isGuest){
            ?>
            <div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
                <!-- Overlay -->
                <!-- <div class="overlay"></div> -->

                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#bs-carousel" data-slide-to="1"></li>
                    <li data-target="#bs-carousel" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item slides active">
                      <div class="slide-1"></div>
                      <div class="hero">
                        <hgroup>
                            <h1>ขายฟรี</h1>
                            <h3>ลงขายไอเทม ฟรีแบบไม่มีค่าสมาชิก</h3>
                        </hgroup>
                        <a class="btn btn-hero btn-lg" href="<?=Url::to(['site/stock'])?>"><i class="fa fa-shopping-cart"></i> ลงขายไอเทม</a>
                      </div>
                    </div>
                    <div class="item slides">
                      <div class="slide-2"></div>
                      <div class="hero">
                        <hgroup>
                            <h1>ปลอดภัย</h1>
                            <h3>ด้วยการเข้ารหัสข้อมูล SSL</h3>
                        </hgroup>
                        <a class="btn btn-hero btn-lg" href="<?=Url::to(['site/stock'])?>"><i class="fa fa-shopping-cart"></i> ลงขายไอเทม</a>
                      </div>
                    </div>
                    <div class="item slides">
                      <div class="slide-3"></div>
                      <div class="hero">
                        <hgroup>
                            <h1>เชื่อถือได้</h1>
                            <h3>ยืนยันตัวตนด้วยบัญชี Facebook</h3>
                        </hgroup>
                        <a class="btn btn-hero btn-lg" href="<?=Url::to(['site/stock'])?>"><i class="fa fa-shopping-cart"></i> ลงขายไอเทม</a>
                      </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <div class="container">
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
                        <h1><i class="fa" ng-class="(processing)?'fa-spinner fa-spin':'fa-plus';" ng-click="loadMoreItem()"></i></h1>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<script>mixpanel.track("index");</script>
