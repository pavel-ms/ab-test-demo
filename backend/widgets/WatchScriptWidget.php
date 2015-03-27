<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 27.03.2015
 * Time: 17:08
 */

namespace backend\widgets;


use yii\base\Widget;

class WatchScriptWidget extends Widget
{
	public $abTest;

	public function run()
	{
		return $this->render('watchScript', [
			'abTest' => $this->abTest,
		]);
	}
}