<?php

namespace app\controllers;

use Yii;
use app\models\Kagent;
use app\models\KagentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KagentController implements the CRUD actions for Kagent model.
 */
class CrmController extends Controller
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

    /**
     * Lists all Kagent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KagentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kagent model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kagent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kagent();
        if (Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    $this->saveAddAtr($model);
                    echo 'ok';
                }
                else{
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
            else{
                return $this->renderAjax('_form',['model' => $model,]);
            }
        }else{ 
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                 $this->saveAddAtr($model);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //var_dump($model->getErrors());
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Kagent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id=1)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()){
                    $this->saveAddAtr($model);
                    echo 'ok';
                }
                else{
                    //var_dump($model->getErrors());
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            }
            else{
                return $this->renderAjax('_form',[
                    'model' => $model,
                ]);
            }
        }
        else{
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $this->saveAddAtr($model);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing Kagent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kagent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kagent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kagent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionComm()
    {
        return $this->render('comm');
    }

    public function actionSends()
    {
        return $this->render('sends');
    }    
}
