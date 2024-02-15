<?php

require_once("model/Animal.php");


$GLOBALS['NomRef'] = 'Nom';
$GLOBALS['EspeceRef'] = 'Espece';
$GLOBALS['AgeRef'] = 'Age';


class AnimalBuilder {

	protected $data;
	protected $errors;

	public function __construct($data=null) {
		if ($data === null) {
			$data = array(
				$GLOBALS['NomRef'] => "",
                $GLOBALS['EspeceRef'] => "",
                $GLOBALS['AgeRef'] => NULL,
			);
		}
		$this->data = $data;
		$this->errors = array();
	}
	public static function buildFromAnimal(Animal $animal) {
		return new AnimalBuilder(array(
			$GLOBALS['NomRef'] => $animal->get_nom(),
			$GLOBALS['EspeceRef'] => $animal->get_espece(),
            $GLOBALS['AgeRef'] => $animal->get_age()
		));
	}


    public function isValid() {
        $this->errors = array();
    
        if (!key_exists($GLOBALS['NomRef'], $this->data) || trim($this->data[$GLOBALS['NomRef']]) == "") {
            $this->errors[$GLOBALS['NomRef']] = "le nom ne doit pas être vide";
        }
    
        if (!key_exists($GLOBALS['EspeceRef'], $this->data) || trim($this->data[$GLOBALS['EspeceRef']]) == "") {
            $this->errors[$GLOBALS['EspeceRef']] = "l'espece ne doit pas être vide";
        }
    
        if (!key_exists($GLOBALS['AgeRef'], $this->data) || $this->data[$GLOBALS['AgeRef']] == NULL) {
            $this->errors[$GLOBALS['AgeRef']] = "l'age ne doit pas être vide";
        } else if(!preg_match("/^[0-9]*$/i", $this->data[$GLOBALS['AgeRef']])){
            $this->errors[$GLOBALS['AgeRef']] = "Caractères autorisés : 0123456789";
        } else if ($this->data[$GLOBALS['AgeRef']] < 0) {
            $this->errors[$GLOBALS['AgeRef']] = "l'age doit être positif";
        } 
    
        return count($this->errors) === 0;
    }
        #Les constantes sont ici
	public function getNomRef() {
		return $GLOBALS['NomRef'];
	}
	public function getEspeceRef() {
		return $GLOBALS['EspeceRef'];
	}
    public function getAgeRef() {
		return $GLOBALS['AgeRef'];
	}

    
	public function getData($ref) {
		return key_exists($ref, $this->data)? $this->data[$ref]: '';
	}

	public function getErrors($ref = NULL) {
        if($ref === NULL)
            return $this->errors;
        return key_exists($ref, $this->errors)? $this->errors[$ref]: null;
	
    }

	public function createAnimal() {
		if (!key_exists($GLOBALS['NomRef'], $this->data) || !key_exists($GLOBALS['EspeceRef'], $this->data) || !key_exists($GLOBALS['AgeRef'], $this->data))
			throw new Exception("Il Manque un element pour la creation d'un animal");
		return new Animal($this->data[$GLOBALS['NomRef']], $this->data[$GLOBALS['EspeceRef']],$this->data[$GLOBALS['AgeRef']]);
	}

	public function updateAnimal(Animal $animal) {
		if (key_exists($GLOBALS['NomRef'], $this->data))
			$animal->set_nom($this->data[$GLOBALS['NomRef']]);
        if (key_exists($GLOBALS['EspeceRef'], $this->data))
			$animal->set_espece($this->data[$GLOBALS['EspeceRef']]);
        if (key_exists($GLOBALS['AgeRef'], $this->data))
			$animal->set_age($this->data[$GLOBALS['AgeRef']]);
	}

}
