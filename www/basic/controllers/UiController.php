<?php

namespace app\controllers;

use Yii;
use app\models\UI;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TmcController implements the CRUD actions for Tmc model.
 */
class UiController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionApply()
    {
        $varPost    = Yii::$app->request->post();
        
        foreach ($varPost["colInf"] as $ColInf){
            $ui = Ui::findOne(['user_id'=>1, 'model'=>$varPost['modelName'], 'attribute'=>$ColInf['attr']]);
            if (!is_object($ui)){
                $ui = new ui();
                $ui->user_id=1;
                $ui->model = $varPost['modelName'];
                $ui->attribute = $ColInf['attr'];
            }
            $ui->value = $ColInf['val'];
            $ui->save();
        }
    }
}
