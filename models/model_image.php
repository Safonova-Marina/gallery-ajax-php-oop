<?php
class Model_Image {
	public $id;
	public $comment;
	public $weight;
	public $path;
	public $dateCreate;
	public $ext;
	public $max_image_size = 1024000;
	public $valid_types = array("jpg", "png", "jpeg");
	public $mistakes;

	public function __construct($comment)
	{
		//в момент создания объекта изображения создаем у него коммент и дату
		$dateCr = new DateTime();
		$this -> comment = (isset($comment))? (trim(strip_tags($comment))): '';
		$this -> dateCreate = date_format($dateCr, 'Y-m-d H:i:s');
	}

	public function changeComment($newComment) {
		$this -> comment = $newComment;
	}

	public function checkFile($file) {
		if (isset($file)) {
			if (is_uploaded_file($file['tmp_name'])) {
				$filename = $file['tmp_name'];
				$this -> ext = pathinfo($file['name'], PATHINFO_EXTENSION);//получаем разрешение файла
				$resultMes = '';
				if (filesize($filename) < $this->max_image_size)//проверяем вес изображения
				{
					if (in_array($this -> ext, $this->valid_types))//проверяем тип из-я
					{
						return true;
					}
					else $this->mistakes->type = true; //сохраняем признак превышения веса файла
				}
				else $this->mistakes->weight = true;//сохраняем признак неправильного формата файла
				//формируем сообщение обо ошибке в зависимости от признака ошибки
				$resultMes = '';
				if ($this->mistakes->type) $resultMes .= "Формат файла недопустим к загрузке. Допускается jpg, jpeg, png";
				if ($this->mistakes->weight) $resultMes .= "Слишком большой размер изображения. Допускается файл до 1 Мб";

			}
			else {$resultMes .= "Выберите изображение до 1 Мб разрешений jpg, jpeg, png";}
			return $resultMes;
		}
	}

	public function saveFile($file)//сохраняем файл
	{
		$filename = $file['tmp_name'];
		if ($file['name'] != null) {
			if (!file_exists("./images")) {
				mkdir("./images");
			}
			//имя файла формируем как дата и время загрузки
			$upl = "./images/".date_format(new DateTime(), 'd-m-Y-H-i-s').".".$this -> ext;
			move_uploaded_file($filename, $upl);
		}
		$this -> weight = filesize($filename);
		$this -> path = $upl;
	}

}
