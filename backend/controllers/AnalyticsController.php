<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 27.03.15
 * Time: 23:38
 */

namespace backend\controllers;


use backend\models\AbTest;
use backend\models\Enum;
use backend\models\TestAction;
use common\components\BaseJsonpController;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class AnalyticsController extends BaseJsonpController
{

    /**
     * Получение настроек приложения
     *
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionSettings()
    {
        $abTestId = \Yii::$app->request->getQueryParam('id');
        if (is_null($abTestId)) {
            throw new BadRequestHttpException('id param must be set');
        }

        $abTest = AbTest::findOne(intval($abTestId));
        if (is_null($abTest)) {
            throw new NotFoundHttpException('AB Test was not found');
        }

        return $this->_sendResponse($abTest->attributes);
    }

    /**
     * Метода для сбора аналитики
     *
     * @throws BadRequestHttpException
     * @param $action
     * @param $variant
     * @return string
     */
    public function actionGrabData($action, $variant, $id)
    {
        try {
            $actionType = Enum::get('action_types.' . $action);
            $testVariant = Enum::get('test_variants.' . $variant);
            $abTest = AbTest::findOne(intval($id));
            if (is_null($abTest)) {
                throw new \Exception('That test not exist');
            }
        } catch(\Exception $e) {
            throw new BadRequestHttpException('The arguments is not valid');
        }

        $a = new TestAction();
        $a->action_type = $actionType->id;
        $a->variant = $testVariant->id;
        $a->test_id = (int) $id;

        if ($a->save()) {
            $a->refresh();
            return $this->_sendResponse(['result' => 'ok']);
        } else {
            throw new BadRequestHttpException('There is something wrong');
        }
    }


} 