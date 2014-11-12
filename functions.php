<?php
# This is a PHP Script written for Testing the Kelvin Engines by posting it to the cloud.
# Author: Santosh Ravi
# Created on 10/27/2014
# Update on 11.11.2014: In order to test for engine names, instead of restricting the number of characters to display to 6, the program performs a count on the number of elements 
#						in the array and then will display all the elements except the last element. This is because when you add a new engine in the text file, a new line character 
#						concatenated at the end. So while displaying the contents of the file, the new line is also displayed, which shouldn't happen. To avoid that, the above mentioned 
#						operation is performed.

function display_engine()
{
	if(file_exists("C:\\Apache24\\htdocs\\Kelvin_Engine_Wi-Fi\\engine.txt"))
	{
		$file_contents=file_get_contents("C:\\Apache24\\htdocs\\Kelvin_Engine_Wi-Fi\\engine.txt");
	}
	if(!empty($file_contents))
	{
		// $contents=str_split($file_contents, 6);
		//ran 
		$contents=explode("\n",$file_contents);
		$count=count($contents);
		$contents = array_splice($contents, 0, $count-1);
		echo '<p style="font-size:30px;">Please select the engine you would like to work.</p>
				<form id="select_mac" method="post" action="'.$_SERVER['PHP_SELF'].'" style="font-size:20px;">
					<label>MAC Address of the engine</label><br/>';
		foreach($contents as $id=>$key)
		{
			echo '<input type="radio" name="mac" value="'.$key.'" id="get_mac_input'.$id.'"/><label for="get_mac_input'.$id.'">'.strtoupper($key).'</label><br/>';
		}
		echo '<input type="submit" name="Submit1" value="Submit"/>
				<input type="submit" name="new_engine" value="New Engine"/>
				<input type="submit" name="delete_engine" value="Delete Engine"/></form><br/>';			
	}
	else
	{
		insert_new_engine();
	}
}

function insert_new_engine()
{
	echo '<p style="font-size:20px;">Please enter the MAC Address for the engine you would like to work.</p>
			<form id="get_mac" method="post" action="'.$_SERVER['PHP_SELF'].'">
				<label>MAC Address of the engine</label><input type="text" id="get_mac_input" name="engine_mac"/>
				<input type="submit" name="Submit2" value="Submit"/>
			</form>';			
}

function display_json_files()
{
	echo '<p style="font-size:20px;font-weight:bold">Select an option to proceed.</p>
		<form id="get_json" method="post" action="'.$_SERVER['PHP_SELF'].'" style="font-size:20px;">
			<input type="radio" name="json" value="status.json" id="json1"/><label for="json1">Status.json</label>
			<input type="radio" name="json" value="settings.json" id="json2"/><label for="json2">Settings.json</label>
			<input type="radio" name="json" value="side-a.json" id="json3"/><label for="json3">Side-a.json</label>
			<input type="radio" name="json" value="side-b.json" id="json4"/><label for="json4">Side-b.json</label>
			<input type="radio" name="json" value="sleep-a.json" id="json5"/><label for="json5">Sleep-a.json</label>
			<input type="radio" name="json" value="sleep-b.json" id="json6"/><label for="json6">Sleep-b.json</label><br/>
			<input type="submit" name="Submit3" value="Submit"/>
		</form><br/>';
}
