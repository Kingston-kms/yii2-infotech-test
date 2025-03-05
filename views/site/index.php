<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books Library';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'linkContainerOptions' => [
                'class' => 'page-item'
            ],
            'linkOptions' => [
                'class' => 'page-link'
            ],
            'disabledListItemSubTagOptions' => [
                'class' => 'page-link'
            ]
        ],
        'layout' => '{summary}<br/><div class="row">{items}</div><br/>{pager}',
        'itemOptions' => ['class' => 'item col-sm-6'],
        'itemView' => function ($model, $key, $index, $widget) {
            $div = Html::tag('div',Html::encode($model->title),['class' => 'book-item']);
            return Html::a($div, ['book/view', 'id' => $model->id]);
        },
    ]) ?>


</div>