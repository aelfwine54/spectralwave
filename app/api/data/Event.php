<?php
class Event extends Model{
	public static $_table = 'events';
	public static $_id_column = 'id';


	public function toInfo(){
    	$info = $this->as_array();

    	if(isset($info['jeuId'])){
            $jeu = Model::factory('Jeu')->find_one($info['jeuId']);
            $info['jeu'] = $jeu->nom;
        }
    	$info['nbComments'] = Model::factory('Commentaires_Event')->where('eventId',$this->id)->count();
    	
    	return $info;
    }

    public static function getEvents($id){
    	$events = array();
    	if($id <=0)
    	{
    	    $results = Model::factory('Event')->find_many();
    	    $events = array_merge($results,$events);
    	}
    	else{
    	    $events[] = Model::factory('Event')->find_one($id);
    	}

    	return $events;
    }
}
?>