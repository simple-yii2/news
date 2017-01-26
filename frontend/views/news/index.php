<?php

use yii\helpers\Html;
use yii\widgets\ListView;

$title = Yii::t('news', 'News');

$this->title = $title . ' | ' . Yii::$app->name;

Yii::$app->params['breadcrumbs'] = [$title];

?>
<h1><?= Html::encode($title) ?></h1>

<?= ListView::widget([
	'dataProvider' => $dataProvider,
	'layout' => "{items}\n{pager}",
	'itemView' => 'item',
	'options' => ['class' => 'news-list'],
]) ?>
