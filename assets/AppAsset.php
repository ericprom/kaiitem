<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/fonts.css',
        'css/site.css',
        'css/ios-switch.css',
        'css/profile.css',
        'css/masonry.css',
        'css/store.css',
        'css/setting.css',
        'css/checkout.css',
        'css/stock.css',
    ];
    public $js = [
        'js/app.js',
        'js/controllers.js',
        'js/ios-switch-directive.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\BowerAsset',
    ];
}
