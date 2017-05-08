<?php
include('./classes/Database.php');

class Collection {
	public static $objects;
	public static $count = 0;

	public function __construct()
	{
	}//public function __construct

	public static function getAllImages()
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->getAllImagesDB();
		return $result;
	}//public function addNewImage

	public static function addNewImage($obj)
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->addNewImageDB($obj);
		return $result;
	}//public function addNewImage

	public static function editImage($id, $newComment)
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->editImageDB($id, $newComment);
		if($result)
			return $newComment;
	}//public function editImage

	public static function deleteImage($id)
	{
		$db = new Database(HOST, USER, PASS, DB);
		$result = $db->deleteImageDB($id);
		if($result) 
			return self::getAllImages();
		else return $result;
	}//public function editImage
}
?>