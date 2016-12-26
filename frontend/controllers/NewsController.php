<?php

namespace cms\news\frontend\controllers;

use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Controller;

use cms\news\common\models\News;

class NewsController extends Controller
{

	public function actionIndex()
	{
		$query = News::find()
			->andWhere(['active' => true])
			->orderBy(['date' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($alias)
	{
		$model = News::findByAlias($alias);
		if ($model === null || !$model->active)
			throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));

		return $this->render('view', [
			'model' => $model,
		]);
	}

}
