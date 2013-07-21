<?php
/*
 * Get la liste de toutes les news, ou moins selon les parametres
 */
function getNews($id = 0){
     $news = Nouvelle::getNews($id);

    foreach($news as $key=>$elem)
    {
       $news[$key] = $elem->toInfo();
    }

    echo json_encode($news);
}


/*
 * Get la liste de tous les events, ou moins selon les parametres
 */
function getEvents($id = 0){
    $events = Event::getEvents($id);

    foreach($events as $key=>$elem)
    {
       $events[$key] = $elem->toInfo();
    }

    echo json_encode($events);
}


/*
 * Get la liste de tous les commentaires pour un event, ou moins selon les parametres
 */
function getEventComms($id){
    $commentaires = array();
    $results = Model::factory('Commentaires_Event')->where('eventId',$id)->find_many();
    $commentaires = array_merge($results,$commentaires);

    foreach($commentaires as $key=>$elem)
    {
       $commentaires[$key] = $elem->toInfo();
        // echo $elem;
        // print_r($elem);
    }

    echo json_encode($commentaires);
}


/*
 * Get la liste de tous les commentaires pour une news, ou moins selon les parametres
 */
function getNewsComms($id){
    $commentaires = array();
    $results = Model::factory('Commentaires_Nouvelle')->where('nouvelleId',$id)->find_many();
    $commentaires = array_merge($results,$commentaires);

    foreach($commentaires as $key=>$elem)
    {
       $commentaires[$key] = $elem->toInfo();
        // echo $elem;
        // print_r($elem);
    }

    echo json_encode($commentaires);
}

/*
 * Ajoute un event
 */
function addEvent(){
    $app = Slim::getInstance();
    $data = $app->request()->getBody();
    $data = json_decode($data);

    $erreur = array();

    isset($data->titre) ? $titre = $data->titre : $erreur[] = "Titre obligatoire";
    isset($data->description) ? $description = $data->description : $erreur[] = "Description obligatoire";


    if(empty($erreur)){
        $event = Model::factory('Event')->create();

        $event->titre=$titre;
        $event->description=$description;
        if(isset($data->date))
            $event->date=$data->date;

        if(isset($data->jeuId)) $event->jeuId = $data->jeuId;
        $event->save();
        echo json_encode($event->toInfo());
    }

    if(!empty($erreur)){
        $app->response()->status(400);
        $app->response()->write(json_encode($erreur));
    }
}

/*
 * Ajoute une nouvelle
 */
function addNews(){
    $app = Slim::getInstance();
    $data = $app->request()->getBody();
    $data = json_decode($data);

    $erreur = array();


    isset($data->titre) ? $titre = $data->titre : $erreur[] = "Titre obligatoire";
    isset($data->description) ? $description = $data->description : $erreur[] = "Description obligatoire";
    isset($data->pubdate) ? $pubdate = $data->pubdate : $erreur[] = "Aucune date de creation";

    if(empty($erreur)){
        $nouvelle = Model::factory('Nouvelle')->create();

        $nouvelle->titre=$titre;
        $nouvelle->description=$description;
        $nouvelle->pubdate = $pubdate;

        if(isset($data->jeuId))
            $nouvelle->jeuId = $data->jeuId;

        $nouvelle->save();
        echo json_encode($nouvelle->toInfo());
    }

    if(!empty($erreur)){
        $app->response()->status(400);
        $app->response()->write(json_encode($data));
    }
};

/*
 * Ajoute un commentaire à une nouvelle
 */
function addNewsComment($id){
    $app = Slim::getInstance();
    $data = $app->request()->getBody();
    $data = json_decode($data);

    $erreur = array();
    $nouvelle = Model::factory('Nouvelle')->where('newsId',$id)->find_one();
    if(empty($nouvelle))
        $erreur[] = "Nouvelle inexistante";

    isset($data->contenu) ? $contenu = $data->contenu : $erreur[] = "Commentaire vide";
    isset($data->date) ? $date = $data->date : $erreur[] = "Aucune date de creation";

    if(empty($erreur)){
        $commentaire = Model::factory('Commentaires_Nouvelle')->create();

        
        $commentaire->auteur=$_SESSION['joueur']['pseudo'];
        $commentaire->courriel=$_SESSION['joueur']['courriel'];
        $commentaire->nouvelleId = $id;
        $commentaire->contenu=$contenu;
        $commentaire->date = $date;

        $commentaire->save();
        echo json_encode($commentaire->toInfo());
    }

    if(!empty($erreur)){
        $app->response()->status(400);
        $app->response()->write(json_encode($data));
    }
};

/*
 * Ajoute un commentaire à un event
 */
function addEventComment($id){
    $app = Slim::getInstance();
    $data = $app->request()->getBody();
    $data = json_decode($data);

    $erreur = array();
    $event = Model::factory('Event')->where('id',$id)->find_one();
    if(empty($event))
        $erreur[] = "Event inexistant";

    isset($data->contenu) ? $contenu = $data->contenu : $erreur[] = "Description obligatoire";
    isset($data->date) ? $date = $data->date : $erreur[] = "Aucune date de creation";

    if(empty($erreur)){
        $commentaire = Model::factory('Commentaires_Event')->create();

        $commentaire->auteur=$_SESSION['joueur']['pseudo'];
        $commentaire->courriel=$_SESSION['joueur']['courriel'];
        $commentaire->eventId = $id;
        $commentaire->contenu=$contenu;
        $commentaire->date = $date;

        $commentaire->save();
        echo json_encode($commentaire->toInfo());
    }

    if(!empty($erreur)){
        $app->response()->status(400);
        $app->response()->write(json_encode($data));
    }
};

/*
 * Update an event
 */
function updateEvent($id){
    $app = Slim::getInstance();
    $data = $app->request()->getBody();
    $data = json_decode($data);

    if(!isset($id))throw new Exception("Event introuvable");

    $erreur = array();

    $event = Model::factory('Event')->find_one($id);

    if(!empty($event)){
        isset($data->titre) ? $titre = $data->titre : $erreur[] = "Titre obligatoire";
        isset($data->description) ? $description = $data->description : $erreur[] = "Description obligatoire";

        if(empty($erreur)){
            $event->titre=$titre;
            $event->description=$description;
            if(isset($data->date))
                $event->date=$data->date;
            if(isset($data->jeuId))
                $event->jeuId = $data->jeuId;

            $event->save();
            echo json_encode($event->toInfo());
        }
    }
    else{
        $erreur[]= "Event introuvable";
    }

    if(!empty($erreur)){
        $app->response()->status(400);
        $app->response()->write(json_encode($erreur));
    }
};

/*
 * Update une news
 */
function updateNews($id){
    $app = Slim::getInstance();
    $data = $app->request()->getBody();
    $data = json_decode($data);

    if(!isset($id))throw new Exception("News introuvable");

    $erreur = array();

    $news = Model::factory('Nouvelle')->find_one($id);

    if(!empty($news)){
        isset($data->titre) ? $titre = $data->titre : $erreur[] = "Titre obligatoire";
        isset($data->description) ? $description = $data->description : $erreur[] = "Description obligatoire";

        if(empty($erreur)){
            $news->titre=$titre;
            $news->description=$description;
            if(isset($data->jeuId))
                $news->jeuId = $data->jeuId;

            $news->save();
            echo json_encode($news->toInfo());
        }
    }
    else{
        $erreur[]= "News introuvable";
    }

    if(!empty($erreur)){
    $app->response()->status(400);
    $app->response()->write(json_encode($erreur));
    }
};

/*
 * DELETE
 */

/*
 * Delete a news
 */
function deleteNews($id){
    $news = Model::factory('Nouvelle')->find_one($id);
    if($news!==null){
        $news->delete();
    }
}

/*
 * Delete an event
 */
function deleteEvent($id){
    $event = Model::factory('Event')->find_one($id);
    if($event!==null){
        $event->delete();
    }
}

/*
 * Delete un commentaire de news
 */
function deleteNouvelleCommentaire($newsId, $commId){
    $news = Model::factory('Nouvelle')->find_one($newsId);
    //TODO securite
    if($news!==null){
        $commentaire = Model::factory('Commentaires_Nouvelle')->find_one($commId);
        if($commentaire!==null){
            $commentaire->delete();
        }
    }
}

/*
 * Delete un commentaire d'event
 */
function deleteEventCommentaire($eventId, $commId){
    $event = Model::factory('Event')->find_one($eventId);
    //TODO securite
    if($event!==null){
        $commentaire = Model::factory('Commentaires_Event')->find_one($commId);
        if($commentaire!==null){
            $commentaire->delete();
        }
    }
}
?>