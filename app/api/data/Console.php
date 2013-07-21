<?php
class Console extends Model{
	public static $_table = 'consoles';
	public static $_id_column = 'consoleId';

	private $consoleId;
	private $nom;


	public function getConsoleId()
	{
	    return $this->consoleId;
	}
	
	
	public function setConsoleId($newConsoleId)
	{
	    $this->consoleId = $newConsoleId;
	    return $this;
	}


	public function getNom()
	{
	    return $this->nom;
	}
	
	
	public function setNom($newNom)
	{
	    $this->nom = $newNom;
	    return $this;
	}

	public function jeux() {
        return $this->has_many('Jeu', 'consoleId');
    }

    public function toInfo(){
    	$info = $this->as_array();
    	$info["id"] = $info['consoleId'];
    	unset ($info['consoleId']);
    	return $info;
    }
}
?>