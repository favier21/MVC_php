<?php
require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/AnimalStorage.php");
require_once("model/AnimalStorageStub.php");
class Routeur {


	public function __construct() {
		
	}

	public function main(AnimalStorage $animalStorage) {
		$view = new View($this,key_exists('feedback', $_SESSION)? $_SESSION['feedback']: "");
		$_SESSION['feedback'] = "";
		$controller = new Controller($view,$animalStorage);

		$id = key_exists('id', $_GET)? $_GET['id']: null;
		$action = key_exists('action', $_GET)? $_GET['action']: null;


		switch ($action) {
			case "voir":
				$controller->showInformation($id);
				break;
			case "liste":
				$controller->showList();
				break;
			case "nouveau":
				$controller->showCreate();
				break;
			case "sauverNouveau":
				$controller->saveNewAnimal($_POST);
				break;
			case "modifier":
				$controller->showUpdate($id);
				break;
			case "sauverModification":
				$controller->updateAnimal($_POST,$id);
				break;
			case "supprimer":
				$controller->deleteAnimal($id);
				break;
						
			default:
				$view->prepareHomePage();
				break;
		}
		$view->render();
	}
	public function getAnimalURL($id) : String {
		return 'site.php?action=voir&id='.$id;
	}
	public function getHomeURL() : String {
		return 'site.php';
	}
	public function getListURL() : String {
		return 'site.php?action=liste';
	}
	public function getAnimalCreationURL() : String{
		return 'site.php?action=nouveau';
	}
	public function getAnimalSaveURL() : String{
		return 'site.php?action=sauverNouveau';
	}
	public function getAnimalUpdateURL($id) : String{
		return 'site.php?action=modifier&id='.$id;
	}
	public function getAnimalUpdateSaveURL($id) : String{
		return 'site.php?action=sauverModification&id='.$id;
	}
	public function getAnimalDeleteURL($id) : String{
		return 'site.php?action=supprimer&id='.$id;
	}
	public function POSTredirect($url, $feedback){
		$_SESSION['feedback'] = $feedback;
		header("HTTP/1.1 303 See Other");
        header("Location: " . $url);
        exit();
	}
}
