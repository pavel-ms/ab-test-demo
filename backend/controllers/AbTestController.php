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
use backend\models\Enum;
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
     *
     * @throws NotFoundHttpException|ForbiddenHttpException
	 * @param $id
     * @return string
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
            'analytics' => $this->_formatAnalytics($abTest),
		]);
	}

    /**
     * Формируем аналитику
     *
     * @param AbTest $abTest
     * @return array
     */
    protected function _formatAnalytics(AbTest $abTest)
    {
        // Получить показы сгруппированные по варианту
        $analytics = \Yii::$app->db
            ->createCommand('
                SELECT count(ta.id) cnt, v.sys_name variant, at.sys_name action_type, at.id action_type_id
                FROM test_action ta
                  INNER JOIN enum v ON ta.variant = v.id
                  INNER JOIN enum at ON ta.action_type = at.id
                WHERE ta.test_id = ' . $abTest->id . '
                GROUP BY v.id, at.id;
            ')
            ->queryAll();
        $result = [];
        foreach ($analytics as $row) {
            $result[$row['action_type']][$row['variant']] = $row['cnt'];
        }

        return $result;
    }

}