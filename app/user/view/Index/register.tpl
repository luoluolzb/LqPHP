<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>用户注册</title>
    <link href="/static/libs/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">

.error{
	color: red;
}

#captcha{
	cursor: pointer;
	border: 1px solid grey;
}

	</style>
  </head>
  <body>
  	<div class="container">
	{if $success}
	<p>注册成功！<a href="/user/index/validate/{$val_id}">点击这里激活账号</a></p>
	{else}
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
		    	<h1 class="text-center">用户注册</h1>
		    	<p class="error">{$errmsg}</p>
				<form action="" method="post">
					<div class="form-group">
						<input type="text" class="form-control" id="user" placeholder="用户名, 6-10位字母或数字" name="user_name" value="{$user_name}">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="passwd" placeholder="密码, 6-12位字母或数字" name="passwd" value="{$passwd}">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="passwd-r" placeholder="确认密码" value="{$passwd}">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<input type="text" class="form-control" id="" placeholder="验证码" name="captcha">
							</div>
							<div class="col-md-6">
								<img src="/captcha" id="captcha" title="点击切换" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">注册</button>
					</div>
				</form>
			</div>
		</div>
	{/if}
  	</div>

    <script src="/static/libs/jquery/jquery-1.12.4.min.js"></script>
    <script src="/static/libs/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
 $(function(){
 	$('form').submit(function(){
 		if ($('#passwd').val() != $('#passwd-r').val()) {
 			alert('两次输入的密码不一致!');
 			return false;
 		}
 	});

 	$('#captcha').click(function(){
 		$(this).attr('src', $(this).attr('src'));
 	});
 });
    </script>
  </body>
</html>