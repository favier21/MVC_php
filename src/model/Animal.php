<?php
class Animal {

	private $nom;
	private $espece;
	private $age;
	

	public function __construct(String $nom, String $espece,int $age) {
		$this->nom = $nom;
		$this->espece = $espece;
		$this->age = $age;
	}
	public function get_nom(){
		return $this->nom;
	}
	public function get_espece(){
		return $this->espece;
	}
	public function get_age(){
		return $this->age;
	}
	public function set_nom(String $nom){
		$this->nom = $nom;
	}
	public function set_espece(String $esp){
		$this->espece = $esp;
	}
	public function set_age(int $age){
		$this->age = $age;
	}

}
