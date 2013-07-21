<?php
class JeuJoueur extends Model{
	public static $_table='jeujoueurs';
	public static $_id_column = 'jeuJoueurId';

	private $jeuJoueurId;
	private $jeuId;
	private $joueurId;
	private $isActive;
	private $addedDate;


	public function getJeuJoueurId()
	{
	    return $this->jeuJoueurId;
	}
	
	
	public function setJeuJoueurId($newJeuJoueurId)
	{
	    $this->jeuJoueurId = $newJeuJoueurId;
	    return $this;
	}


	public function getJeuId()
	{
	    return $this->jeuId;
	}
	
	
	public function setJeuId($newJeuId)
	{
	    $this->jeuId = $newJeuId;
	    return $this;
	}


	public function getJoueurId()
	{
	    return $this->joueurId;
	}
	
	
	public function setJoueurId($newJoueurId)
	{
	    $this->joueurId = $newJoueurId;
	    return $this;
	}


	public function getIsActive()
	{
	    return $this->isActive;
	}
	
	
	public function setIsActive($newIsActive)
	{
	    $this->isActive = $newIsActive;
	    return $this;
	}


	public function getAddedDate()
	{
	    return $this->addedDate;
	}
	
	
	public function setAddedDate($newAddedDate)
	{
	    $this->addedDate = $newAddedDate;
	    return $this;
	}

	public function jeu(){
		return $this->belongs_to('Jeu', 'jeuId');
	}

	public function jeuInfo(){
		$info = $this->as_array();

		$jeu = $this->jeu()->find_one();
		$info['jeu'] = $jeu->toInfo();
		unset($info['jeuId']);

		unset($info['joueurId']);
		return $info;
	}

	public function joueurInfo(){
		$info = $this->as_array();

		$joueur = $this->joueur()->find_one();
		$info['joueur'] = $joueur->toInfo();
		unset($info['joueurId']);

		unset($info['jeuId']);
		return $info;
	}

	public function joueur(){
		return $this->belongs_to('Joueur', 'joueurId');
	}
}?>