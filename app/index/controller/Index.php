<?php
namespace app\index\controller;
use \lqphp\Controller;

class Index extends Controller
{
	public function index()
	{
		$view = view();
		$view->assign('version', LQPHP_VERSION);
		return $view;
	}
}