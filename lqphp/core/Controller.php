<?php
/**
 * @description 控制器基类
 * @author      luoluolzb
 */
namespace lqphp;

/**
 * 此类不应该较多方法，以防止占用url行为名称
 */
class Controller
{
	/**
	 * http请求对象
	 * @var lqphp\Request
	 */
	protected $request;
	
	/**
	 * http响应对象
	 * @var lqphp\Response
	 */
	protected $response;

	/**
	 * 构造函数
	 */
	public function __construct()
	{
		$this->request  = Request::instance();
		$this->response = Response::instance();
	}
}
