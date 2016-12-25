<?php

namespace cms\news\backend\models;

use Yii;
use yii\data\ActiveDataProvider;

use cms\news\common\models\News;

/**
 * Search model
 */
class NewsSearch extends News {

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			['title', 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'date' => Yii::t('news', 'Date'),
			'title' => Yii::t('news', 'Title'),
		];
	}

	/**
	 * Search function
	 * @param array $params Attributes array
	 * @return yii\data\ActiveDataProvider
	 */
	public function search($params) {
		//ActiveQuery
		$query = static::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		//return data provider if no search
		if (!($this->load($params) && $this->validate()))
			return $dataProvider;

		//search
		$query->andFilterWhere(['like', 'title', $this->title]);

		return $dataProvider;
	}

}
