<?php
class Metier extends Model{
	public static $_table='metiers';
	public static $_id_column = 'metierId';

	private $metierId;
	private $nom;


	public function getMetierId()
	{
	    return $this->metierId;
	}
	
	
	public function setMetierId($newMetierId)
	{
	    $this->metierId = $newMetierId;
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

	public function habitants(){
		return $this->belongs_to('Habitant', 'metierId');
	}

	public function toInfo(){
		$info = $this->as_array();

		$info['id'] = $info['metierId'];
		unset($info['metierId']);

		return $info;
	}
}?>
