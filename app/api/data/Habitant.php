<?php
class Habitant extends Model{
	public static $_table = 'habitants';
	public static $_id_column = 'habitantId';

	private $habitantId;
	private $villeId;
	private $joueurId;
	private $gradeId;
	private $metierId;
	private $lastModified;
	private $joinDate;


	public function getHabitantId()
	{
	    return $this->habitantId;
	}
	
	
	public function setHabitantId($newHabitantId)
	{
	    $this->habitantId = $newHabitantId;
	    return $this;
	}


	public function getVilleId()
	{
	    return $this->villeId;
	}
	
	
	public function setVilleId($newVilleId)
	{
	    $this->villeId = $newVilleId;
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


	public function getGradeId()
	{
	    return $this->gradeId;
	}
	
	
	public function setGradeId($newGradeId)
	{
	    $this->gradeId = $newGradeId;
	    return $this;
	}


	public function getMetierId()
	{
	    return $this->metierId;
	}
	
	
	public function setMetierId($newMetierId)
	{
	    $this->metierId = $newMetierId;
	    return $this;
	}


	public function getLastModified()
	{
	    return $this->lastModified;
	}
	
	
	public function setLastModified($newLastModified)
	{
	    $this->lastModified = $newLastModified;
	    return $this;
	}


	public function getJoinDate()
	{
	    return $this->joinDate;
	}
	
	
	public function setJoinDate($newJoinDate)
	{
	    $this->joinDate = $newJoinDate;
	    return $this;
	}

	public function metier(){
		return $this->has_one('Metier', 'metierId');
	}

	public function ville(){
		return $this->belongs_to('Ville', 'villeId');
	}

	public function grade(){
		return $this->has_one('Grade', 'gradeId');
	}

	public function joueur(){
		return $this->has_one('Joueur', 'joueurId');
	}

	public function toInfo(){
		$info = $this->as_array();

		$info['id'] = $info['habitantId'];
		unset($info['habitantId']);

		
		$grade = Model::factory('Grade')->find_one($info['gradeId']);
		$info['grade'] = $grade->as_array();
		unset($info['gradeId']);
		
 		$metier = Model::factory('Metier')->find_one($info['metierId']);

		unset($info['metierId']);
		$info['metier'] = $metier->as_array();

		$ville = $this->ville()->find_one($info['villeId']);
		$info['ville'] = $ville->nom;

		$joueur = Model::factory('Joueur')->find_one($info['joueurId']);
		$info['joueur'] = $joueur->pseudo;

		return $info;
	}
}?>