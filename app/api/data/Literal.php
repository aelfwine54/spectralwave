<?php
class Literal extends Model{
	public static $_table = 'cms_literals';
	public static $_id_column = 'literalId';

	private $literalId = 0;
	private $name = '';
	private $value = '';
	private $locale = '';



	public function toInfo(){
		$info = $this->as_array();
		return $info;
	}

	public static function getLiteral($name){
	    $literal = array();

	    $literal[] = Model::factory('Literal')->where('name',$name)->where('locale',default_locale)->find_one();

	    return $literal;
	}

	public static function postLiteral(){
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
        //echo json_encode($literal->toInfo());
    }

    if(!empty($erreur)){
        $app->response()->status(400);
        $app->response()->write(json_encode($erreur));
    }
}

}