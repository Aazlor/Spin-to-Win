<?

if($_POST[winner] == 'yes'){
}
elseif($_POST[get_odds] == 'yes'){
	/***** CONFIGURATION VARIABLES *****/
	$total_prizes_to_give_out = 25;
	// $total_prizes_to_give_out = 5;
	$event_length = 60*60*6;
	// $event_length = 60;

	/***** EVERYTHING ELSE ******/

	$spin_data = unserialize(file_get_contents('win_tracking.txt'));

	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	$spin_data = unserialize(file_get_contents('win_tracking.txt'));

	if($spin_data[start_time] == '' || $spin_data[date] != date('Y-m-d')){
		$spin_data[winner_count] = 0;
		$spin_data[start_time] = microtime_float();
		$spin_data[date] = date('Y-m-d');
		file_put_contents('win_tracking.txt', serialize($spin_data));
	}

	if($total_prizes_to_give_out > $spin_data[winner_count]){
		$current_time = microtime_float();

		$interval = $event_length / $total_prizes_to_give_out;
			
		$number_of_intervals = floor(floor($current_time - $spin_data[start_time]) / $interval);

		if($number_of_intervals > 1){
			$odds = rand(1,4);
		}
		else{
			$odds = rand(1,100);
		}
	}
	elseif($total_prizes_to_give_out <= $spin_data[winner_count]){
		$odds = 404;
	}

	if($odds == 1){
		$spin_data[winner_count]++;
		file_put_contents('win_tracking.txt', serialize($spin_data));
	}

	echo $odds;	
}

?>