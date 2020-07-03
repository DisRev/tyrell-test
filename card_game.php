<?php

class Card_game{

	function create_deck(){
		$card_deck = array();//initialize the card deck
		
		//creating card deck with all cards
		for($i = 1; $i <= 4; $i++){
			for($j = 1; $j <= 13; $j++){
				$card = $this->get_card_family_number($i, $j);
				array_push($card_deck, $card);
			}
		}
		
		shuffle($card_deck); //shuffle the card deck
		
		return $card_deck;
	}
	
	function get_card_family_number($family_number, $card_number){
		//using switch to determine the card family
		switch($family_number){
			case 1:
			$card_family = 'S';
			break;
			
			case 2:
			$card_family = 'H';
			break;
			
			case 3:
			$card_family = 'D';
			break;
			
			case 4:
			$card_family = 'C';
			break;
		}
		
		//if card number fall outside 2 and 9, use switch to find out their value, else just return as it is
		if($card_number < 2 || $card_number > 9){
			switch($card_number){
				case 1:
					$card_value = 'A';
				break;
				
				case 10:
					$card_value = 'X';
				break;
				
				case 11:
					$card_value = 'J';
				break;
				
				case 12:
					$card_value = 'Q';
				break;
				
				case 13:
					$card_value = 'K';
				break;
			}
		}else{
			$card_value = $card_number; //return as it is
		}
		
		return $card_family.'-'.$card_value;
	}
	
	function distribute_card($number_of_player = null){
		
		$result = array(
			'code' => 500,
			'message' => 'Irregularity occurred'
		);
		
		try{
			//check if number of player is not null/ empty, numeirc and player number at least 1, the rest would be invalid, inclusive 0 players
			if($number_of_player && is_numeric($number_of_player) && $number_of_player > 0){
				$result = array();
				$card_deck = $this->create_deck();
				$player_cards = array_fill(0 , $number_of_player , array());
				$total_cards = count($card_deck);
		
				$counter = 0;

				while($counter < $total_cards){
					$player_number = $counter % $number_of_player; // determine whose turn to receive card by using remainder...example 5th card % 4 player = first player should get the card
					array_push($player_cards[$player_number], $card_deck[$counter]); //push or deliver the card to players
					
					$counter ++;
				}
				
				foreach($player_cards as $key=> $pc){
					$player_cards[$key] = implode(', ' , $pc); //glue/implode all cards with comma
				}
				
				$result['code'] = 200;
				$result['result'] = $player_cards;
				$result['message'] = 'Enjoy your game!';
			}else{
				$result['code'] = 500;
				$result['message'] = 'Input value does not exist or value is invalid';
			}
			
			header('Content-type: application/json'); //set the content type
			http_response_code($result['code']); //set http response code so it can be more accurately handle by jquery side
			
			echo json_encode($result);
			
		}catch (Exception $e) {
			header('Content-type: application/json');
			http_response_code($result['code']);
			
			echo json_encode($result);
		}
	}
}

	$card_game = new Card_game();
	
	$test = $card_game->distribute_card($_POST['number_of_player']); //let the game begin
?>