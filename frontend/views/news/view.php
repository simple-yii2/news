<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

$title = $model->title;

$this->title = $title . ' | ' . Yii::$app->name;

$date = strtotime($model->date);

?>
<h1><?= Html::encode($title) ?></h1>

<p class="news-date"><?= Yii::$app->formatter->asDate($date, 'long') ?></p>

<?= HtmlPurifier::process($model->content) ?>
