<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $js = [
      
        'https://auth.lrcontent.com/v2/js/LoginRadiusV2.js',
        'js/jquery.min.js',
        'js/LoginRadiusLoginScreen.1.0.0.js',
        'js/options.js',
        'js/index.js',
        'js/sociallogin.js',
        'js/emailverification.js',
        
        
   
        
    ];
   
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
