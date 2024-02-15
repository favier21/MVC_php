<?php
class AnimalStorageStub implements AnimalStorage{

    private $animalTab;

	public function __construct() {
        $this->animalTab = array(
            'medor' => new Animal("Médor","chien",10),
            'felix' => new Animal('Félix', 'chat',3),
            'denver' => new Animal('Denver', 'dinosaure',3500000),
            );
	}
	public function read($id) : Animal{
		return $this->animalTab[$id];
	}
    public function readAll() : array {
        return $this->animalTab;
    }
    
    public function create(Animal $a,String $id = NULL) : String{
        $newid = trim(($id != NULL)? $id : strtolower($a->get_nom()));
        $newid = strtr(
            $newid,
            '@ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'aAAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy'
        );
        $this->animalTab[$newid] = $a;
    }
    
    public function delete($id) : Bool{
        if(array_key_exists($id,$this->animalTab)){
            unset($array[$id]);
            return true;
        }
        return false;
    }
    public function update($id, Animal $a) : Bool{
        if(array_key_exists($id,$this->animalTab)){
            unset($array[$id]);
            $this->create($a);
            return true;
        }
        return false;
    }

}

