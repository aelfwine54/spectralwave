<?php
session_cache_limiter(false);
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('intl.default_locale', 'fr-CA');
define('default_locale', 'fr-CA');
//echo json_encode(ORM::get_query_log());
//echo json_encode(ORM::get_last_query());

require 'Slim/Slim.php';

require_once 'orm/idiorm.php';
require_once 'orm/paris.php';

require_once 'popo/JoueurInfo.php';

require_once 'adapter/JoueurAdapter.php';

require_once 'data/Console.php';
require_once 'data/Jeu.php';
require_once 'data/Grade.php';
require_once 'data/Habitant.php';
require_once 'data/JeuJoueur.php';
require_once 'data/Metier.php';
require_once 'data/Ville.php';
require_once 'data/Connexion.php';
require_once 'data/Event.php';
require_once 'data/Commentaires_Event.php';
require_once 'data/Commentaires_Nouvelle.php';
require_once 'data/Nouvelle.php';
require_once 'data/Literal.php';

require_once 'logique/Login.php';
require_once 'logique/Informatif.php';
require_once 'logique/CSM.php';

ORM::configure('mysql:host=localhost;dbname=frederic_spectralwave');
ORM::configure('username', 'root');
ORM::configure('password', '');
ORM::configure('logging', true);

$app = new Slim(array('mode' => 'development','debug' =>true, 'cookies.secret_key' => 'rolecraft',
 'log.enabled' => true,'log.level' => 4));

$app->setName("Spectral Wave");
$app->contentType('application/json');

$salt = 'plop';//magic word to crypt things

$authenticateForRole = function ( $role = 'Visiteur' ) {
    return function () use ( $role ) {
        $user = $_SESSION['joueur'];

        if ( Joueur::joueurAppartient($user, $role) === false ) {
            $app = Slim::getInstance();
            $app->response()->status(401);
            $app->response()->write('Acces interdit');
            $app->stop();
        }
    };
};

/*
 * Connexion
 */
$app->post('/connect', 'connect');
$app->post('/logout', 'logout');

/*
 * Literals
 */
$app->get('/literals/:name', $authenticateForRole('Visiteur'), 'getLiteral');
$app->post('/literals', $authenticateForRole('Admin'), 'postLiteral');
$app->put('/literals/:name', $authenticateForRole('Admin'), 'putLiteral');


/*
 * Get la liste de tous les jeux
 */
$app->get('/jeux', 'getJeux');
function getJeux(){
    $jeux = Jeu::getJeux();
    foreach($jeux as $key=>$elem)
    {
       $jeux[$key] = $elem->toInfo();
    }

    echo json_encode($jeux);
}


$app->get('/events(/:id)', 'getEvents');
$app->get('/news(/:id)', 'getNews');
$app->get('/events/:id/commentaires', 'getEventComms');
$app->get('/news/:id/commentaires', 'getNewsComms');


/*
 * POST
*/

$app->post('/events', $authenticateForRole('Moderateur'), 'addEvent');
$app->post('/news', $authenticateForRole('Moderateur'),'addNews');
$app->post('/news/:id/commentaires', $authenticateForRole('Visiteur'), 'addNewsComment');
$app->post('/events/:id/commentaires', $authenticateForRole('Visiteur'), 'addEventComment');
$app->post('/joueurs', 'addJoueur');


/*
 * UPDATE
 */

$app->put('/events/:id', $authenticateForRole('Moderateur'), 'updateEvent');
$app->put('/news/:id', $authenticateForRole('Moderateur'), 'updateNews');


/*
 * DELETE
 */

$app->delete('/news/:id', $authenticateForRole('Moderateur'), 'deleteNews');
$app->delete('/events/:id', $authenticateForRole('Moderateur'), 'deleteEvent');
$app->delete('/news/:newsId/commentaires/:commId', $authenticateForRole('Visiteur'), 'deleteNouvelleCommentaire');
$app->delete('/events/:eventId/commentaires/:commId', $authenticateForRole('Visiteur'), 'deleteEventCommentaire');


// $app->get('/', function () {
//    $content = array('author' => 'Frederic Bergeron', 'Created on' => date('Y-M-d'),
//     'Client' =>'Spectral Wave Team', 'Editor' =>'Solutions Informatiques Frederic Bergeron',
//     'Copyright' =>'All rights reserved to Solutions Informatiques Frederic Bergeron');

//    $content['Description'] = 'This is the public API for gathering informations about Spectral Wave
// players, games and servers. If you have any question, please contact the website administrator.';

//    echo json_encode($content);
// });

// /*
//  * Connexion related
//  */
// $app->get('/auth/login/:pseudo/:password', function($pseudo, $password) use($salt){
//     $connexion = Model::factory('Connexion')->create();
//     //$connexion->pseudo = $pseudo;
//    // $connexion->password = crypt($password,$salt);
//     $connexion->joueurId = 1;
//     $connexion->sessionToken = 'adsaf';
//     $connexion->isActive = true;
//     $connexion->startDate = time();
//     $connexion->endDate = time() + (24 * 3600 * 30);//30
//     $connexion->save();
// });


// /*
//  *
//  * GET
//   *
//  */


// /*
//  * Get toutes les consoles, ou un seule par son ID
//  */
// $app->get('/consoles(/:id)', function ($id = 0) {
//     $consoles = array();
//     if($id <=0)
//     {
//         $results = Model::factory('Console')->find_many();
//         $consoles = array_merge($results,$consoles);
//     }
//     else{
//         $consoles[] = Model::factory('Console')->find_one($id);
//     }

//     foreach($consoles as $console)
//     {
//         echo json_encode($console->toInfo());
//     }
      
// });

// /*
//  * Get tous les joueurs
//  */
// $app->get('/joueurs', function (){
//      $joueurs = Model::factory('Joueur')->find_many();

//     foreach($joueurs as $joueur)
//     {
//         echo json_encode($joueur->toInfo());
//     }
// });

// /*
//  * Get un joueur par son ID
//  */
// $app->get('/joueurs/:id', function($id){
//    $joueur = Model::factory('Joueur')->find_one($id);

//    if($joueur!=null)
//    {
//         echo json_encode($joueur->toInfo());
//     }
// });

// /*
//  * Get un jeu par son ID
//  */
// $app->get('/jeux/:id', function($id){
//    $jeu = Model::factory('Jeu')->find_one($id);

//    if($jeu!=null){
//         echo json_encode($jeu->toInfo());
//     }
// });

// /*
//  * Get la liste des toutes les villes
//  */
// $app->get('/villes', function(){
//      $villes = Model::factory('Ville')->find_many();
//     foreach($villes as $ville)
//     {
        
//         echo json_encode($ville->toInfo());
//     }
// });

// /*
//  * Get une ville par son ID
//  */
// $app->get('/villes/:id', function($id){
//    $ville = Model::factory('Ville')->find_one($id);

//    if($ville!=null){
//         echo json_encode($ville->toInfo());
//     }
// });

// /*
//  * Get la liste de tous les habitants d'une ville
//  */
// $app->get('/villes/:villeId/habitants', function($villeId){
//      $ville = Model::factory('Ville')->find_one($villeId);


//     if($ville!=null)
//     {
//         $habitants = $ville->habitants()->find_many();
//         foreach($habitants as $habitant)
//         {
//             echo json_encode($habitant->toInfo());
//         }
//     }
// });

// /*
//  * Get un habitant par son ID dans une ville prédéfinie
//  */
// $app->get('/villes/:villeId/habitants/:habitantId', function($villeId, $habitantId){
//    $ville = Model::factory('Ville')->find_one($villeId);

//    if($ville!=null){
//         $habitant = $ville->habitants()->find_one($habitantId);
//         if($habitant!=null)
//         {
//             echo json_encode($habitant->toInfo());
//         }
//     }
// });

// /*
//  * Get la liste de tous les grades
//  */
// $app->get('/grades', function(){
//      $grades = Model::factory('Grade')->find_many();
//     foreach($grades as $grade)
//     {
//         echo json_encode($grade->toInfo());
//     }
// });

// /*
//  * Get un grade par son ID
//  */
// $app->get('/grades/:id', function($id){
//    $grade = Model::factory('Grade')->find_one($id);

//    if($grade!=null)
//     {
//         echo json_encode($grade->toInfo());
//     }
// });

// /*
//  * Get la liste de tous les métiers
//  */
// $app->get('/metiers', function(){
//      $metiers = Model::factory('Metier')->find_many();
//     foreach($metiers as $metier)
//     {
//         echo json_encode($metier->toInfo());

//     }
// });

// /*
//  * Get un metier par son ID
//  */
// $app->get('/metiers/:id', function($id){
//    $metier = Model::factory('Metier')->find_one($id);

//    if($metier!=null)
//     {
//         echo json_encode($metier->toInfo());
//     }
// });

// /*
//  * Get la liste des jeux d'un joueur
//  */
// $app->get('/joueurs/:id/jeux', function($id){
//     $joueur = Model::factory('Joueur')->find_one($id);

//     if($joueur!=null)
//     {
//         $jeujoueurs = $joueur->jeux()->find_many();

//         foreach ($jeujoueurs as $jj)
//         {
//             echo json_encode($jj->jeuInfo());
//         }
//     }
// });

// /*
//  * Get la liste des joueurs jouant a un jeu
//  */
// $app->get('/jeux/:id/joueurs', function($id){
//     $jeu = Model::factory('Jeu')->find_one($id);

//     if($jeu !=null)
//     {
//         $jeujoueurs = $jeu->joueurs()->find_many();

//         foreach ($jeujoueurs as $jj)
//         {
//             echo json_encode($jj->joueurInfo());
//         }
//     }
// });




// /*
//  * PUT
//  */







$app->run();


