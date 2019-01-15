<?php
namespace app\lottery\controller;

class Index extends \lqphp\Controller
{
	public function index()
	{
		return view();
	}

	public function lottery()
	{
		$amount = [80, 2, 3, 2, 3, 2, 3, 5];
		for ($i = 1; $i < 8; $i ++) { 
			$amount[$i] += $amount[$i - 1];
		}
		$num = mt_rand(0, 99);
		$result = -1;
		for ($i = 0; $i < 8; $i ++) {
			if ($num < $amount[$i]) {
				$result = $i;
				break;
			}
		}
		return [
			'errcode' => 0,
			'result' => $result
		];
	}
}
