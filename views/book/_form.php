<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\BookForm $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $authors */

$url = \yii\helpers\Url::to(['author/list']);

?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?php

    echo $form->field($model, 'authors')->widget(Select2::class, [
        'data' => $authors,
        'options' => ['multiple' => true, 'placeholder' => 'Выбрать автора ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(author) { return author.text; }'),
            'templateSelection' => new JsExpression('function (author) { return author.text; }'),
        ],
    ]);

    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
