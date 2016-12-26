<?php

namespace cms\news\frontend\widgets;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

class News extends ListView
{

	/**
	 * @inheritdoc
	 */
	public $layout = "{items}\n{pager}";

	/**
	 * @var string template of item
	 */
	public $itemTemplate = "{title}{date}{preview}";

	/**
	 * @var array title container options
	 */
	public $itemTitleOptions = ['class' => 'h4'];

	/**
	 * @var array date container options
	 */
	public $itemDateOptions = ['class' => 'news-date'];

	/**
	 * @var string route to news module
	 */
	protected static $route;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->dataProvider === null)
			$this->prepareDataProvider();

		parent::init();
	}

	/**
	 * Prepare data provider
	 * @return void
	 */
	private function prepareDataProvider()
	{
		$query = \cms\news\common\models\News::find()
			->andWhere(['active' => true])
			->orderBy(['date' => SORT_DESC]);

		$this->dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function renderItem($model, $key, $index)
	{
		if ($this->itemView !== null)
			return parent::renderItem($model, $key, $index);

		return strtr($this->itemTemplate, [
			'{date}' => $this->renderItemDate($model),
			'{title}' => $this->renderItemTitle($model),
			'{preview}' => $this->renderItemPreview($model),
		]);
	}

	/**
	 * Render date of item
	 * @param cms\news\common\models\News $model 
	 * @return string
	 */
	protected function renderItemDate(\cms\news\common\models\News $model)
	{
		$date = strtotime($model->date);

		return Html::tag('p', Yii::$app->formatter->asDate($date, 'long'), $this->itemDateOptions);
	}

	/**
	 * Render item title
	 * @param cms\news\common\models\News $model 
	 * @return string
	 */
	protected function renderItemTitle(\cms\news\common\models\News $model)
	{
		$title = Html::a(Html::encode($model->title), $this->getItemUrl($model));

		return Html::tag('div', $title, $this->itemTitleOptions);
	}

	/**
	 * Render preview text of item
	 * @param cms\news\common\models\News $model 
	 * @return string
	 */
	protected function renderItemPreview(\cms\news\common\models\News $model)
	{
		return Html::encode($model->preview);
	}

	/**
	 * Return url to news item page
	 * @param cms\news\common\models\News $model 
	 * @return array
	 */
	protected function getItemUrl(\cms\news\common\models\News $model)
	{
		if (static::$route === null)
			$this->prepareRoute();

		return [static::$route, 'alias' => $model->alias];
	}

	/**
	 * Determine news frontend route using application modules 
	 * @return void
	 */
	protected function prepareRoute()
	{
		$route = '';

		foreach (Yii::$app->modules as $name => $module) {
			if ($module instanceof \yii\base\Module) {
				$class = $module::className();
			} elseif (is_array($module)) {
				$class = $module['class'];
			} else {
				$class = (string) $module;
			}

			if ($class === 'cms\news\frontend\Module') {
				$route = '/' . $name . '/news/view';
				break;
			}
		}

		static::$route = $route;
	}

}
