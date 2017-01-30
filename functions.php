<?php
function database()
{
	$link = mysqli_connect('localhost', 'username', 'password', 'teamhier_dbs');
	if(!$link)
	{
		echo "Error: Unable to connect to databse";
		exit;
	}
	else {
		//echo "Successfully connected to the Database!";
		return $link;
	}
	
}

function episodeCount()
{
	$episodeCount = glob('resources/media/*.mp4');
	foreach ($episodeCount as $file => $value)
	{
		$count++;
	}
	echo $count;
}

function episodeSynop($episodeNumber)
{
	$link = database();
	$query = 'SELECT * FROM `synopsis` WHERE `id` = '.$episodeNumber;
	//echo "<br />".$query;
	if($result = mysqli_query($link,$query) or die ('Query Failed')) {
		while ($row = mysqli_fetch_row($result)) {
			echo "<strong>Episode #</strong>: ".$row[0]."<br />";
			echo "<strong>Title</strong>: ".$row[1]."<br />";
			echo "<strong>Date Released</strong>: ".$row[2]."<hr>";
			echo "<strong>Synopsis</strong>: ".$row[3]."<br/><br/>^From Wikipedia";
		}
		mysqli_free_result($result);
	} else {
		echo "<br />The informatino you are looking for has not been added yet! " . mysqli_error($link);
	}
	mysqli_close($link);
}

?>
