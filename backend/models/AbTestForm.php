<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 27.03.2015
 * Time: 13:17
 */

namespace backend\models;

use yii\base\Exception;
use yii\base\Model;

class AbTestForm extends Model
{
	public $name;
	public $domain;
	public $bootstrap_url;
	public $a_url;
	public $b_url;
	public $success_url;

	/**
	 * @var \common\models\User
	 */
	public $user;


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name', 'domain', 'bootstrap_url', 'a_url', 'b_url', 'success_url']
				, 'required'
				, 'message' => 'Это поле не может быть пустым'
			],
			// @link http://stackoverflow.com/questions/10306690/domain-name-validation-with-regex
			[['domain'], 'match'
				, 'pattern' => '/^(([a-zA-Z]{1})|([a-zA-Z]{1}[a-zA-Z]{1})|([a-zA-Z]{1}[0-9]{1})|([0-9]{1}[a-zA-Z]{1})|([a-zA-Z0-9][a-zA-Z0-9-_]{1,61}[a-zA-Z0-9]))\.([a-zA-Z]{2,6}|[a-zA-Z0-9-]{2,30}\.[a-zA-Z]{2,3})$/'
				, 'message' => 'Это поле должно быть валидным доменным именем, например example.com'
			],
			[['bootstrap_url', 'a_url', 'b_url', 'success_url'], 'match'
				, 'pattern' => "/^\/[-?:&=.,/\w\d]*$/"  // Упращенный вариант проверки валидности uri
				, 'message' => 'Это поле должно быть валидным uri, например /test/a'
			]
		];
	}


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'name' => 'Название теста',
			'bootstrap_url' => 'URL точки входа в тест',
			'a_url' => 'URI первого варианта (A)',
			'b_url' => 'URI второго варианта (B)',
			'success_url' => 'URL достижения цели',
		];
	}

	/**
	 * Создает и сохраняет объект AbTest
	 *
	 * @throws Exception
	 * @return AbTest|bool
	 */
	public function save()
	{
		if (!($this->user instanceof \yii\web\User)) {
			throw new Exception('Property user must be set');
		}

		$abTest = new AbTest();
		$abTest->attributes = array_merge($this->attributes, [
			'bootstrap_url' => $this->domain . $this->bootstrap_url,
			'a_url' => $this->domain . $this->a_url,
			'b_url' => $this->domain . $this->b_url,
			'success_url' => $this->domain . $this->success_url,
			'user_id' => $this->user->id,
		]);

		if ($abTest->save()) {
			$abTest->refresh();
			return $abTest;
		} else {
			return false;
		}
	}

}