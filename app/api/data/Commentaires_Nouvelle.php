<?php
class Commentaires_Nouvelle extends Model{
	public static $_table = 'commentaires_news';
	public static $_id_column = 'id';


 public function toInfo(){
    	$info = $this->as_array();

    	return $info;
    }
}
?>