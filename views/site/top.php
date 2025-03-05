<?php

/** @var array $authors */
$this->title = 'Top authors';


use yii\helpers\Html;
$authorTags = '';
foreach ($authors as $key => $author)
{
    $authorTag = Html::tag('div', sprintf('%d. %s (книг: %d)', ++$key, $author['name'], $author['count']));
    $authorTags .= $authorTag;
}
echo Html::tag('div', $authorTags);