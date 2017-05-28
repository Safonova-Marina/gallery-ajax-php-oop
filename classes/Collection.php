<?php
include('./classes/Database.php');
include('./classes/Pagination.php');

class Collection {
	public static $objects;
	public static $count = 0;

	public function __construct()
	{
	}//public function __construct

	public static function getAllImages($sort, $order, $pageNum, $size)
	{
		$db = new Database(HOST, USER, PASS, DB);
		$countImages = $db->getCountImagesDB();
		if ($size == "All")
		{
			$size = $countImages;
		}
		$pager = self::getViewPager($size, $pageNum);
		$allImages = $db->getAllImagesDB($sort, $order, $pageNum, $pager->limit, $size);
		$result->images = $allImages;
		$result->pager = $pager->str;
		$result->pageNum = $pager->pageNum;
		return $result;
	}

	public static function getViewPager($size, $pageNum)
	{
		return Pagination::getViewPager($size, $pageNum);
	}

	public static function getCountImages()
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->getCountImagesDB();
		return $result;
	}

	public static function addNewImage($obj)
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->addNewImageDB($obj);
		return $result;
	}

	public static function editImage($id, $newComment)
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->editImageDB($id, $newComment);
		if($result)
			return $newComment;
	}

	public static function deleteImage($id)
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->deleteImageDB($id);
		// if($result) 
		// 	return self::getAllImages();
		// else return $result;
		return $result;
	}

	public static function sortImages($sort, $order)
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->sortImagesDB($sort, $order);
		if($result) 
			return $result;
			// return self::getAllImages();
		else return false;
	}
}
?>