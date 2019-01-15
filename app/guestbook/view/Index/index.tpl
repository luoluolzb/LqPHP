<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>留言本 - LqPHP</title>
    <link rel="stylesheet" type="text/css" href="/static/css/lqphp-pager.css" />
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
		{foreach $guestList as $guest}
			<li class="guest">
				<div class="info">
					<span class="user">{$guest.user}</span> 在 <span class="time">{$guest.time|date_format:"%Y-%m-%d %X"}</span> 说：
				</div>
				<span class="content">{nl2br($guest.content)}</span>
			</li>
		{/foreach}
		</ul>
		{$pager}
	</main>
</body>
</html>