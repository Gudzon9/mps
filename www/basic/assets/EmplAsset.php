<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class EmplAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/contextMenu.min.css',
    ];
    public $js = [
        'js/custempl.js',
        'js/contextMenu.min.js',
    ];
    public $depends = [
    ];
}
