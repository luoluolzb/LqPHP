<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>validate</title>
</head>
<body>
	<p>用户：{$user_name}</p>
	{if $success}
		<p>激活成功！<a href="/user/index/login">点击登陆</a></p>
	{else}
	<p>激活失败！</p>
	{/if}
</body>
</html>