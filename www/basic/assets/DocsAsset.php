<?php
namespace app\assets;

use yii\web\AssetBundle;

class DocsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/custdocs.js',
    ];
    public $depends = [
    ];
}
