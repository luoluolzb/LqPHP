<?php
/**
 * @description LqPHP入口文件
 * @author      luoluolzb
 */

//加载框架入口文件
require __DIR__ . '/../lqphp/boot.php';

lqphp\App::instance()->run();
