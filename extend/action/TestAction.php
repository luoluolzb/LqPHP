<?php
namespace action;
use \lqphp\library\ActionInterface;

class TestAction implements ActionInterface
{
	public function exec()
	{
		$count = func_num_args();  
		$args = func_get_args();
		echo $count;
		echo format($args);
	}
}
