<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;
use yii\web\AssetBundle;
use yii\web\View;

class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'toaster/toaster.css',
    ];
    public $js = [
        'angular/angular.min.js',
        'angular-animate/angular-animate.min.js',
        'toaster/toaster.min.js',
        'angular-youtube-embed/angular-youtube-embed.min.js',
        'moment/moment.js',
    ];
    public $jsOptions = [
        'position' => View::POS_END,
    ];
}
