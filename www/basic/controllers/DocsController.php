<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'allow' => TRUE,
                    'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex($filestype=0)
    {
        return $this->render('index',['cn' => 'elfinder','filestype'=>$filestype]);
    }
}
