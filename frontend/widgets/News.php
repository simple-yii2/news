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
	public $layout = "{items}";

	public $maxCount = 5;

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

		if ($this->dataProvider->pagination)
			$this->dataProvider->pagination->pageSize = $this->maxCount;
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

		$d = strtotime($model->date);
		$date = Html::tag('strong', Yii::$app->formatter->asDate($d, 'short'));

		$title = Html::a(Html::encode($model->title), $this->getItemUrl($model));

		$header = Html::tag('div', $date . ' ' . $title);

		$preview = Html::tag('p', Html::encode($model->preview));

		return $header . $preview;
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
