<?php

namespace cms\news\backend;

use Yii;

use cms\components\BackendModule;

class Module extends BackendModule
{

	/**
	 * @inheritdoc
	 */
	public static function moduleName()
	{
		return 'news';
	}

	/**
	 * @inheritdoc
	 */
	protected static function cmsSecurity()
	{
		$auth = Yii::$app->getAuthManager();
		if ($auth->getRole('News') === null) {
			//role
			$role = $auth->createRole('News');
			$auth->add($role);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function cmsMenu($base)
	{
		if (!Yii::$app->user->can('News'))
			return [];

		return [
			['label' => Yii::t('news', 'News'), 'url' => ["$base/news/news/index"]],
		];
	}

}
