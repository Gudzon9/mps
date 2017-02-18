<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class CrmAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/jquery-ui-timepicker-addon.js',
        'js/jquery-ui-timepicker-ru.js',
        'js/moment.min.js',
        'js/jquery.inputmask.bundle.js',
        'js/custcrm.js',
    ];
    public $depends = [
    ];
}
