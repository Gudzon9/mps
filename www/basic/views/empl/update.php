<?php

use yii\helpers\Html;

$this->title = 'Редактирование карточки сотрудника ';
?>
<div class="user-update">
    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model, 'regions' => $regions, 'towns' => $towns,
    ]) ?>
</div>
