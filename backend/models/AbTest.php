<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ab_test".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property string $name
 * @property integer $user_id
 * @property string $bootstrap_url
 * @property string $a_url
 * @property string $b_url
 * @property string $success_url
 *
 * @property User $user
 * @property TestAction[] $testActions
 */
class AbTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ab_test';
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
            [['name', 'bootstrap_url', 'a_url', 'b_url', 'success_url'], 'required'],
            [['user_id'], 'integer'],
            [['name', 'bootstrap_url', 'a_url', 'b_url', 'success_url'], 'string', 'max' => 255]
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
            'name' => 'Name',
            'user_id' => 'User ID',
            'bootstrap_url' => 'Bootstrap Url',
            'a_url' => 'A Url',
            'b_url' => 'B Url',
            'success_url' => 'Success Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestActions()
    {
        return $this->hasMany(TestAction::className(), ['test_id' => 'id']);
    }
}
