<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "enum".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $parent
 * @property string $name
 * @property string $sys_name
 * @property string $descr
 *
 * @property TestAction[] $testActions
 */
class Enum extends \yii\db\ActiveRecord
{
	/**
	 * Флак использования кэша для перечислений
	 * @var bool
	 */
	private static $_useCache = true;

	/**
	 *
	 */
	const CACHE_KEY = 'enum_table_cache';

	/**
	 * Сохраняем закешированные значение перечислений
	 * @var array
	 */
	protected static $_cache = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['parent'], 'integer'],
            [['name', 'sys_name'], 'required'],
            [['descr'], 'string'],
            [['name', 'sys_name'], 'string', 'max' => 120],
            [['parent', 'sys_name'], 'unique', 'targetAttribute' => ['parent', 'sys_name'], 'message' => 'The combination of Parent and Sys Name has already been taken.']
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
            'parent' => 'Parent',
            'name' => 'Name',
            'sys_name' => 'Sys Name',
            'descr' => 'Descr',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestActions()
    {
        return $this->hasMany(TestAction::className(), ['variant' => 'id']);
    }

	/**
	 * Извлекает справочник по пути к нему, возвращает объект типа enum или массив enum,
	 * если была переданна `*`
	 * @param $path
	 * @return mixed
	 */
	public static function get($path) {
		if (self::$_useCache && empty(self::$_cache)) {
			self::$_cache = Yii::$app->cache->get(self::CACHE_KEY);
		}

		if (empty(self::$_cache[$path])) {
			$result = self::_find(explode('.', $path));
			if (self::$_useCache) {
				self::$_cache[$path] = $result;
				register_shutdown_function(function() { Enum::_updateCache(); });
			}
		} else {
			$result = self::$_cache[$path];
		}

		return $result;
	}

	/**
	 * Возвращает объект Enum по его id
	 * @todo: кэширование!!!
	 * return Enum
	 */
	public static function getById($id)
	{
		return Enum::find()->where('enum.id = :id', [':id' => $id])->one();
	}


	/**
	 * Рекурсивно извлекает данные по справочнику
	 * @param array $path
	 * @param int $offset
	 * @param Enum $parent
	 * @throws \Exception
	 * @return Enum
	 */
	protected static function _find(array $path, $offset = 0, $parent = null)
	{
		$qBuilder = self::find();

		if ($path[$offset] === '*') {  // все дети данного parent-а
			return $qBuilder->where('parent ' . (!is_null($parent) ? ' = ' . $parent->id : 'IS NULL'))->all();
		} else {  // ребенок по sys_name
			$target = $qBuilder
				->where('sys_name = :sn AND parent ' . (!is_null($parent) ? ' = ' . $parent->id : 'IS NULL'), [
					':sn' => $path[$offset],
				])
				->one();
		}
		// Если нет такого пути, выкиним exception
		if (is_null($target)) {
			throw new \Exception('Cat`n find enum field. Be sure the path is correct. '
				. $offset . ' parent: ' . /*$parent->id . */' path: ' . $path[$offset]);
		}

		if (count($path)-1 === $offset) {
			return $target;
		} else {
			// рекурсия
			return self::_find($path, $offset + 1, $target);
		}
	}

	/**
	 * Обновляет значения для переменных enum
	 */
	public static function _updateCache()
	{
		Yii::$app->cache->set(self::CACHE_KEY, self::$_cache, 3600);
	}
}
