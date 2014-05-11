<?php
/* Recepie maker class
 * Takes the input and looks for a recepie that can use the slected items
 * Author: Analee Gonzalez
*/

class Recepies {
	
	private $_fridgeConts = array();
	private $_recepiesRaw = '';
	private $_recepies = array();
	private $_posibiities = array();
	private $_dates = array();
	private $_diffIngridients = array();
	public $result;
	
	public function __construct(){
		$file = "scripts/json-recepies.js";
		$this->_recepiesRaw = file_get_contents($file);
		$this->_recepies = json_decode($this->_recepiesRaw,TRUE);	
	}
	
	public function getFridgeContent($data){
		//Explanation on why csv format is not used: If data was coming from a external file, csv format would be ideal to wor with as an easy way to read the infomration. Since the data needs to be transformed into an array, I thought it was pointless to transform it into csv when is already in array format. Avoiding this step makes the code more fast and efficient.
		
		$i = 0;
		foreach($data['ingridient'] as $val){
			if($data['useby'][$i] >= date('m/d/Y')){
				$this->_fridgeConts[$val] = array('amount' => (int)$data['amount'][$i], 'unit' => $data['unit'][$i], 'date' => $data['useby'][$i]);	
				$this->_dates[$data['useby'][$i]] = $val;
			}
			$i++;
		}
		
		ksort($this->_dates);
		
	}
	
	public function getRecepie(){
		foreach($this->_fridgeConts as $name => $ingridient){
			$itemNames[] = $name;
		}
		
		$hasIngridients = $this->searchbyIngridients($itemNames);
		
		//Checks how many recpies are returned as valid and looks for the one with the soonest use by date
		if(count($hasIngridients) > 1){
			foreach($hasIngridients as $option){
				foreach($option['ingridients'] as $ingridients){
					$onlyNames[] = $ingridients['item'];	
				}
			}
			
			//cleans the array to return only the differences
			$duplicateCount = array_count_values($onlyNames);
			foreach($duplicateCount as $name => $times){
				if($times == 1){
					$this->_diffIngridients[] = $name;	
				}
			}
			$diffIngridients = array_intersect($this->_dates, $this->_diffIngridients);
			reset($diffIngridients);
			$itemToUse = current($diffIngridients); 
			
			foreach($hasIngridients as $option){
				foreach($option['ingridients'] as $items){
					if($items['item'] == $itemToUse){
						$this->result = $option['name'];	
					}
				}
			}
			
		} else if(count($hasIngridients) == 0) {
			$this->result = 'There are no available recepies, please try with different ingridients.';
		} else {
			$this->result = $hasIngridients[0]['name'];	
		}
		
	}
	
	
	private function searchbyIngridients($items){
		foreach($this->_recepies as $key => $option){

			$ingridients = $option['ingridients'];
			$count = count($ingridients);
			$ingridientCount = 0;
			
			//Checks for the recepies that contain all the ingridients
			foreach($ingridients as $conts){
				$itemName = $conts['item'];
				$itemAmount = (int)$conts['amount'];
				$itemUnit = $conts['unit'];
				
				if(in_array($itemName,$items)){
					//check the amount and type
					if($this->_fridgeConts[$itemName]['amount'] >= $itemAmount && $this->_fridgeConts[$itemName]['unit'] == $itemUnit){
						$ingridientCount++;
					}
					
				}
			}
			
			if($ingridientCount == $count){
				$validRecepies[] = $option;	
			}
		}
			
		return $validRecepies;
	}
	
}
?>