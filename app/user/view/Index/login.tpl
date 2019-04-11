<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>用户登陆</title>
    <link href="/static/libs/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
.error{
	color: red;
}
	</style>
  </head>
  <body>
  	<div class="container">
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
		    	<h1 class="text-center">用户登陆</h1>
		    	<p class="error">{$errmsg}</p>
				<form action="" method="post">
					<div class="form-group">
						<input type="text" class="form-control" id="user" placeholder="用户名" name="user_name" value="{$user_name}">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="passwd" placeholder="密码" name="passwd" value="{$passwd}">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">登陆</button>
					</div>
				</form>
			</div>
		</div>
  	</div>
    <script src="/static/libs/jquery/jquery-1.12.4.min.js"></script>
    <script src="/static/libs/bootstrap-3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript">
 $(function(){
 	
 });
    </script>
  </body>
</html>