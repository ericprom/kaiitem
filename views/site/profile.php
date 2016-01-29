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
                    <?= Html::img('http://graph.facebook.com/{{Profile.fbid}}/picture?width=100&height=100', ['alt'=>'{{Profile.name}}']);?> 
                </div>
                <!-- <div class="profile-section" ng-hide="updateMode"> -->
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
                            <!-- <span class="hidden-xs" style="font-size:1.5em;cursor:pointer;" ng-click="updateProfile(true)">
                                <button class="btn btn-default btn-lg">
                                    Setting
                                </button>
                            </span> -->
                            <?=Html::a(Icon::show('cog').' ตั้งค่าโปรไฟล์', ['site/setting'], [
                                'class'=>'btn btn-default btn-lg hidden-xs',
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
                                <span class="btn btn-success btn-sm verified-btn" rel="publisher">
                                    <i class="fa fa-phone"></i>
                                </span>
                                <span class="btn btn-success btn-sm verified-btn" rel="publisher">
                                    <i class="fa fa-envelope-o"></i>
                                </span>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <i class="fa" ng-class="(Profile.online)?'fa-circle':'fa-circle-o'"></i> 
                                    <span ng-show="Profile.online"> Online</span>
                                    <span ng-show="!Profile.online"> Offline</span>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <i class="fa fa-steam"></i> 3ricprom
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <i class="fa fa-map-marker"></i> Bangkok
                                </div>
                            </div>
                            <hr>
                            <div class="strike">
                               <span>Bio</span>
                            </div>
                            <div class="bio">
                            I am CEO Bitch!
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-1"></div>
                    </div>
                </div>
                <?php if(!Yii::$app->user->isGuest){ ?>
                <!-- <div class="profile-section" ng-show="updateMode">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12 hidden-xs"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                             <div class="row" style="margin-top:40px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>ชื่อ Steam</label>
                                        <input type="text" name="username" class="form-control input" >
                                </div>
                            </div>
                             <div class="row" style="margin-top:10px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>เบอร์ติดต่อ</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                        <input type="text" name="phone" class="form-control input" >
                                        <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                    </div>
                                </div>
                            </div>
                             <div class="row" style="margin-top:10px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-times"></i></span>
                                        <input type="text" name="phone" class="form-control input" >
                                        <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                    </div>
                                </div>
                            </div>
                             <div class="row"  style="margin-top:10px;margin-bottom:40px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>จังหวัดที่อยู่อาศัย</label>
                                    <input type="text" name="location" class="form-control input" >
                                </div>
                            </div>

                            <div class="strike">
                               <span>Additional info</span>
                            </div>
                             <div class="row" style="margin-top:40px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>ชื่อบริษัท</label>
                                    <input type="text" name="company" class="form-control input" >
                                </div>
                            </div>
                             <div class="row" style="margin-top:10px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>ตำแหน่ง</label>
                                    <input type="text" name="position" class="form-control input" >
                                </div>
                            </div>
                             <div class="row" style="margin-top:10px;">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label>ข้อมูลส่วนตัว</label>
                                    <textarea class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 pull-right  hidden-xs">
                            <span style="font-size:1.5em;cursor:pointer;" ng-click="updateProfile(false)">
                                <button class="btn btn-default btn-lg">
                                    View Profile
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-3 col-sm-3 col-xs-12 hidden-xs"></div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-default btn-lg">
                                Update profile
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 hidden-xs"></div>
                    </div>
                </div> -->
                <?php }?>
            </div>
        </div>
    </div>
</div>
