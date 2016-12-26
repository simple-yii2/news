<?php

namespace cms\news\frontend;

use Yii;

/**
 * Frontend module
 */
class Module extends \yii\base\Module
{

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		if (!isset(Yii::$app->i18n->translations['news'])) {
			Yii::$app->i18n->translations['news'] = [
				'class' => 'yii\i18n\PhpMessageSource',
				'sourceLanguage' => 'en-US',
				'basePath' => dirname(__DIR__) . '/messages',
			];
		}
	}

}
