<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$options = [
	'minHeight' => 250,
	'toolbarFixedTopOffset' => 50,
];

if (isset(Yii::$app->storage) && (Yii::$app->storage instanceof dkhlystov\storage\components\StorageInterface)) {
	$options['imageUpload'] = Url::toRoute('image');
}

?>
<?php $form = ActiveForm::begin([
	'layout' => 'horizontal',
	'fieldConfig' => [
		'horizontalCssClasses' => [
			'wrapper' => 'col-sm-9',
		],
	],
	'enableClientValidation' => false,
]); ?>

	<?= $form->field($model, 'active')->checkbox() ?>

	<?= $form->field($model, 'date')->widget('dkhlystov\widgets\Datepicker') ?>

	<?= $form->field($model, 'time') ?>

	<?= $form->field($model, 'title') ?>

	<?= $form->field($model, 'preview')->textarea(['rows' => 5]) ?>

	<?= $form->field($model, 'content')->widget('yii\imperavi\Widget', [
		'options' => $options,
		'plugins' => [
			'fullscreen',
		],
	]) ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<?= Html::submitButton(Yii::t('news', 'Save'), ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('news', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
