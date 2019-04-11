<?php
/* Smarty version 3.1.31, created on 2019-04-11 17:52:12
  from "E:\code\htdocs\LqPHP\app\lottery\view\Index\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5caf0e4cd89504_43855266',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8aa4f40a049b4b9b32cc345384f29ec73ff44fb' => 
    array (
      0 => 'E:\\code\\htdocs\\LqPHP\\app\\lottery\\view\\Index\\index.tpl',
      1 => 1554975709,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5caf0e4cd89504_43855266 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>抽奖 - LqPHP</title>
	<style type="text/css">

body{
	background: #eee;
}

main{
	background: #fff;
	margin-top: 15px;
	width: 850px;
	margin-left: auto;
	margin-right: auto;
	padding: 15px 40px;
}

main>h1{
	text-align: center;
}

li{
	margin: 0;
	list-style: none;
	padding: 25px 0px;
	border: 2px solid #000;
	display: inline-block;
	width: 200px;
	margin-top: 15px;
	text-align: center;
}

li.start{
	background: red;
	font-weight: bold;
	color: #fff;
	cursor: pointer;
}

li.active{
	background: #fe0;
}

footer{
	margin-top: 30px;
	text-align: center;
	font-weight: bold;
}

	</style>
</head>
<body>
	<main>
		<h1>抽奖</h1>
		<ul>
			<div>
				<li class="active">谢谢参与</li>
				<li>iPhone XS</li>
				<li>iPad</li>
			</div>
			<div>
				<li>iReader阅读器</li>
				<li class="start">开始抽奖</li>
				<li>笔记本电脑</li>
			</div>
			<div>
				<li>空调</li>
				<li>液晶电视</li>
				<li>Honor10</li>
			</div>
		</ul>
		<footer>
			<p>luoluolzb 2018/2/2</p>
		</footer>
	</main>
	<?php echo '<script'; ?>
 src="/static/libs/jquery/jquery-1.12.4.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript">

//随机产生一个[min, max)整数
function random(min, max) {
    return min +  Math.floor(Math.random() * 9999999) % (max - min);
}

$(function(){
	$list = $('li:not(.start)');
	var map = [0, 1, 2, 4, 7, 6, 5, 3];  //奖品序号所在的list索引
	var lock = false;  //状态锁，抽奖过程无法点击
	var index = 0;     //当前奖品序号
	var result;        //获得的奖品序号

	function onEnd()
	{
		lock = false;
		setTimeout(function() {
			if (result != 0){
				alert('恭喜您获得：' + $list.eq(map[index]).text());
			} else {
				alert('很遗憾，您离中奖只有一步之遥!');
			}
		}, 100);
	}

	$('li.start').click(function(){
		if (lock) {
			return false;
		}
		lock = true;
		$.ajax({
			'url': '/lottery/index/lottery',
			'type': 'get',
			'dataType': 'json',
			'success': function(data, textStatus, jqXHR) {
				if (textStatus != 'success') {
					return ;
				}
				result = data.result;
				count = 8*random(4, 8) + result + (8 - index);
				var i = 0, t = 50;
				var timer = function() {
					$list.eq(map[index]).removeClass('active');
					index = (index + 1) % 8;
					$list.eq(map[index]).addClass('active');
					if (++ i < count) {
						setTimeout(timer, t);
						t += 2;
					} else {
						onEnd();
					}
				}
				timer();
			},
		});
	});
});
	<?php echo '</script'; ?>
>
</body>
</html><?php }
}
