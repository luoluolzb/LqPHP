<?php
namespace app\test\controller;

class View extends \lqphp\Controller
{
	// 视图测试
	public function index()
	{
		$view = view();
		$view->assign('title', 'LqPHP');
		$view->assign('name', 'luoluolzb');
		return $view;
	}
}
