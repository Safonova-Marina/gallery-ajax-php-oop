<?php
// header('Content-Type: text/html; charset=utf-8');
include('./core/connectDB.php');
// include('./models/model_collection.php');
include('./models/model_image.php');

class Controller_Collection {

	public function action_getAllImages ()
	{
		if (isset($_POST['getAll'])) {
			$gal = Model_Collection::getAllImages($_POST['sort'], $_POST['order'], $_POST['pageNum'], $_POST['size']);
			
			echo json_encode($gal);
		}
	}

	public function action_addNewImage ()
	{
		if (isset($_FILES['inputFile'])) {
			//create new Image
			$imgNew = new Model_Image($_POST['inputComment']);
			//check if this image has correct weight and type
			$a = $imgNew -> checkFile($_FILES['inputFile']);
			$res = array();
			//if image is good for us $a==true
			//if image have big weight or not valid type $ will get text message about mistakes
			if (strlen($a) <= 1) {
				//if file is valid - save file and add image to the collection
				$imgNew -> saveFile($_FILES['inputFile']);
				$result = Model_Collection::addNewImage($imgNew);
				if ($result == true)
				{
					$imgNew->id = $result;
					$res["suc"] = true; //uploading is success
					$res["fail"] = false;
				}	
				else
				{
					return $result;
				}	
			}
			//if image is not valid - destroy image object and send in a response a mistake text
			else {
				unset($imgNew);
				$res['fail'] = $a; //uploading is failed - $res['fail'] keep a mistake text
			}
			echo json_encode($res);;
		}
	}

	public function action_editImage ()
	{
		if (isset($_POST['newComment'])) {
			$result = Model_Collection::editImage($_POST['id'], trim(strip_tags($_POST['newComment'])));
			echo $result;
		}
	}

	public function action_deleteImage ()
	{
		if (isset($_POST['idDel'])) {
			echo json_encode(Model_Collection::deleteImage($_POST['idDel']));
		}
	}
}



