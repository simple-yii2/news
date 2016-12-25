<?php

namespace cms\news\backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use cms\news\backend\models\NewsForm;
use cms\news\backend\models\NewsSearch;
use cms\news\common\models\News;

class NewsController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					['allow' => true, 'roles' => ['News']],
				],
			],
		];
	}

	/**
	 * List
	 * @return void
	 */
	public function actionIndex()
	{
		$model = new NewsSearch;

		return $this->render('index', [
			'dataProvider' => $model->search(Yii::$app->getRequest()->get()),
			'model' => $model,
		]);
	}

	/**
	 * Creating
	 * @return void
	 */
	public function actionCreate()
	{
		$model = new NewsForm(new News);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('news', 'Changes saved successfully.'));
			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updating
	 * @param integer $id
	 * @return void
	 */
	public function actionUpdate($id)
	{
		$object = News::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('news', 'Item not found.'));

		$model = new NewsForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('news', 'Changes saved successfully.'));
			return $this->redirect(['index']);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deleting
	 * @param integer $id
	 * @return void
	 */
	public function actionDelete($id)
	{
		$object = News::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('news', 'Item not found.'));

		if ($object->delete()) {
			Yii::$app->session->setFlash('success', Yii::t('news', 'Item deleted successfully.'));
		}

		return $this->redirect(['index']);
	}

}
