<?php
header('Content-Type: text/html; charset=utf-8');
include('./connectDB-local.php');
include('./classes/Collection.php');

include('./classes/Image.php');

//код работает при загрузке страницы - отдает все уже существующие картинки в галлерее
if (isset($_POST['getAll'])) {
	$gal = Collection::getAllImages();
	echo json_encode($gal);
}
//код работает при загрузке страницы - отдает все уже существующие картинки в галлерее

//код работает при загрузке файла
if (isset($_FILES['inputFile'])) {
	$imgNew = new Image();
	$a = $imgNew -> checkFile();
	$res = array();
	if (strlen($a) <= 1) {
		$imgNew -> saveFile();
		$result = Collection::addNewImage($imgNew);
		if ($result == true)
		{
			$imgNew->id = $result;
			$res["suc"] = $imgNew;
			$res["fail"] = false;
		}	
		else
		{
			return $result;
		}	
	}
	else {
		unset($imgNew);
		$res['fail'] = $a;
	}
	echo json_encode($res);;
	
}
//код работает при загрузке файла

//код работает при изменении комментария
if (isset($_POST['newComment'])) {
	$result = Collection::editImage($_POST['id'], trim(strip_tags($_POST['newComment'])));
	echo $result;
}
//код работает при изменении комментария

//код работает при удалении изображения
if (isset($_POST['idDel'])) {
	echo json_encode(Collection::deleteImage($_POST['idDel']));
}
//код работает при удалении изображения

?>