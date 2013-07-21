<?php
class Ville extends Model{
	public static $_table = 'villes';
	public static $_id_column = 'villeId';

	private $villeId;
	private $nom;
	private $maireId;
	private $maireAdjointId;
	private $theme;
	private $description;


	public function getVilleId()
	{
	    return $this->villeId;
	}
	
	
	public function setVilleId($newVilleId)
	{
	    $this->villeId = $newVilleId;
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


	public function getMaireId()
	{
	    return $this->maireId;
	}
	
	
	public function setMaireId($newMaireId)
	{
	    $this->maireId = $newMaireId;
	    return $this;
	}


	public function getMaireAdjointId()
	{
	    return $this->maireAdjointId;
	}
	
	
	public function setMaireAdjointId($newMaireAdjointId)
	{
	    $this->maireAdjointId = $newMaireAdjointId;
	    return $this;
	}


	public function getTheme()
	{
	    return $this->theme;
	}
	
	
	public function setTheme($newTheme)
	{
	    $this->theme = $newTheme;
	    return $this;
	}


	public function getDescription()
	{
	    return $this->description;
	}
	
	
	public function setDescription($newDescription)
	{
	    $this->description = $newDescription;
	    return $this;
	}

	public function maire() {
        return $this->belongs_to('Joueur', 'maireId');
    }

    public function maireAdjoint() {
        return $this->belongs_to('Joueur', 'maireAdjointId');
    }

    public function habitants(){
    	return $this->has_many('Habitant', 'villeId');
    }

    public function toInfo(){
    	$info = $this->as_array();

    	$info['id'] = $info['villeId'];
		unset($info['villeId']);

		$maire = $this->maire()->find_one();
		if($maire!=null)
		{
			$info['maire'] = $maire->as_array();
			unset($info['maireId']);
			unset($info['maire']['password']);
			unset($info['maire']['courriel']);
		}

		$adjoint = $this->maireAdjoint()->find_one();
		if($adjoint!=null)
		{
			$info['maideAdjoint'] = $adjoint->as_array();
			unset($info['maireAdjointId']);
			unset($info['maideAdjoint']['password']);
			unset($info['maideAdjoint']['courriel']);
		}

		return $info;
    }
}
?>