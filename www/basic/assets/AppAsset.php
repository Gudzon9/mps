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
    /*
        'css/jquery-ui.css'
        'js/jquery-ui.js',
     
        'css/fullcalendar.css',
        'js/moment.min.js',
        'js/fullcalendar.min.js',

*/
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style_bs.css',

        'css/bootstrap-switch.css',
        'css/jquery-ui.css'

    ];
    public $js = [
        'js/jquery-ui.js',
        'js/bootstrap.min.js',
        'js/bootstrap-switch.js',
        'js/script.js',
        'js/ex.gridView.js',
        ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
