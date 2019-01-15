<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test Upload File</title>
</head>
<body>
	<form action="" enctype="multipart/form-data" method="post">
		<!--input type="hidden" name="MAX_FILE_SIZE" value="102400" /-->
		<div>
			<label for="myfile">文件：</label>
			<input type="file" id="myfile" name="myfile"/>
		</div>
		<div>
			<input type="submit" value="上传" />
		</div>
	</form>
</body>
</html>