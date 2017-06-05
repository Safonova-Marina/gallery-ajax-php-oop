<?php
include('./models/model_database.php');
include('./models/model_pagination.php');

class Model_Collection {
	public static $collection;
	public static $images;
	public static $pager;
	public static $pageNum;
	public static $db;

	//создаем единственный экземпляр класса
	public static function getCollection() {
		if (self::$collection == null) self::$collection = new Model_Collection();
		return self::$collection;
	}

	//получаем все изображения
	public function getAllImages($sort, $order, $pageNum, $size)
	{
		self::$db = Model_Database::getDB();
		self::$collection = Model_Collection::getCollection();//получаем экземпляр коллекции
		$countImages = self::$db->getCountImagesDB();//количество изображений
		if ($size == "All")
		{
			$size = $countImages;//в случае если размер страницы больше кол-ва изображений в коллекции
		}
		$pager = self::$collection->getViewPager($size, $pageNum);//данные для пагинации
		$allImages = self::$db->getAllImagesDB($sort, $order, $pageNum, $pager->limit, $size);
		self::$collection->images = $allImages;//все изображения в нужной сортировке
		self::$collection->pager = $pager->str;//хтмл верстка секции пагинации с нужным чанком
		self::$collection->pageNum = $pager->pageNum;//запрашиваемая страница
		return self::$collection;
	}

	public function getViewPager($size, $pageNum)
	{
		return Model_Pagination::getViewPager($size, $pageNum);//получаем все данные для паганации
	}

	public function getCountImages()//подсчет кол-ва изображений
	{
		self::$db = Model_Database::getDB();
		$result = self::$db->getCountImagesDB();
		return $result;
	}

	public function addNewImage($obj)
	{
		self::$db = Model_Database::getDB();
		$result = self::$db->addNewImageDB($obj);
		return $result;
	}

	public function editImage($id, $newComment)
	{
		self::$db = Model_Database::getDB();
		$result = self::$db->editImageDB($id, $newComment);
		if($result)
			return $newComment;
	}

	public function deleteImage($id)
	{
		self::$db = Model_Database::getDB();
		$result = self::$db->deleteImageDB($id);
		return $result;
	}
}
