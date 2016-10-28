<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id'=>'edtUser']); ?>
    <table>
        <tr>
            <td><?= $form->field($model, 'fio1')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'fio2')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'fio3')->textInput(['maxlength' => true]) ?></td>
        </tr>
        <tr>
            <td colspan='2'><?= $form->field($model, 'emailLogin')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'birthday')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'dateEmp')->textInput(['maxlength' => true]) ?></td>
            <td><?= $form->field($model, 'dateDis')->textInput(['maxlength' => true]) ?></td>
        </tr>
        <tr>
            <td colspan="3"><?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'tin')->textInput(['maxlength' => true]) ?></td>
            <td colspan="2"><?= $form->field($model, 'passport')->textInput(['maxlength' => true]) ?></td>
        </tr>
        <tr>
            <td colspan="3"><?= $form->field($model, 'statusEmp')->dropDownList(Yii::$app->params['astatusEmp']) ?></td>
        </tr>

    <div class="form-group">
    <?php
        if (!Yii::$app->request->isAjax){
            echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
        }
    ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
if (Yii::$app->request->isAjax){
$script = "
    $('#edtUser').on('beforeSubmit', function () {
        return false;
    });
";
$this->registerJs($script,yii\web\View::POS_END); 
}
?>
