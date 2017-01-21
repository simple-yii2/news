<?php

namespace cms\news\backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

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
	 * @var datetime Time
	 */
	public $time;

	/**
	 * @var string Title
	 */
	public $title;

	/**
	 * @var string Preview
	 */
	public $preview;

	/**
	 * @var string Text
	 */
	public $content;

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
		$a = explode(' ', $object->date);
		$this->date = ArrayHelper::getValue($a, 0, '');
		$this->time = ArrayHelper::getValue($a, 1, '');
		$this->title = $object->title;
		$this->preview = $object->preview;
		$this->content = $object->content;

		//file caching
		Yii::$app->storage->cacheObject($object);

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
			'time' => Yii::t('news', 'Time'),
			'title' => Yii::t('news', 'Title'),
			'preview' => Yii::t('news', 'Preview'),
			'content' => Yii::t('news', 'Content'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['active', 'boolean'],
			['date', 'match', 'pattern' => '/^\d{4}\-\d{2}\-\d{2}$/'],
			['time', 'match', 'pattern' => '/^\d{2}:\d{2}:\d{2}$/'],
			['title', 'string', 'max' => 100],
			['preview', 'string', 'max' => 1000],
			['content', 'string'],
			[['date', 'title'], 'required'],
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
		$isNewRecord = $object->getIsNewRecord();

		$object->active = $this->active == 1;
		$object->date = $this->date . ' ' . $this->time;
		$object->title = $this->title;
		$object->preview = $this->preview;
		$object->content = $this->content;

		Yii::$app->storage->storeObject($object);

		if (!$object->save(false))
			return false;

		if ($isNewRecord) {
			$object->makeAlias();
			$object->update(false, ['alias']);
		}

		return true;
	}

}
