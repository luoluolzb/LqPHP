<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>用户信息</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/static/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container">
		<h1 class="text-center">用户信息</h1>
		{if $login}
			<p>用户ID：{$user.id}</p>
			<p>用户名：{$user.name}</p>
			<p>激活状态：{if $user.checked} 已激活 {else} 未激活 {/if}</p>
			<a href="/user/index/logout">登出</a>
		{else}
			<a class="btn btn-primary" href="/user/index/login">登陆</a>
			<a class="btn btn-primary" href="/user/index/register">注册</a>
		{/if}
	</div>
    <script src="/static/jquery/jquery-1.12.4.min.js"></script>
    <script src="/static/bootstrap-3.3.7/js/bootstrap.min.js"></script>
</body>
</html>