<?php
function getLiteral($name){
     $literal = Literal::getLiteral($name);

    foreach($literal as $key=>$elem)
    {
       $literal[$key] = $elem->toInfo();
    }

    echo json_encode($literal);
}

function postLiteral(){
	$app = Slim::getInstance();
	$data = $app->request()->getBody();
	$data = json_decode($data);

	$erreur = array();

	isset($data->name) ? $name = $data->name : $erreur[] = "Nom obligatoire";
	isset($data->value) ? $value = $data->value : $erreur[] = "Valeur obligatoire";


	if(empty($erreur)){
	    $literal = Model::factory('Literal')->create();

	    $literal->name=$name;
	    $literal->value=$value;
	    $literal->locale= default_locale;

	    $literal->save();
	    echo json_encode($literal->toInfo());
	}

	if(!empty($erreur)){
	    $app->response()->status(400);
	    $app->response()->write(json_encode($erreur));
	}
}

function putLiteral($name)
{
	$app = Slim::getInstance();
	$data = $app->request()->getBody();
	$data = json_decode($data);

	if(!isset($name))throw new Exception("Literal introuvable");

	$erreur = array();

	$literal = Model::factory('Literal')->where('name',$name)->where('locale',default_locale)->find_one();

	if(!empty($literal)){
	    isset($data->name) ? $name = $data->name : $erreur[] = "Name obligatoire";
	    isset($data->value) ? $value = $data->value : $erreur[] = "Valeur obligatoire";

	    if(empty($erreur)){
	        $literal->name=$name;
	        $literal->value=$value;

	        $literal->save();
	        echo json_encode($literal->toInfo());
	    }
	}
	else{
	    $erreur[]= "Literal introuvable";
	}

	if(!empty($erreur)){
	$app->response()->status(400);
	$app->response()->write(json_encode($erreur));
	}
}
