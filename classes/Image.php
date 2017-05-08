<?php
class Image {
	public $id;
	public $comment;
	public $weight;
	public $path;
	public $dateCreate;
	public $ext;

	public function __construct() {
		$dateCr = new DateTime();
		$this -> comment = (isset($_POST['inputComment']))? (trim(strip_tags($_POST['inputComment']))): '';
		$this -> dateCreate = date_format($dateCr, 'Y-m-d H:i:s');
	}

	public function changeComment($newComment) {
		$this -> comment = $newComment;
	}

	public function checkFile() {
		if (isset($_FILES["inputFile"])) {
			if (is_uploaded_file($_FILES['inputFile']['tmp_name'])) {
				$filename = $_FILES['inputFile']['tmp_name'];
				$max_image_size = 1000 * 1024;
				$valid_types = array("jpg", "png", "jpeg");
				$this -> ext = substr($_FILES['inputFile']['name'], 1 + strrpos($_FILES['inputFile']['name'], "."));
				if (filesize($filename) < $max_image_size && in_array($this -> ext, $valid_types)) return true;
				else return false;
			}
			// else {return "Error: empty file.";}
		}
		// else {return 'нет файла';}
		return $res;
	}

	public function saveFile() {
		$filename = $_FILES['inputFile']['tmp_name'];
		if ($_FILES['inputFile']['name'] != null) {
			if (!file_exists("./images")) {
				mkdir("./images");
			}
			$upl = "./images/".date_format(new DateTime(), 'd-m-Y-H-i-s').".".$this -> ext;
			move_uploaded_file($filename, $upl);
		}
		$this -> weight = filesize($filename);
		$this -> path = $upl;
	}

}
?>