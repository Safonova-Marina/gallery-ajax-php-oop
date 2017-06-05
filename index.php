<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>Gallery</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" class="href">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<style>
	.row{
		margin: 20px 0;
	}
	#pop{
		margin-bottom: 15px;
	}
	.imgBlock {
		min-height: 175px;
	}
	#pager-area > div {
		display: block;
	}
	#pager-area {
		margin-top: 100px;
	}
</style>
<body>
	<div id='overlay'></div>
	
	<div class="container">
		<div class="page-header bg-success text-center">
			<h1>Галлерея</h1>
		</div>

		<div class="form-group text-danger col-sm-12" id="err_mes">
			<p></p>
		</div>

		<form class="form-horizontal">

		<div id="pop">
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#uploadPop">Загрузить изображение</button>
		</div>

			<div class="form-group" id="type_sort">
				<label for="type_sort_sel" class="col-sm-2 control-label">Сортировать:</label>
				<div class="col-sm-4">
					<select class="form-control" id="type_sort_sel">
						<option value="id">Выберите метод сортировки</option>
						<option value="dateCreate">По дате загрузки</option>
						<option value="weight">По размеру файла</option>
					</select>
				</div>
				<label for="type_sort_order" class="col-sm-1 control-label">Порядок сортировки:</label>
				<div class="col-sm-3">
					<select class="form-control" id="type_sort_order">
						<option value="Asc">По возрастанию</option>
						<option value="Desc">По убыванию</option>
					</select>
				</div>
			</div>
		</form>
		
		<div class="content" id="content">
		</div>

		<div id="pager-area">
			<div class="col-sm-4 col-sm-push-8">
				<select class="form-control" id="pager-size">
					<option value="5">5 изображений на странице</option>
					<option value="10">10 изображений на странице</option>
					<option value="20">20 изображений на странице</option>
					<option value="All">Показать все</option>
				</select>
			</div>

			<div id="pager-list">
				<input type="hidden" id="pager-list-hidden-id" name="pageNumId" value="1">
				<ul class="pagination center-block">
				</ul>
			</div>

		</div>

		<footer>
			<!-- modal upload image -->
			<div id="uploadPop" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Выберите изображение</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" name="form" id="form">
								<div class="form-group">
									<label for="inputFile" class="col-sm-4 control-label">Выберите файл (jpg, jpeg, png до 1 Мб):</label>
									<div class="col-sm-6">
										<input type="file" id="inputFile" name="inputFile">
									</div>			
								</div>

								<div class="form-group">
									<label for="inputComment" class="col-sm-4 control-label">Введите комментарий:</label>
									<div class="col-sm-6">
										<textarea class="form-control" id="inputComment" name="inputComment" maxlength="200" placeholder="Введите комментарий (максимум 200 символов)" cols="31" rows="7"></textarea>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-4">
										<button type="button" class="btn btn-primary" name="inputSub" onclick="uploadImage()" data-dismiss="modal">Добавить изображение</button>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>

			<!-- modal to confirm delete -->
			<div id="confirmDel" class="modal fade" role="dialog">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Подтвердите удаление</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" name="form" id="form">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-4">
										<button type="button" class="btn btn-primary" name="delSub" onclick="delImage()" data-dismiss="modal">Удалить</button>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-4">
										<button type="button" class="btn btn-primary" name="delSub" data-dismiss="modal">Отменить</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<!-- modal to edit comment -->
			<div id="editCom" class="modal fade" role="dialog">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Напишите новый комментарий</h4>
						</div>
						<div class="modal-body">
							<form class="form-horizontal" name="form" id="editComForm">

								<textarea class="form-control" maxlength="200" placeholder="Введите комментарий (максимум 200 символов)" cols="31" rows="7"></textarea>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-4">
										<button type="button" class="btn btn-primary" name="editSub" onclick="editImage()" data-dismiss="modal">Изменить</button>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-4">
										<button type="button" class="btn btn-primary" name="editCan" data-dismiss="modal" onclick="editComFormReset()">Отменить</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<?if(!empty($_GET)):?>
			<?php
				$sortArr = array('id', 'dateCreate', 'weight');
				$orderArr = array('Asc', 'Desc');
				$sizeArr = array('5', '10', '20', 'All');
				$sort = (isset($_GET['sort']) && in_array($_GET['sort'], $sortArr))? trim(strip_tags($_GET['sort'])) : 'id';
				$order = (isset($_GET['order']) && in_array($_GET['order'], $orderArr))? trim(strip_tags($_GET['order'])) : 'Asc';
				$size = (isset($_GET['size']) && in_array($_GET['size'], $sizeArr))? trim(strip_tags($_GET['size'])) : '5';
				$pageNum = isset($_GET['pageNum'])? trim(strip_tags($_GET['pageNum'])) : '1';
			?>
			<script>
				$('#type_sort_sel').val("<?=$sort;?>");
				$('#type_sort_order').val("<?=$order;?>");
				$('#pager-size').val("<?=$size;?>");
				$('#pager-list-hidden-id').val("<?=$pageNum;?>");
			</script>
		<?endif?>

		<script type="text/javascript">
			var idSel, idEdit;//ид позиций на удаление и редактирование

			$('#type_sort').change(function(){
				setLocation();
				getAllImagesParam();
			});

			$('#pager-size').change(function(){
				setLocation();
				getAllImagesParam();
			});

			$('#pager-list').click(function(event){
				var idPrev, idNext;
				if (event.target.id == 'prev' || event.target.id == 'next')
				{
					idPrev = Number($('#pager-list-hidden-id').val());
					idNext = (event.target.id == 'prev'? (idPrev-1) : (event.target.id == 'next'? (idPrev+1) : ''));
				}
				else
					idNext = event.target.id;
				urlPageNum = "&pageNum=" + idNext;
				$('#pager-list-hidden-id').val(idNext);
				setLocation();
				getAllImagesParam();
			});

			$(document).ready(function() {
				var sort = $('#type_sort_sel').val();
				var order = $('#type_sort_order').val();
				var size = $('#pager-size').val();
				var pageNum = $('#pager-list-hidden-id').val();
				getAllImagesParam();
			});//$(document).ready

			function setLocation()
			{
				var sort = $('#type_sort_sel').val();
				var order = $('#type_sort_order').val();
				var size = $('#pager-size').val();
				var pageNum = $('#pager-list-hidden-id').val();

				url = 'index.php?';
				urlSort = "sort=" + sort + "&order=" + order;
				urlPageSize = "&size=" + size;
				urlPageNum = "&pageNum=" + pageNum;
				locat = url + urlSort + urlPageNum + urlPageSize;

				history.pushState("", "", locat);
			}

			//сортировка через запросы на сервер
			function getAllImagesParam()
			{
				var sort = $('#type_sort_sel').val();
				var order = $('#type_sort_order').val();
				var size = $('#pager-size').val();
				var pageNum = $('#pager-list-hidden-id').val();
				$.ajax(
				{
					url: "collection/getAllImages",
					type: 'post',
					data: {sort:sort, order:order, pageNum:pageNum, size:size, getAll:true},
					beforeSend: darkLoader,
					success: function(res)
					{
						//console.log(res);
						var photoStart = JSON.parse(res);
						$('#content').html('');
						$.each(photoStart.images, function(){
							createHtmlNewImage(this);
						});
						$('#pager-list ul').html('').append(photoStart.pager);
						urlPageNum = '&pageNum=' + photoStart.pageNum;
						$('#pager-list-hidden-id').val(photoStart.pageNum);
						setLocation();
						$('#overlay').hide();
					}//success
				});//ajax
			}

			var count = 0;
			function uploadImage(){
				var sort = $('#type_sort_sel').val();
				var order = $('#type_sort_order').val();
				var formData = new FormData($('#form')[0]);
				$.ajax(
				{
					url: "collection/addNewImage",
					type: 'post',
					processData: false,
					contentType: false,
					data: formData,
					beforeSend: darkLoader,
					success: function(res)
					{
						//console.log(res);
						var res = JSON.parse(decodeURIComponent(res));
						if(res['suc'] == null) 
						{
							$("#err_mes p").html(res['fail']);
						}
						else
						{
							$("#err_mes p").html("Файл успешно загружен");
							$("#form")[0].reset();
							getAllImagesParam();
						}	
						//else 	
						$('#overlay').hide();
						setTimeout(function() { $("#err_mes p").html(''); }, 4000);			
					}//success
				});//ajax
			}

			function getEditImageID(id)
			{
				idEdit = id;
				$('#editCom').find('textarea').html($('#' + id).parent().find('span').html());
			}

			function editComFormReset()
			{
				$('#editComForm')[0].reset();
			}

			function editImage()
			{
				var id = idEdit;
				var elem = $('#' + id).parent();
				var newValCom = $('#editCom').find('textarea').val();
				$.ajax({
					url: "collection/editImage",
					type: 'post',
					data: {id: id, newComment: newValCom},
					beforeSend: darkLoader,
					success: function(res)
					{
						$('#overlay').hide();
						if (res)
						{
							elem.find('span').html(res);
							$('#editComForm')[0].reset();
						}
					}//success
				});//ajax
				$('#editCom').find('textarea').html('');
			}

			function getIDSelectImage(id)
			{
				idSel = id;
			}

			function delImage()
			{
				var sort = $('#type_sort_sel').val();
				var order = $('#type_sort_order').val();
				var id = idSel;
				$.ajax(
				{
					url: "collection/deleteImage",
					type: 'post',
					data: {idDel: id},
					beforeSend: darkLoader,
					success: function(res)
					{
						$('#overlay').hide();
						if (res)
						{
							getAllImagesParam();
						}	
					}//success
				});//ajax
			}//function delImage

			function darkLoader() 
			{
				var docHeight = $(document).height();
				$("#overlay")
				.height(docHeight)
				.css({
					'opacity' : 0.4,
					'position': 'absolute',
					'top': 0,
					'left': 0,
					'background-color': 'black',
					'width': '100%',
					'z-index': 5000
				});
			}

			function createHtmlNewImage(res_pars){
				var len = $('#content').children().last().children().length;
				if (len%4 == 0) {
					$('#content').append('<div class="row clearfix"></div>');
				}

				$('#content').children().last().append('<div class="col-md-3 col-sm-12 col-xs-12">' +
					'<div class="card" id="' + res_pars['id'] + '">' +
					'<div class="imgBlock"><img src="' + res_pars['path'] + '" class="img-rounded img-responsive"></div>' +
					'<button type="button" id="del" class="btn btn-danger btn-xs center-block" data-toggle="modal" data-target="#confirmDel" onclick="getIDSelectImage(' + "'" + res_pars['id'] + "'" + ')">Удалить изображение</button>' +
					'<p id="dateCreate">' + res_pars['dateCreate'] + '</p>' +
					'<button type="button" id="edit" class="btn btn-success" data-toggle="modal" data-target="#editCom" onclick="getEditImageID(' + "'" + res_pars['id'] + "'" + ')">&#9997;</button>' +
					'<span>' + res_pars['comment'] + '</span>' +
					'<div style="display: none;" id="newCom" >' +
					'<p class="hidden" id="weight">' + res_pars['weight'] + '</p>' + '</div></div>');
			}//function createHtmlNewImage

		</script>
	</body>
	</html>