<?php

namespace cms\news\backend\models;

use Yii;
use yii\base\Model;

use cms\news\common\models\News;

/**
 * Editing form
 */
class NewsForm extends Model
{

	/**
	 * @var boolean Active
	 */
	public $active;

	/**
	 * @var datetime Date
	 */
	public $date;

	/**
	 * @var string Title
	 */
	public $title;

	/**
	 * @var string Text
	 */
	public $text;

	/**
	 * @var string Url
	 */
	public $url;

	/**
	 * @var cms\news\common\models\News
	 */
	private $_object;

	/**
	 * @inheritdoc
	 * @param cms\news\common\models\News $object 
	 */
	public function __construct(\cms\news\common\models\News $object, $config = [])
	{
		$this->_object = $object;

		//attributes
		$this->active = $object->active == 0 ? '0' : '1';
		$this->date = $object->date;
		$this->title = $object->title;
		$this->text = $object->text;
		$this->url = $object->url;

		parent::__construct($config);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'active' => Yii::t('news', 'Active'),
			'date' => Yii::t('news', 'Date'),
			'title' => Yii::t('news', 'Title'),
			'text' => Yii::t('news', 'Text'),
			'url' => Yii::t('news', 'Url'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['active', 'boolean'],
			['date', 'string'],
			['title', 'string', 'max' => 100],
			['text', 'string'],
			['url', 'string', 'max' => 200],
			['title', 'required'],
		];
	}

	/**
	 * Saving object using model attributes
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		$object = $this->_object;

		$object->active = $this->active == 1;
		$object->date = $this->date;
		$object->title = $this->title;
		$object->text = $this->text;
		$object->url = empty($this->url) ? null : $this->url;

		if (!$object->save(false))
			return false;

		return true;
	}

}
