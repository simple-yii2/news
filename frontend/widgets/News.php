<?php

namespace cms\news\frontend\widgets;

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

class News extends ListView
{

	public $layout = "{items}\n{pager}";

	public $itemTemplate = "{date}{title}{text}";

	public $encodeTitle = true;

	public $encodeText = true;

	public $itemTitleOptions = ['class' => 'h4'];

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
			'{text}' => $this->renderItemText($model),
		]);
	}

	protected function renderItemDate($model)
	{
		return $model->date;
	}

	protected function renderItemTitle($model)
	{
		$title = $model->title;

		if ($this->encodeTitle)
			$title = Html::encode($title);

		if (!empty($model->url))
			$title = Html::a($title, $model->url);

		return Html::tag('span', $title, $this->itemTitleOptions);
	}

	protected function renderItemText($model)
	{
		$text = $model->text;

		if ($this->encodeText)
			$text = Html::encode($text);
		
		return $text;
	}

}
