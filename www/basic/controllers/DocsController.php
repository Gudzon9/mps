<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class DocsController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($filestype=0)
    {
        return $this->render('index',['cn' => 'elfinder','filestype'=>$filestype]);
    }
    /*
    public function actionMng()
    {
        return $this->render('index',['cn' => 'elfinderm']);
         
    }
    public function actionTmp()
    {
        return $this->render('index',['cn' => 'elfindert']);
    }
    */
}
