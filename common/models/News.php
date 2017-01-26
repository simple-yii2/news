<?php

namespace cms\news\common\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;

use helpers\Translit;
use dkhlystov\storage\components\StoredInterface;

class News extends ActiveRecord implements StoredInterface
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

		if ($this->active === null)
			$this->active = true;
		
		if ($this->date === null)
			$this->date = date('Y-m-d H:i:s');
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'sitemap' => [
				'class' => 'cms\sitemap\common\behaviors\SitemapBehavior',
				'loc' => function($model) {
					return Url::toRoute(['/news/news/view', 'alias' => $model->alias]);
				},
				'active' => 'active',
			],
		];
	}

	/**
	 * Find by alias
	 * @param sring $alias alias or id
	 * @return static
	 */
	public static function findByAlias($alias)
	{
		$model = static::findOne(['alias' => $alias]);
		if ($model === null)
			$model = static::findOne(['id' => $alias]);

		return $model;
	}

	/**
	 * Making alias from title and id
	 * @return void
	 */
	public function makeAlias()
	{
		$this->alias = Translit::t($this->title . '-' . $this->id);
	}

	/**
	 * Parsing html for files in <img> and <a>
	 * @param string $content 
	 * @return string[]
	 */
	protected function getFilesFromContent($content)
	{
		if (preg_match_all('/(?:src|href)="([^"]+)"/i', $content, $matches))
			return $matches[1];

		return [];		
	}

	/**
	 * @inheritdoc
	 */
	public function getOldFiles()
	{
		return $this->getFilesFromContent($this->getOldAttribute('content'));
	}

	/**
	 * @inheritdoc
	 */
	public function getFiles()
	{
		return $this->getFilesFromContent($this->content);
	}

	/**
	 * @inheritdoc
	 */
	public function setFiles($files)
	{
		$content = $this->content;
		foreach ($files as $from => $to) {
			$content = str_replace($from, $to, $content);
		}

		$this->content = $content;
	}

}
