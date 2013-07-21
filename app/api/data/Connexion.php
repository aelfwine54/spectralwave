<?php
class Connexion extends Model{
	private $id;
	private $joueurId;
	private $sessionToken;
	private $startDate;
	private $endDate;
	private $isActive;


	public function getId()
	{
	    return $this->id;
	}
	
	public function setId($newId)
	{
	    $this->id = $newId;
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

	public function getSessionToken()
	{
	    return $this->sessionToken;
	}
	
	
	public function setSessionToken($newSessionToken)
	{
	    $this->sessionToken = $newSessionToken;
	    return $this;
	}

	public function getStartDate()
	{
	    return $this->startDate;
	}
	
	
	public function setStartDate($newStartDate)
	{
	    $this->startDate = $newStartDate;
	    return $this;
	}


	public function getEndDate()
	{
	    return $this->endDate;
	}
	
	
	public function setEndDate($newEndDate)
	{
	    $this->endDate = $newEndDate;
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

	public function toInfo(){
		return $this->as_array();
	}

	public function doConnect($pseudo,$password){
		//get player info
		$joueur = Model::factory('Joueur')->where('pseudo', $pseudo)->find_one();
        	if(empty($joueur)){
        		
        	}
		$connexion = Model::factory('Connexion')->create();
	    //$connexion->pseudo = $pseudo;
	   // $connexion->password = crypt($password,$salt);
	    $connexion->joueurId = 1;
	    $connexion->sessionToken = 'adsaf';
	    $connexion->isActive = true;
	    $connexion->startDate = time();
	    $connexion->endDate = time() + (24 * 3600 * 30);//30
	    $connexion->save();
		return null;
	}
}
?>