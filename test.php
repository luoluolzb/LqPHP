<?php

$str = 'www.baidu.com';

$pattern = '/\w+.\w+.\w+/';

$str = preg_match($pattern, $str, $matches);

print_r($matches);
