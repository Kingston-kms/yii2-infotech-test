<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var array $authors */

$this->title = 'Update Book: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'authors' => $authors

    ]) ?>

</div>
