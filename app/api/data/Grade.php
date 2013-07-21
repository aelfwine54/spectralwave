<?php
class Grade extends Model{
	public static $_table = 'grades';
	public static $_id_column = 'gradeId';

	private $gradeId;
	private $nom;


	public function getGradeId()
	{
	    return $this->gradeId;
	}
	
	
	public function setGradeId($newGradeId)
	{
	    $this->gradeId = $newGradeId;
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

	public function toInfo(){
		$info = $this->as_array();

		$info['id'] = $info['gradeId'];
		unset($info['gradeId']);

		return $info;
	}
}?>