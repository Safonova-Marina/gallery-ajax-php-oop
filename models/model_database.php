<?php
include('./core/connectDB.php');

class Model_Database {
	private static $db = null;
	private $mysqli;
	public $allImages;

	//создаем единственный экземпляр класса
	public static function getDB() {
		if (self::$db == null) self::$db = new Model_DataBase();
		return self::$db;
	}

	public function __construct ()
	{
		$this->mysqli = new mysqli(HOST, USER, PASS);
		if ($this->mysqli->connect_error)
			die("Connection failed: " . self::$db->connect_error);
		if (!$result = $this->mysqli->select_db(DB))
		{
			die("Database dont exist");
			$result->close();
		}
	}

	public function getAllImagesDB($sort, $order, $pageNum, $limit, $size)
	{
		$query = 'SELECT * FROM images ORDER BY '.$sort.' '.$order.' LIMIT '.$limit.','.$size;
		$result = $this->mysqli->query($query);
		while ($row = $result->fetch_assoc()) {
			$this->allImages[] = $row;
		}
		return $this->allImages;
	}

	public function addNewImageDB($obj)
	{
		$query = 'INSERT INTO images (comment, weight, path, dateCreate) VALUES ("'.$obj->comment.'", "'.$obj->weight.'", "'.$obj->path.'", Now())';
		$result = $this->mysqli->query($query);
		if ($result)
			return $this->mysqli->insert_id;
		else 
			return false;		
	}

	public function editImageDB($id, $newComment)
	{
		$query = 'UPDATE images SET comment = "'.$newComment.'" WHERE id = "'.$id.'"';
		$result = $this->mysqli->query($query);
		return $result;		
	}

	public function deleteImageDB($id)
	{
		$query = 'DELETE FROM images WHERE id = "'.$id.'"';
		$result = $this->mysqli->query($query);
		return $result;		
	}

	public function getCountImagesDB()
	{
		$query = 'SELECT id FROM images';
		$result = $this->mysqli->query($query)->num_rows;
		return $result;		
	}

	public function __destruct() {
		$this->mysqli->close();
	}

}
