<?php

namespace cms\news\common\models;

use yii\db\ActiveRecord;

class News extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'News';
	}

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->active = true;
		$this->date = date('Y-m-d H:i:s');
	}

}
