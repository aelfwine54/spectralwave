<?php
class Auth extends Slim_Middleware {
	public function call(){
		$app = $this->app;
		$req = $app->request();
		$head = $req->headers();
		isset($head['PHP_AUTH_USER']) ? $user = $head['PHP_AUTH_USER'] : $user = null;
        isset($head['PHP_AUTH_PW']) ? $password = $head['PHP_AUTH_PW'] : $password = "1";

        if($user !=null){
        	$joueur = Model::factory('Joueur')->where('pseudo', $user)->find_one();

        	if(!empty($joueur)){

        		$hash = crypt($password,'plop');
        		$passe = $joueur->password;
        		$passe = crypt($passe,'plop');

				if ($hash == $passe){
					$app->joueur($joueur);
				}
				else{
					//echo "Pas connecte";
				}
        	}
        }

        $this->next->call();
	}
}
?>