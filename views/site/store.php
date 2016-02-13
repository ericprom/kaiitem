<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;
Icon::map($this);

// $this->title = 'Store';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-store" ng-controller="StoreController" ng-cloak>
    <div class="row store-header" ng-show="Store.name">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h1><span class="ChunkFive" style="color:#666;font-size:36px;">{{Store.name}}</span></h1>
        </div>
    </div>

    <div class="container">
      <div class="row" ng-show="Store.name">
          <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="panel panel-default">
                  <div class="panel-body">
                      <div class="store-avatar">
                          <?= Html::img('http://graph.facebook.com/{{Store.fbid}}/picture?width=100&height=100', ['alt'=>'{{Store.name}}']);?>
                      </div>
                      <div class="row">
                          <div class="col-md-8 col-sm-8 col-xs-12">
                              {{Store.bio}}
                          </div>
                          <div class="col-md-4 col-sm-4 col-xs-12">
                              <div style="height:200px;"></div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <h3>{{Store.name}}'s Items</h3>
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
                              <i class="fa fa-eye"></i> {{get.seen}}
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

<script>mixpanel.track("store:"+ window.location.pathname.split('/store/')[1]);</script>
