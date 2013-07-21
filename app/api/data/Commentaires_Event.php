<?php
class Commentaires_Event extends Model{
	public static $_table = 'commentaires_events';
	public static $_id_column = 'id';


 public function toInfo(){
    	$info = $this->as_array();

    	return $info;
    }
}
?>