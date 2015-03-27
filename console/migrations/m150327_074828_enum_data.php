<?php

use yii\db\Schema;
use yii\db\Migration;
use backend\models\Enum;

class m150327_074828_enum_data extends Migration
{
    public function up()
    {
		// Варианты тестов
		$this->insert('enum', [
			'parent' => null,
			'name' => 'Варианты тестов',
			'sys_name' => 'test_variants',
			'descr' => 'Варианты тестов',
		]);
		$this->insert('enum', [
			'parent' => Enum::get('test_variants')->id,
			'name' => 'Вариант A',
			'sys_name' => 'a',
			'descr' => 'Вариант A',
		]);
		$this->insert('enum', [
			'parent' => Enum::get('test_variants')->id,
			'name' => 'Вариант B',
			'sys_name' => 'b',
			'descr' => 'Вариант B',
		]);

		// Действия аналитики
		$this->insert('enum', [
			'parent' => null,
			'name' => 'Типы действий аналитики',
			'sys_name' => 'action_types',
			'descr' => 'Типы действий аналитики',
		]);
		$this->insert('enum', [
			'parent' => Enum::get('action_types')->id,
			'name' => 'Показ варианта',
			'sys_name' => 'show',
			'descr' => 'Показ одного из вариантов пользователю',
		]);
		$this->insert('enum', [
			'parent' => Enum::get('action_types')->id,
			'name' => 'Показ финальной страницы',
			'sys_name' => 'success',
			'descr' => 'Показ финальной страницы',
		]);

    }

    public function down()
    {
		// варианты
		$this->execute("DELETE FROM `enum` WHERE parent = " . Enum::get('test_variants')->id . ';');
		$this->execute("DELETE FROM `enum` WHERE sys_name = 'test_variants';");

		// действия аналитики
		$this->execute("DELETE FROM `enum` WHERE parent = " . Enum::get('action_types')->id . ';');
		$this->execute("DELETE FROM `enum` WHERE sys_name = 'action_types';");
    }
}
