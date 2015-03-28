<?php
/**
 * Created by PhpStorm.
 * User: pavel
 * Date: 27.03.15
 * Time: 22:29
 */

namespace frontend\controllers;


use yii\web\Controller;

class TestController extends Controller
{
    public function actionStart()
    {
        return $this->render('start');
    }

    public function actionVariantA()
    {
        return $this->render('variantA');
    }

    public function actionVariantB()
    {
        return $this->render('variantB');
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }
} 