<?php

require_once("Routeur.php");
require_once("model/Animal.php");
require_once("model/AnimalBuilder.php");
class View {

	protected $title;
	protected $content;
	protected $routeur;
	protected $menu;
	protected $feedback;

	public function __construct(Routeur $routeur, $feedback = "") {
		$this->title = null;
		$this->content = null;
		$this->routeur = $routeur;
		$this->menu = array(
            $this->routeur->getHomeUrl() => "Home",
            $this->routeur->getListURL() => "Liste",
			$this->routeur->getAnimalCreationURL() => "Creer",
            );
		$this->feedback = $feedback;
	}

	/* Affiche la page créée. */
	public function render() {
		$title = $this->title;
		

		$nav = '<ul id ="menu">';
		foreach ($this->menu as $key => $value) {
			$nav .='<li><a href="'.$key.'">'.$value.'</a></li>';
		}
		$nav .= '</ul>';
		
		$feedback = $this->feedback;
		$content = $this->content;

		$footer = "";

		include("squelette.php");
		
		
	}
	public function prepareDebugPage($variable) {
		$this->title = 'Debug';
		$this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
	}
	public function prepareTestPage(){
		$this->title = "PageTest";
		$this->content = "Cette Page Est un test";
	}
	public function prepareErrorPage(){
		$this->title = "Erreur";
		$this->content = "Il y à eu une erreur";
	}
	public function prepareAnimalPage(Animal $animal){
		$this->title = "Page sur ".self::htmlesc($animal->get_nom());
		$this->content = self::htmlesc($animal->get_nom())." est un animal de l'espèce ".self::htmlesc($animal->get_espece());
		$this->content .= ", il a ".self::htmlesc($animal->get_age())." ans";
	}
	public function prepareUnknownAnimalPage(){
		$this->title = "404";
		$this->content = "Animal inconnu ";
	}
	public function prepareHomePage(){
		$this->title = "Accueil";
		$this->content = "Bonjour";
	}
	public function prepareListPage(Array $animalTab){
		$this->title = "liste";
		$this->content = "<ul>";
		foreach ($animalTab as $id => $animal) {
			$this->content .= '<li><a href="'.$this->routeur->getAnimalURL($id).'">'.self::htmlesc($animal->get_nom()).'</a>';
			
			$this->content .='<a href="'.$this->routeur->getAnimalUpdateURL($id).'"><i><img src="src/images/crayon.png" alt="modifier" height="25"></i></a>';
			$this->content .='<a href="'.$this->routeur->getAnimalDeleteURL($id).'"><i><img src="src/images/corbeille.png" alt="supprimer" height="25"></i></a>';
			$this->content .='</li>';
		}
		$this->content .= "</ul>";
	}

	//possible factorisation en ajoutant un argument $targetURL
	public function prepareAnimalCreationPage($builder){
		$this->title = 'Creation';
		$url = $this->routeur->getAnimalSaveURL();

		$nomRef = $builder->getNomRef();
		$especeRef = $builder->getEspeceRef();
		$ageRef = $builder->getAgeRef();
		
		$nom = self::htmlesc($builder->getData($nomRef));
		$espece = self::htmlesc($builder->getData($especeRef));
		$age = self::htmlesc($builder->getData($ageRef));

		$erreurNom = $builder->getErrors($nomRef);
		$erreurEsp = $builder->getErrors($especeRef);
		$erreurAge = $builder->getErrors($ageRef);
		include("form.html");
	}
	public function prepareAnimalUpdatePage($builder,$id){
		$this->title = 'Modification';
		$url = $this->routeur->getAnimalUpdateSaveURL($id);

		$nomRef = $builder->getNomRef();
		$especeRef = $builder->getEspeceRef();
		$ageRef = $builder->getAgeRef();
		
		$nom = self::htmlesc($builder->getData($nomRef));
		$espece = self::htmlesc($builder->getData($especeRef));
		$age = self::htmlesc($builder->getData($ageRef));

		$erreurNom = $builder->getErrors($nomRef);
		$erreurEsp = $builder->getErrors($especeRef);
		$erreurAge = $builder->getErrors($ageRef);
		include("form.html");
	}

	public function displayAnimalCreationSuccess($id){
		$this->routeur->POSTredirect($this->routeur->getAnimalURL($id),"<span style='color: blue;'>l'animal a été ajouté</span><br>");
	}
	public function displayAnimalUpdateSuccess($id){
		$this->routeur->POSTredirect($this->routeur->getAnimalURL($id),"<span style='color: blue;'>l'animal a été modifié</span><br>");
	}
	public function displayAnimalDeleteSuccess(){
		$this->routeur->POSTredirect($this->routeur->getListURL(),"<span style='color: blue;'>l'animal a été supprimé</span><br>");
	}
	public function displayAnimalNotFound(){
		$this->routeur->POSTredirect($this->routeur->getListURL(),"<span style='color: red;'>l'animal a été modifié</span><br>");
	}

	public static function htmlesc($str) {
		return htmlspecialchars($str,
		ENT_QUOTES
		| ENT_SUBSTITUTE
		| ENT_HTML5,'UTF-8');
	}
}
