<?php

class JoueurInfo{
	private $id = 0;
	private $pseudo = '';
	private $courriel = '';
	private $gradePrincipalId = '1';

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getPseudo(){
		return $this->pseudo;
	}

	public function setPseudo($pseudo){
		$this->pseudo = $pseudo;
	}

	public function getCourriel(){
		return $this->courriel;
	}

	public function setCourriel($courriel){
		$this->courriel = $courriel;
	}

	public function getGradePrincipalId(){
		return $this->gradePrincipalId;
	}

	public function setGradePrincipalId($grade){
		$this->gradePrincipalId = $grade;
	}
};
?>