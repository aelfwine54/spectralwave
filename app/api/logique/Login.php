<?php
function connect(){
    $app = Slim::getInstance();
    $data = $app->request()->getBody();
    $data = json_decode($data);

    $erreur = array();

    isset($data->pseudo) ? $pseudo = $data->pseudo : $erreur[] = 'Pseudo manquant';
    isset($data->password) ? $password = $data->password : $erreur[] = 'Password manquant';

    if(empty($erreur)){
        $joueur = Model::factory('Joueur')->where('pseudo',$pseudo)->find_one();

        if(empty($joueur)){
            $erreur[] = 'Pseudo invalide';
        }
        else
        {
            if($joueur->password == crypt($password,'plop')){
                $_SESSION['joueur'] = $joueur->as_array();
                $app->setCookie('grade', $joueur->gradePrincipalId);
                $app->setCookie('pseudo', $joueur->pseudo);
                echo json_encode($joueur->toInfo());
            }
            else{
                $erreur[] = 'Mauvais mot de passe';
            }
        }
    }


    if(!empty($erreur)){
        $app->response()->status(400);
        $app->response()->write(json_encode($erreur));
    }
}

function logout(){
    $app = Slim::getInstance();
    $app->deleteCookie('grade');
    session_destroy();

}

/*
 * Ajoute un joueur
 */
function addJoueur(){
    $app = Slim::getInstance();
    $data = $app->request()->getBody();
    $data = json_decode($data);
    if(!isset($data->pseudo))throw new Exception("Pseudo obligatoire");
    $pseudo = $data->pseudo;

    $erreur = array();

    $joueur = Model::factory('Joueur')->where('pseudo', $pseudo)->find_many();

    if(empty($joueur)){
        isset($data->password) ? $password = $data->password : $erreur[] = "Mot de passe obligatoire";
        strlen($password) >= 8 ? $password = crypt($password,'plop') : $erreur[] = "Mot de passe trop court, 8 caractères minimum";
        isset($data->courriel) ? $courriel = $data->courriel : $courriel ="";
        if ($courriel == "") 
            $erreur[] = "Courriel obligatoire";
        else 
            filter_var($courriel, FILTER_VALIDATE_EMAIL) ? : $erreur[] = "Courriel invalide";

        if(empty($erreur)){
            $joueur = Model::factory('Joueur')->create();

            $joueur->pseudo=$pseudo;
            $joueur->courriel=$courriel;
            $joueur->password=$password;

            $joueur->save();
            echo json_encode($joueur);
        }
    }
    else{
        $erreur[]= "Pseudo d&eacute;j&agrave; utilis&eacute;";
    }

    if(!empty($erreur)){
        $app->response()->status(400);
        $app->response()->write(json_encode($erreur));
    }

};

?>