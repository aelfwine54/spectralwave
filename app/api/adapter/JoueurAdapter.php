<?php
require_once 'data/Joueur.php';
/*class Joueur{
	public $var ="plop";
}*/
class JoueurAdapter{
	public static function createJoueurInfo(Joueur $joueur){
		$retour = new JoueurInfo();

		$retour->setPseudo($joueur->getPseudo());
		$retour->setId($joueur->getJoueurId());
		$retour->setCourriel($joueur->getCourriel());
		$retour->setGradePrincipalId($joueur->getGradePrincipalId());
	}

	public static function createJoueur(PDOStatement $rset){
		$retour = array();

		while($data = $rset->fetch()){
			$joueur = new Joueur();
			$joueur->setCourriel($data['courriel']);
			$joueur->setJoueurId($data['joueurId']);
			$joueur->setPseudo($data['pseudo']);
			$joueur->setPassword($data['password']);
			$joueur->setGradePrincipalId($data['gradePrincipalId']);
			$retour[] = $joueur;
			echo json_encode($joueur);
		}
		return $retour;
	}
}

?>