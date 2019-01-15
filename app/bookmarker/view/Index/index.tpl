<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>云书签 - LqPHP</title>
	<link href="/static/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style type="text/css">
header{
	margin-top: 25px;
	margin-bottom: 25px;
	border-bottom: 1px solid #ddd;
}

header .title{
	font-size: 2em;
	font-weight: bold;
}

header .tool>button{
	margin-right: 10px;
}

.icon{
	width: 20px;
}

.click{
	cursor: pointer;
}
	</style>
</head>
<body>
	<div class="container">
		<header class="row">
			<div class="col-xs-4 title">
				<span class="glyphicon glyphicon-bookmark" aria-hidden="true" style="color: rgb(92, 184, 92);"></span> 云书签
			</div>
			<div class="col-xs-8 text-right tool">
				<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModal" id="addButton"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 添加</button>
				<button class="btn btn-info btn-sm" id="refreshButton"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 刷新</button>
			</div>
		</header>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<table class="table" id="bookmarkers">
					<thead>
						<tr>
							<th>书签名称</th>
							<th>编辑</th>
							<th>删除</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Modals -->
		<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="addModal">添加新书签</h4>
		      </div>
		      <div class="modal-body">
				<form id="addForm">
  					<div class="form-group">
						<input type="text" class="form-control" placeholder="链接地址" name="url">
					</div>
  					<div class="form-group">
						<input type="text" class="form-control" placeholder="书签名称" name="name">
					</div>
				</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		        <button type="button" class="btn btn-primary" data-dismiss="modal" id="addMarker">保存</button>
		      </div>
		    </div>
		  </div>
		</div>
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="editModal">编辑书签</h4>
		      </div>
		      <div class="modal-body">
				<form id="editForm">
  					<div class="form-group">
						<input type="text" class="form-control" placeholder="链接地址" name="url">
					</div>
  					<div class="form-group">
						<input type="text" class="form-control" placeholder="书签名称" name="name">
					</div>
				</form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		        <button type="button" class="btn btn-primary" data-dismiss="modal" id="editMarker">保存</button>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<script src="/static/jquery/jquery-1.12.4.min.js"></script>
	<script src="/static/bootstrap-3.3.7/js/bootstrap.min.js"></script>
	<script type="text/javascript">
function IsURL(str_url)
{
	var strRegex ='https?://.+';
	return (new RegExp(strRegex)).test(str_url);
}

$(function(){
	var $bookmarkers = $('#bookmarkers>tbody');
	var $editTr;

	//根据url获取网页图标
	function getIconSrc(url) {
		var arr = url.split('/');
		return arr[0] + '//' + arr[2] + '/favicon.ico';
	}

	//清空书签列表
	function clear() {
		$bookmarkers.empty();
	}

	//添加一个书签到列表
	function addOne(marker) {
		var iconSrc = getIconSrc(marker.url);
		var $tr = $('\
			<tr data-id="'+ marker.id +'">\
				<td>\
					<img class="icon" src="'+ iconSrc +'" />\
					<a href="'+ marker.url +'" target="_blank">'+ marker.name +'</a>\
				</td>\
				<td class="click click-edit" data-toggle="modal" data-target="#editModal">\
					<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>\
				</td>\
				<td class="click click-delete">\
					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>\
				</td>\
			</tr>\
		');
		$bookmarkers.append($tr);
	}

	//添加多个书签到列表
	function addList(list) {
		for (var len = list.length, i = 0; i < len; ++ i) {
			addOne(list[i]);
		}
	}

	//从列表中删除一个书签
	function deleteOne($tr) {
		$tr.remove();
	}

	//更新列表中的一个书签
	function updateOne($tr, marker) {
		$tr.data('id', marker.id);
		$tr.find('img').attr('src', getIconSrc(marker.url));
		$tr.find('a').attr('href', marker.url);
		$tr.find('a').text(marker.name);
	}

	//刷新书签列表
	function refresh() {
		$.ajax({
			'url': '/bookmarker/index/gets',
			'method': 'get',
			'dataType ': 'json',
			'success': function(data, textStatus, jqXHR) {
				if (textStatus != 'success') {
					return ;
				}
				if (data.status != 'success') {
					return ;
				}
				clear();
				addList(data.list);
			}
		});
	}

	$('#addButton').click(function() {
		$('#addForm')[0].reset();
	});

	$('#refreshButton').click(function() {
		refresh();
	});

	$('#addMarker').click(function() {
		var formData = $('#addForm').serializeArray();
		var marker = {
			'url': formData[0].value,
			'name': formData[1].value,
		};
		$.ajax({
			'url': '/bookmarker/index/add',
			'method': 'get',
			'data': marker,
			'success': function(data, textStatus, jqXHR) {
				if (textStatus != 'success') {
					return ;
				}
				if (data.status != 'success') {
					return ;
				}
				addOne(data.marker);
			}
		});
	});

	$('#editMarker').click(function() {
		var formData = $('#editForm').serializeArray();
		var marker = {
			'id': $editTr.data('id'),
			'url': formData[0].value,
			'name': formData[1].value,
		};
		$.ajax({
			'url': '/bookmarker/index/update',
			'method': 'get',
			'data': marker,
			'success': function(data, textStatus, jqXHR) {
				if (textStatus != 'success') {
					return ;
				}
				if (data != 'success') {
					return ;
				}
				updateOne($editTr, marker);
			}
		});
	});

	$(document).on('click', '.click-delete', function() {
		var $tr = $(this).parents('tr');
		$.ajax({
			'url': '/bookmarker/index/delete',
			'method': 'get',
			'data': {
				'id': $tr.data('id'),
			},
			'success': function(data, textStatus, jqXHR) {
				if (textStatus != 'success') {
					return ;
				}
				if (data != 'success') {
					return ;
				}
				deleteOne($tr);
			}
		});
	});

	$(document).on('click', '.click-edit', function() {
		var $tr = $(this).parents('tr');
		var url = $tr.find('a').attr('href');
		var name = $tr.find('a').text();
		$('#editForm input[name="url"]').val(url);
		$('#editForm input[name="name"]').val(name);
		$editTr = $tr;
	});

	$(document).on('input propertychange change', '#addForm input[name="url"]', function() {
		var url = $(this).val();
		if (IsURL(url)) {
			$.ajax({
				'url': '/bookmarker/index/title',
				'method': 'get',
				'data': {
					'url': url,
				},
				'success': function(data, textStatus, jqXHR) {
					if (textStatus != 'success') {
						return ;
					}
					if (data.status != 'success') {
						return ;
					}
					$('#addForm input[name="name"]').val(data.title);
				}
			});
		}
	});

	refresh();
});
	</script>
</body>
</html>