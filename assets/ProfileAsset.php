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
class ProfileAsset extends AssetBundle
{


    // public function init() {
        
    //     $this->jsOptions['position'] = View::POS_END;
    //     parent::init();
        
    // }
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
    ];
    
    public $js = [
        
        'js/jquery.min.js',
        "https://auth.lrcontent.com/v2/js/LoginRadiusV2.js",
        'js/options.js',
        'js/profile.js',
        'js/account.js',
        'js/accountlinking.js',
        'js/logout.js',
      
        
    ];
   
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
