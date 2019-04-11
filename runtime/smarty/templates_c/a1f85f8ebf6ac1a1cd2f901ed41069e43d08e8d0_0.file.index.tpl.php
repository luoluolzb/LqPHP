<?php
/* Smarty version 3.1.31, created on 2019-04-11 17:40:48
  from "E:\code\htdocs\LqPHP\app\guestbook\view\Index\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5caf0ba0baf563_43254563',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a1f85f8ebf6ac1a1cd2f901ed41069e43d08e8d0' => 
    array (
      0 => 'E:\\code\\htdocs\\LqPHP\\app\\guestbook\\view\\Index\\index.tpl',
      1 => 1554975635,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5caf0ba0baf563_43254563 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once 'E:\\code\\htdocs\\LqPHP\\vendor\\smarty\\smarty\\libs\\plugins\\modifier.date_format.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>留言本 - LqPHP</title>
    <link rel="stylesheet" type="text/css" href="/static/libs/lqphp/lqphp-pager.css" />
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

form{
	margin-top: 15px;
}

#user,
#content
{
	display: block;
	margin-bottom: 10px;
	padding: 5px;
	width: 100%;
}

ul{
	list-style: none;
	padding: 0;
}

.guest{
	margin: 0;
	margin-bottom: 10px;
	padding-bottom: 5px;
	border-bottom: 1px solid #888;
}
	</style>
</head>
<body>
	<main>
		<h1>留言本</h1>
		<form action="" method="post">
			<div>
				<input type="text" name="user" id="user" placeholder="请输入你的昵称" />
			</div>
				<textarea name="content" id="content" rows="5" placeholder="请输入留言内容"></textarea>
			<div>
				<input type="submit" value="留言" />
			</div>
		</form>
		<ul>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['guestList']->value, 'guest');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['guest']->value) {
?>
			<li class="guest">
				<div class="info">
					<span class="user"><?php echo $_smarty_tpl->tpl_vars['guest']->value['user'];?>
</span> 在 <span class="time"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['guest']->value['time'],"%Y-%m-%d %X");?>
</span> 说：
				</div>
				<span class="content"><?php echo nl2br($_smarty_tpl->tpl_vars['guest']->value['content']);?>
</span>
			</li>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

		</ul>
		<?php echo $_smarty_tpl->tpl_vars['pager']->value;?>

	</main>
</body>
</html><?php }
}
