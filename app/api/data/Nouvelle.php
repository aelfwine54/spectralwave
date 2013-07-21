<?php
class Nouvelle extends Model{
	public static $_table = 'nouvelles';
	public static $_id_column = 'newsId';


    public function toInfo(){
    	$info = $this->as_array();
    	$info['id'] = $info['newsId'];
    	unset($info['newsId']);

    	$jeu = Model::factory('Jeu')->find_one($info['jeuId']);
    	$info['nbComments'] = Model::factory('Commentaires_Nouvelle')->where('nouvelleId',$this->newsId)->count();
    	$info['jeu'] = $jeu->nom;

    	return $info;
    }

    public static function getNews($id){
        $news = array();
        if($id <=0)
        {
            $results = Model::factory('Nouvelle')->find_many();
            $news = array_merge($results,$news);
        }
        else{
            $news[] = Model::factory('Nouvelle')->find_one($id);
        }
        return $news;
    }
}
?>