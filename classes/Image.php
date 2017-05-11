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
				// if (filesize($filename) < $max_image_size && in_array($this -> ext, $valid_types)) return true;
				$resultMes = '';
				if (filesize($filename) < $max_image_size)
				{
					if (in_array($this -> ext, $valid_types)) {
						return true;
					}
					else $resultMes .= '2'; 
				}
				else $resultMes .= '4';
				switch ($resultMes) {
					case '2': return "Формат файла недопустим к загрузке. Допускается jpg, jpeg, png";break;
					case '4': return"Слишком большой размер изображения. Допускается файл до 1 Мб"; break;
					case '42': return "Загрузка не удалась: неверный формат файла и большой размер изображения. Допускается файл до 1 Мб разрешений jpg, jpeg, png"; break;
					case '24': return "Загрузка не удалась: неверный формат файла и большой размер изображения. Допускается файл до 1 Мб разрешений jpg, jpeg, png"; break;
				}
			}
			else {return "Выберите изображение до 1 Мб разрешений jpg, jpeg, png";}
		}
		// return $this->fail = true;
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