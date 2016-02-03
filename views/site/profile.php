<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);
// $this->title = 'Profile';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-profile" ng-controller="ProfileController" ng-cloak>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card hovercard">
                <div class="cardheader"></div>
                <div class="avatar">
                <img ng-src="http://graph.facebook.com/{{Profile.fbid}}/picture?width=100&height=100">
                </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-3 col-sm-3 col-xs-3"></div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <div class="info">
                                <div class="title">
                                    {{Profile.name}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <?php if(!Yii::$app->user->isGuest){ ?>
                            <?=Html::a(Icon::show('cog').' ตั้งค่าโปรไฟล์', ['site/setting'], [
                                'class'=>'btn btn-default hidden-xs',
                                'data'=>[
                                    'method'=>'post',
                                    'params'=>[
                                        'profile'=>'1',
                                    ],
                                ]
                            ])?>
                            <?php }?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-1"></div>
                        <div class="col-md-6 col-sm-6 col-xs-10">
                            <div class="strike">
                               <span>About</span>
                            </div>
                            <div class="about">
                                <span>Verified by</span>
                                <span class="btn btn-success btn-sm verified-btn" rel="publisher">
                                    <i class="fa fa-facebook"></i>
                                </span>
                                <span class="btn btn-sm verified-btn" ng-class="(Profile.verified_phone==1)?'btn-success':'btn-default';" ng-show="Profile.phone!=''">
                                    <i class="fa fa-phone"></i>
                                </span>
                                <span class="btn btn-sm verified-btn" ng-class="(Profile.verified_email==1)?'btn-success':'btn-default';" ng-show="Profile.email!=''">
                                    <i class="fa fa-envelope-o"></i>
                                </span>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <i class="fa" ng-class="(Profile.online==1)?'fa-circle':'fa-circle-o'"></i>
                                    <span ng-show="Profile.online"> Online</span>
                                    <span ng-show="!Profile.online"> Offline</span>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <i class="fa fa-steam" ng-show="Profile.username!=''"></i> {{Profile.username}}
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <i class="fa fa-map-marker" ng-show="Profile.location!=''"></i> {{Profile.location}}
                                </div>
                            </div>
                            <hr>
                            <div class="strike">
                               <span>Bio</span>
                            </div>
                            <div class="bio">
                            {{Profile.bio}}
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
