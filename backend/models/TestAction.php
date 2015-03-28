<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "test_action".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $action_type
 * @property integer $variant
 * @property integer $test_id
 *
 * @property AbTest $test
 * @property Enum $actionType
 * @property Enum $variant0
 */
class TestAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['created_at'], 'default', 'value' => (new \DateTime())->format('Y-m-d H:i:s'), 'on' => 'insert'],
            [['updated_at'], 'default', 'value' => (new \DateTime())->format('Y-m-d H:i:s'), 'on' => 'update'],
            [['action_type', 'variant', 'test_id'], 'integer'],
            [['test_id'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'action_type' => 'Action Type',
            'variant' => 'Variant',
            'test_id' => 'Test ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTest()
    {
        return $this->hasOne(AbTest::className(), ['id' => 'test_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActionType()
    {
        return $this->hasOne(Enum::className(), ['id' => 'action_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariant0()
    {
        return $this->hasOne(Enum::className(), ['id' => 'variant']);
    }
}
