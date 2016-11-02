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
 *        'css/jquery-ui-1.8.11.custom.css',
         'js/jquery-ui-1.8.11.custom.min.js',

 */
class CaleAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery-ui-timepicker-addon.css',
        'css/fullcalendar.css'
    ];
    public $js = [
        'js/jquery-ui-timepicker-addon.js',
        'js/jquery-ui-timepicker-ru.js',
        'js/moment.min.js',
        'js/fullcalendar.min.js',
        'js/custcale.js'
    ];
    public $depends = [
    ];
}
