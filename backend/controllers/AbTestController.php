<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 27.03.2015
 * Time: 13:09
 */

namespace backend\controllers;


use backend\models\AbTest;
use backend\models\AbTestForm;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class AbTestController extends Controller
{
	/**
	 * Страница создания теста
	 *
	 * @return string
	 * @throws \yii\base\Exception
	 */
	public function actionNew()
	{
		$form = new AbTestForm();
		if (\Yii::$app->request->isPost && isset($_POST['AbTestForm'])) {
			$form->attributes = $_POST['AbTestForm'];
			//echo get_class(\Yii::$app->user);exit;
			$form->user = \Yii::$app->user;
			$abTest = $form->save();
			if ($abTest) {
				\Yii::$app->response->redirect(['ab-test/view', 'id' => $abTest->id]);
			}
		}

		return $this->render('new', [
			'abTestForm' => $form,
		]);
	}

	/**
	 * Страница просмотра теста
	 * @param $id
	 */
	public function actionView($id)
	{
		$abTest = AbTest::findOne($id);
		if (!is_object($abTest)) {
			throw new NotFoundHttpException();
		}
		if ($abTest->user_id !== \Yii::$app->user->id) {
			throw new ForbiddenHttpException();
		}

		return $this->render('view', [
			'abTest' => $abTest,
		]);
	}
}