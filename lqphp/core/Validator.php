<?php
/**
 * @description 数据验证器
 * @author      luoluolzb
 */
namespace lqphp;
use \lqphp\comp\Session;

class Validator
{
	/**
	 * 验证规则表
	 * @var array
	 * $rule = [
		'name'    => string,
	    'require' => bool,
	    'value'   => mixed,
	    'type'    => 'string|number|integer|float|bool|array|email|url|alpha|alnum|ip|captcha',
	    'min'     => integer,
	    'max'     => integer,
	    'range'   => [min, max],
	    'enum'    => [v1, v2, v3, ..],
	    'pattern' => string,
	    'captcha' => ['sessoin_name' => string, 'ignore_case' => bool],
	];
	 * 每个键值对应一条规则，以上的每条规则都是可选的
	 */
	protected $rules = [];

	/**
	 * 验证失败的提示信息
	 * @var string
	 */
	protected $error;

	/**
	 * 构造函数
	 * @param array $rules 验证规则列表
	 */
	public function __construct($rules = null)
	{
		if (isset($rules)) {
			$this->rules = $rules;
		}
		$this->error = '';
	}

	/**
	 * 添加验证规则
	 * @param string $key   验证数据键值
	 * @param array  $rule  验证规则
	 */
	public function addRule($key, $rule)
	{
		$this->rules[$key] = $rule;
	}

	/**
	 * 验证多个数据
	 * @param  array $data 数据
	 * @return bool
	 */
	public function validate(&$data)
	{
		foreach ($data as $key => &$value) {
			if(isset($this->rules[$key])
			&& !$this->validateOne($key, $value, $this->rules[$key])) {
				return false;
			}
		}
		return true;
	}

	/**
	 * 验证一个数据
	 * @param  string $key   验证数据键值
	 * @param  mixed  $value 数据
	 * @param  array  $rule  验证规则
	 * @return bool
	 */
	public function validateOne($key, $value, $rule)
	{
		$name = isset($rule['name']) ? $rule['name'] : $key;

		if (isset($rule['require']) && $rule['require']) {
			if (!isset($value) || $value == '') {
				$this->error = $name . '是必填项!';
				return false;
			}
		}

		if (isset($rule['type'])) {
			switch ($rule['type']) {
				case 'string':
					if (!is_string($value)) {
						$this->error = $name . '不是字符串!';
						return false;
					}
					break;
				
				case 'number':
					if (!is_numeric($value)) {
						$this->error = $name . '不是数字!';
						return false;
					}
					break;
				
				case 'integer':
					if (false === filter_var($value, FILTER_VALIDATE_INT)) {
						$this->error = $name . '不是整数!';
						return false;
					}
					break;
				
				case 'float':
					if (false === filter_var($value, FILTER_VALIDATE_FLOAT)) {
						$this->error = $name . '不是浮点数!';
						return false;
					}
					break;
				
				case 'bool':
					if (!is_bool($value)) {
						$this->error = $name . '不是布尔值!';
						return false;
					}
					break;
				
				case 'array':
					if (!is_array($value)) {
						$this->error = $name . '不是数组!';
						return false;
					}
					break;
				
				case 'email':
					if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
						$this->error = $name . '不是有效的邮箱格式!';
						return false;
					}
					break;
				
				case 'url':
					if (false === filter_var($value, FILTER_VALIDATE_URL)) {
						$this->error = $name . '不是正确的url地址!';
						return false;
					}
					break;

				case 'alpha':
					if (!ctype_alpha($value)) {
						$this->error = $name . '不是纯字母组成!';
						return false;
					}
					break;
				
				case 'alnum':
					if (!ctype_alnum($value)) {
						$this->error = $name . '不是字母和数字组成!';
						return false;
					}
					break;
				
				case 'ip':
					if (false === filter_var($value, FILTER_VALIDATE_IP)) {
						$this->error = $name . '不是有效的IP!';
						return false;
					}
					break;
				
				default:
					break;
			}
		}

		if (isset($rule['value'])) {
			if ($value != $rule['value']) {
				$this->error = $name . '不正确!';
				return false;
			}
		}

		if (isset($rule['max']) || isset($rule['min'])) {
			$len = strlen($value);
			if (isset($rule['max']) && $len > $rule['max']) {
				$this->error = $name . '长度必须不大于' . $rule['max'] . '!';
				return false;
			}
			if (isset($rule['min']) && $len < $rule['min']) {
				$this->error = $name . '长度必须不小于' . $rule['min'] . '!';
				return false;
			}
		}
		if (isset($rule['range'])) {
			if ((isset($rule['range'][0]) && $value < $rule['range'][0])
			  ||(isset($rule['range'][1]) && $value > $rule['range'][1])) {
				$this->error = $name . '必须在[' . $rule['range'][0] . ', ' . $rule['range'][1] . ']之间!';
				return false;
			}
		}
		if (isset($rule['enum'])) {
			if (false === array_search($value, $rule['enum'])) {
				$this->error = $name . '不在正确的取值范围内！';
				return false;
			}
		}
		if (isset($rule['pattern'])) {
			if (!preg_match($rule['pattern'], $value)) {
				$this->error = $name . '格式不正确!';
				return false;
			}
		}
		if (isset($rule['captcha'])) {
			$captcha = Session::instance()->get($rule['captcha']['sessoin_name']);
			$compare = $rule['captcha']['ignore_case'] ? 'strcasecmp' : 'strcmp';
			if (0 !== $compare($captcha, $value)) {
				$this->error = $name . '不正确!';
				return false;
			}
		}
		return true;
	}

	/**
	 * 获取验证产生的错误信息
	 * @return string
	 */
	public function error()
	{
		return $this->error;
	}
}
