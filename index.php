<!DOCTYPE html>
<html>
	<head>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	</head>
	<body>
		<form action="card_game.php" method="post" id="player_form">
			<label for="">Number of player ?</label>
			<input type="text" id="number_of_player" name="number_of_player">
			<p><input type="submit" value="Go!"></p>
		</form>
		
		<div id="result">
			<h3></h3>
		</div>
		
		<script>
			$(document).ready(function(){
				$('#player_form').submit(function(event){
					event.preventDefault();
					var form  = $(this);
					var data = form.serialize();
					var url = form.attr('action');
					
					$(".player_deck").remove(); //reset player decks
					
					$.post(url, data, function(data){
						console.log(data.message);
						$('#result h3').html(data.message);
						$.each(data.result , function(key, value){
							$("#result").append('<p class="player_deck">'+value+'</p>');
						});
					}, 'json').fail( function(xhr, textStatus, errorThrown) {
						$('#result h3').html(xhr.responseJSON.message);
					});
				});
			});
		</script>
	</body>
</html>