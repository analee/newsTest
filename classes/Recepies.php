<?php
/* Recepie maker class
 * Takes the input and looks for a recepie that can use the slected items
 * Author: Analee Gonzalez
*/

class Recepies {
	
	private $_fridgeConts = array();
	private $_recepiesRaw = '';
	private $_recepies = array();
	public $result;
	
	public function __construct(){
		$file = "scripts/json-recepies.js";
		$this->_recepiesRaw = file_get_contents($file);
		$this->_recepies = json_decode($this->_recepiesRaw,TRUE);	
	}
	
	public function getFridgeContent($data){
		
	}
	
	public function searchRecepie(){
		
	}
}
?>