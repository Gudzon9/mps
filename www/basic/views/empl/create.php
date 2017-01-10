<?php

use yii\helpers\Html;
$this->title = 'Новый сотрудник';
?>
<div class="user-create">
    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model, 'regions' => $regions, 'towns' => $towns,
    ]) ?>
</div>
