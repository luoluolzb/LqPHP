<?php
namespace app\guestbook\controller;
use app\guestbook\model\Guest;

class Index extends \lqphp\Controller
{
	public function index($index = 1)
	{
		$guest = new Guest();
		//获取留言条数
		$count = $guest->count();
		//获取显示个数
		$size = config('pager.size');
		if (method('POST')) {
			$guest->user = htmlspecialchars(post('user'));
			$guest->content = htmlspecialchars(post('content'));
			if ($guest->user != '' && $guest->content != '') {
				$guest->time = time();
				$guest->save();
			}
		}
		//获取留言列表 
		$guestList = $guest->gets([
			'LIMIT' => [($index - 1)*$size, $size],
			'ORDER' => [
				'time' => 'DESC',
			]
		]);
		$view = view();
		$view->assign('guestList', $guestList);
		$view->assign('pager', pager('/guestbook/index/index/{page}', $index, $count));
		return $view;
	}
}
