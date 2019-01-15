<?php
/**
 * @description 模型基类
 * @author      luoluolzb
 */
namespace lqphp;

abstract class Model
{
	/**
	 * 数据表
	 * @var string
	 */
	protected $table;

	/**
	 * 数据记录
	 * @var array
	 */
	protected $data;

	/**
	 * 数据库对象
	 * @var Database Object
	 */
	protected $db;

	/**
	 * 构造方法
	 */
	public function __construct()
	{
		if (!isset($this->table)) {
			$this->table = $this->getTable();
		}
		$this->data = [];
		$this->db = Db::instance();
	}

	/**
	 * 根据类名获取表名
	 * @return string
	 */
	protected function getTable()
	{
		$class = implode('', array_slice(explode('\\',  get_class($this)), -1));
		return strtolower($class);
	}

	/**
	 * 设置数据表
	 * @param string $name  字段
	 * @param mixed  $value 值
	 */
	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	/**
	 * 获取一个字段数据
	 * @param  string $name 字段
	 * @return mixed
	 */
	public function __get($name)
	{
		return $this->data[$name];
	}

	/**
	 * 设置/获取数据
	 * @param  string $name 字段
	 * @return mixed
	 */
	public function data($name = null, $value = null)
	{
		if (!isset($name)) {           //返回所有数据
			return $this->data;
		} else if (is_array($name)) {  //合并一个数组
			$this->data = array_merge($this->data, $name);
		} else if (isset($value)){     //设置一个字段值
			$this->data[$name] = $value;
		} else {                       //获取一个字段值
			return $this->data[$name];
		}
	}

	/**
	 * 保存记录到数据库
	 * @param  array $data 数据[可选]
	 * @return integer(id) | null
	 */
	public function save($data = null)
	{
		$res = $this->db->insert($this->table, isset($data) ? $data : $this->data);
		return $res ? $this->db->id() : null;
	}

	/**
	 * 从数据库读取一行记录到模型
	 * @return false | object
	 */
	public static function get($where = null)
	{
		$obj = new static;
		if (isset($where) && !is_array($where)) {
			$where = ['id' => $where];
		}
		$data = $obj->db->get($obj->table, '*', $where);
		if ($data) {
			$obj->data = $data;
			return $obj;
		} else {
			return null;
		}
	}

	/**
	 * 从数据库读取多行记录
	 * @return boolean
	 */
	public static function gets($where = null)
	{
		$obj = new static;
		return $obj->db->select($obj->table, '*', $where);
	}

	/**
	 * 从数据库读取多行记录到模型
	 * @return boolean
	 */
	public function update($where = null)
	{
		if (isset($where) && !is_array($where)) {
			$where = ['id' => $where];
		}
		$data = $this->db->update($this->table, $this->data, $where);
		return $data->rowCount();
	}

	/**
	 * 从数据库读取多行记录到模型
	 * @return bool
	 */
	public static function delete($where = null)
	{
		$obj = new static;
		if (isset($where) && !is_array($where)) {
			$where = ['id' => $where];
		}
		$data = $obj->db->delete($obj->table, $where);
		return $data->rowCount();
	}

	/**
	 * 魔术方法：让此类可以调用数据库对象方法
	 * @param  string $method    方法名
	 * @param  array  $args      参数列表
	 * @return mixed
	 */
	public function __call($method, $args) 
	{
		array_unshift($args, $this->table);
		return call_user_func_array([$this->db, $method], $args);
	}

	/**
	 * 返回数据库操作错误信息
	 * @return array
	 */
	public function error()
	{
		return $this->db->error();
	}

	/**
	 * 获取关联模型对象
	 * @return Model
	 */
	private function getModel($class)
	{
		$class = implode('\\',
			array_slice(explode('\\', get_class($this)), 0, -1)
		) . '\\' . $class;
		return new $class;
	}

	/************************* 关联查询 *************************/

	/**
	 * 获取关联模型：一对一关联
	 * @param  string  $class  关联模型名
	 * @param  string  $field1 父表字段
	 * @param  string  $field2 子表字段
	 * @return Model
	 */
	protected function hasOne($class, $field1 = 'id', $field2 = null)
	{
		$obj = $this->getModel($class);
		if (!isset($field2)) {
			$field2 = $this->table . '_id';
		}
		return $obj->get([$field2 => $this->data($field1)]);
	}

	/**
	 * 获取关联模型：一对多关联
	 * @param  string  $class  关联模型名
	 * @param  string  $field1 父表字段
	 * @param  string  $field2 子表字段
	 * @return array
	 */
	protected function hasMany($class, $field1 = 'id', $field2 = null)
	{
		$obj = $this->getModel($class);
		if (!isset($field2)) {
			$field2 = $this->table . '_id';
		}
		return $obj->gets([$field2 => $this->data($field1)]);
	}

	/**
	 * 获取关联模型：一对一关联 或 多对一关联
	 * @param  string  $class  关联模型名
	 * @param  string  $field1 子表字段
	 * @param  string  $field2 父表字段
	 * @return Model
	 */
	protected function belongsTo($class, $field1 = null, $field2 = 'id')
	{
		$obj = $this->getModel($class);
		if (!isset($field1)) {
			$field1 = $obj->table . '_id';
		}
		return $obj->get([$field2 => $this->data($field1)]);
	}

	/**
	 * 获取关联模型：多对一关联
	 * @param  string  $class   关联模型名
	 * @param  string  $middle  中间模型名
	 * @return array
	 */
	protected function belongsToMany($class, $middle)
	{
		$obj = $this->getModel($class);
		$obj_m = $this->getModel($middle);
		$field1 = $this->table . '_id';
		$field2 = $obj->table . '_id';
		$data = $obj_m->gets([$field1 => $this->data('id')]);
		$res = [];
		foreach ($data as $link) {
			$res[] = $obj->get([
				'id' => $link[$field2]
			])->data();
		}
		return $res;
	}
}
