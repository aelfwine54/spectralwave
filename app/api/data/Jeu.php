<?php
class Jeu extends Model{
	public static $_table = 'jeux';
	public static $_id_column = 'jeuId';

	private $jeuId;
	private $consoleId;
	private $nom;
	private $categorie;


	public static function getJeux(){
   		return Model::factory('Jeu')->find_many();	
   	}

	public function console() {
        return $this->belongs_to('Console', 'consoleId');
    }

    public function joueurs(){
    	return $this->has_many('JeuJoueur', 'jeuId');
    }

    public function toInfo(){
    	$info = $this->as_array();

    	$console = $this->console()->find_one();

    	$info['console'] = $console->toInfo();
    	unset($info['consoleId']);

    	$info['id'] = $info['jeuId'];
		unset($info['jeuId']);
    	return $info;
    }
}