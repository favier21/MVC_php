<?php

/* Inclusion des classes nécessaires */
require_once("view/View.php");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
require_once("model/AnimalStorageStub.php");
require_once("model/AnimalBuilder.php");
class Controller {

	protected $view;
	protected $animalStorage;

	public function __construct(View $view,AnimalStorage $animalStorage) {
		$this->view = $view;
		$this->animalStorage = $animalStorage;
	}
	public function showInformation($id) {
		if(array_key_exists($id,$this->animalStorage->readAll()))
		{
			$this->view->prepareAnimalPage($this->animalStorage->read($id)); 
		}
		else
			$this->view->prepareUnknownAnimalPage();
	}
	public function showList(){
		$this->view->prepareListPage($this->animalStorage->readAll());
	}
	public function showCreate(){
		$builder = new AnimalBuilder();
		$this->view->prepareAnimalCreationPage($builder);
	}
	public function showUpdate($id){
		if(array_key_exists($id,$this->animalStorage->readAll()))
		{
			$builder = new AnimalBuilder($this->animalStorage->read($id));
			$this->view->prepareAnimalUpdatePage($builder,$id);
		}
		else
			$this->view->prepareUnknownAnimalPage();
		

	}
	public function saveNewAnimal(array $data){
		$builder = new AnimalBuilder($data);
		if ($builder->isValid()) {
			$anml = $builder->createAnimal();
			$id = $this->animalStorage->create($anml);
			if($id)
				$this->view->displayAnimalCreationSuccess($id);
			else
				$this->view->prepareErrorPage();
		}
		else{
			$this->view->prepareAnimalCreationPage($builder);
		}

	}

	public function updateAnimal(array $data,$id){
		$builder = new AnimalBuilder($data);
		if ($builder->isValid()) {
			$anml = $this->animalStorage->read($id);
			$builder->updateAnimal($anml);
			$this->animalStorage->update($id,$anml);
			if($id)
				$this->view->displayAnimalUpdateSuccess($id);
			else
				$this->view->prepareErrorPage();
		}
		else{
			$this->view->prepareAnimalUpdatePage($builder,$id);
		}

	}

	public function deleteAnimal($id){
		if(array_key_exists($id,$this->animalStorage->readAll()))
		{
			if($this->animalStorage->delete($id))
				$this->view->displayAnimalDeleteSuccess();
			else
				$this->view->displayAnimalNotFound();
		}
		else
			$this->view->prepareUnknownAnimalPage();
		
	}


}
