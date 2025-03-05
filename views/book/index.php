<?php

use app\models\Book;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if (\Yii::$app->user->can(\app\rbac\Constants::CREATE_BOOK)) {
        ?>
        <p>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php
    }
    ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'isbn',
            'title',
            'year',
            'image_url:url',
            //'description',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                        'update' => \Yii::$app->user->can(\app\rbac\Constants::UPDATE_BOOK),
                    'delete' => \Yii::$app->user->can(\app\rbac\Constants::DELETE_BOOK)
                ]
            ],
        ],
    ]); ?>


</div>
