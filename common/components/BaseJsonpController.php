<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 27.03.15
 * Time: 23:42
 */

namespace common\components;


use yii\web\BadRequestHttpException;
use yii\web\Controller;

abstract class BaseJsonpController extends Controller
{

    /**
     * Отправка ответов на jsonp запросы
     *
     * @throws BadRequestHttpException
     * @param array $data
     * @return string
     */
    protected function _sendResponse($data = [])
    {
        if (!isset(\Yii::$app->request->queryParams['cb'])) {
            throw new BadRequestHttpException('The cb param must be set');
        }
        $cb = \Yii::$app->request->queryParams['cb'];

        // @link http://dergeekblog.kerspe.com/?p=184
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        \Yii::$app->response->headers->add('Content-Type', 'application/javascript');

        return $cb . '(' . json_encode($data) . ');';
    }
} 