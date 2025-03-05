<?php
/** @var array $years */

$this->title = 'Years';
use yii\helpers\Html;
echo Html::tag('h2', 'Select year');
$yearTags = '';
foreach ($years as $year)
{
    $yearLink = Html::a($year, ['site/top-authors-by-year', 'year' => $year]);
    $yearTag = Html::tag('div', $yearLink);
    $yearTags .= $yearTag;
}
echo Html::tag('div', $yearTags);