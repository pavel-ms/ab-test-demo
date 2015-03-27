<?php

use yii\db\Schema;
use yii\db\Migration;

class m150327_070813_db_creation extends Migration
{
    public function up()
    {
		// Создаем необходимые таблицы

		// таблица enum
		$this->execute('
			CREATE TABLE `enum` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
				`updated_at` DATETIME,
				`parent` INT(11) NULL DEFAULT NULL,
				`name` CHAR(120) NOT NULL,
				`sys_name` CHAR(120) NOT NULL,
				`descr` TEXT NULL,

				PRIMARY KEY (`id`),

				UNIQUE INDEX `unique_parent_sys_name` (`parent`, `sys_name`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		');

		// таблица ab_test
		$this->execute('
			CREATE TABLE `ab_test` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
				`updated_at` DATETIME,
				`name` varchar(255) NOT NULL,
				`user_id` int(11),
				`bootstrap_url` varchar(255) NOT NULL,
				`a_url` varchar(255) NOT NULL,
				`b_url` varchar(255) NOT NULL,
				`success_url` varchar(255) NOT NULL,

				PRIMARY KEY (`id`),

				CONSTRAINT fk_ab_test_to_user FOREIGN KEY (user_id)
					REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE

			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		');

		// таблица
		$this->execute('
			CREATE TABLE `test_action` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
				`updated_at` DATETIME,
				`action_type` int(11),
				`variant` int(11),
				`test_id` int(11) NOT NULL,

				PRIMARY KEY (`id`),

				CONSTRAINT fk_test_action_to_action_type FOREIGN KEY (action_type)
					REFERENCES enum(id) ON UPDATE CASCADE ON DELETE CASCADE,

				CONSTRAINT fk_test_action_to_ab_test FOREIGN KEY (test_id)
					REFERENCES ab_test(id) ON UPDATE CASCADE ON DELETE CASCADE,

				CONSTRAINT fk_test_action_to_variant FOREIGN KEY (variant)
					REFERENCES enum(id) ON UPDATE CASCADE ON DELETE CASCADE

			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		');

		// Заполняем таблицы данными
//		$this->execute('
//			INSERT INTO enum (parent, name, sys_name, descr, );
//		');
    }

    public function down()
    {
		// Удаляем созданные таблицы
        $this->dropTable('test_action');
        $this->dropTable('ab_test');
        $this->dropTable('enum');
    }

}
