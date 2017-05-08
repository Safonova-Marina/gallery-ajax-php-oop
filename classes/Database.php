<?php
include('./connectDB.php');
class Database {
	public $db;

	public function __construct ($host, $user, $pass, $db)
	{
		$this->db = new mysqli($host, $user, $pass);
		if ($this->db->connect_error)
			die("Connection failed: " . $this->db->connect_error);
		$this->db->select_db($db);
		if ($result = $this->db->query("SELECT DATABASE()")) {
			$row = $result->fetch_row();
			if (!$row) die("Database dont exist");
			$result->close();
		}
		return $this->db;
	}

	public function getAllImagesDB()
	{
		$query = 'SELECT * FROM images';
		$result = $this->db->query($query);
		while ($row = $result->fetch_assoc()) {
			$allImages[] = $row;
		}
		return $allImages;
	}

	public function addNewImageDB($obj)
	{
		$query = 'INSERT INTO images (comment, weight, path, dateCreate) VALUES ("'.$obj->comment.'", "'.$obj->weight.'", "'.$obj->path.'", Now())';
		$result = $this->db->query($query);
		if ($result)
			return $this->db->insert_id;
		else 
			return $result;		
	}

	public function editImageDB($id, $newComment)
	{
		$query = 'UPDATE images SET comment = "'.$newComment.'" WHERE id = "'.$id.'"';
		$result = $this->db->query($query);
		return $result;		
	}

	public function deleteImageDB($id)
	{
		$query = 'DELETE FROM images WHERE id = "'.$id.'"';
		$result = $this->db->query($query);
		return $result;		
	}


	function __destruct() {
		$this->db->close();
	}


}
?>