<?php
class Joueur extends Model{
	public static $_table = 'joueurs';
	public static $_id_column = 'joueurId';

	private $joueurId = 0;
	private $pseudo = '';
	private $password = '';
	private $courriel = '';
	private $gradePrincipalId = '6';



	public function jeux(){
		return $this->has_many('JeuJoueur', 'joueurId');
	}

	public function toInfo(){
		$info = $this->as_array();

		$grade = Model::factory('Grade')->find_one($info['gradePrincipalId']);
		$info['grade'] = $grade->as_array();
		unset($info['gradePrincipalId']);

		$info['id'] = $info['joueurId'];
		unset($info['joueurId']);

		unset($info['password']);
		return $info;
	}

	public static function joueurAppartient($joueur, $role){
		$grade = Model::factory('Grade')->where('nom', $role)->find_one();

		if (!empty($grade)){
			if ($joueur['gradePrincipalId'] <= $grade->gradeId) return true;
		}

		return false;
	}
}