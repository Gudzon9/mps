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
        $model      = new ui();
        //echo $varPost['modelName'];
        foreach ($varPost["colInf"] as $ColInf){
            //echo $ColInf['attr'];
            $ui = $model->findOne(['user_id'=>1, 'model'=>$varPost['modelName'], 'attribute'=>$ColInf['attr']]);
            if (is_null($ui->user_id)){
                $ui = new ui();
                $ui->user_id=1;
                $ui->model = $varPost['modelName'];
                $ui->attribute = $ColInf['attr'];
                
            }
            $ui->value = $ColInf['val'];
            echo $ui->value;
            $ui->save();
        }
    }
}
