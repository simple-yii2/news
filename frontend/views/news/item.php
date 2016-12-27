<?php

use yii\helpers\Html;

$date = strtotime($model->date);

?>
<hr>

<h3><?= Html::a(Html::encode($model->title), ['view', 'alias' => $model->alias]) ?></h3>

<p class="news-date"><?= Yii::$app->formatter->asDate($date, 'long') ?></p>

<p class="news-preview"><?= Html::encode($model->preview) ?></p>

<p><?= Html::a(Yii::t('news', 'Continue reading'), ['view', 'alias' => $model->alias], ['class' => 'btn btn-default news-list-btn']) ?></p>
