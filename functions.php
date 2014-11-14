<?php
# This is a PHP Script written for Testing the Kelvin Engines by posting it to the cloud.
# Author: Santosh Ravi
# Created on 10/27/2014
# Update on 11.11.2014: In order to test for engine names, instead of restricting the number of characters to display to 6, the program performs a count on the number of elements 
#						in the array and then will display all the elements except the last element. This is because when you add a new engine in the text file, a new line character 
#						concatenated at the end. So while displaying the contents of the file, the new line is also displayed, which shouldn't happen. To avoid that, the above mentioned 
#						operation is performed.
# Update on 11.14.2014: 1. Added the "start_beginning" form action inside the display_json_files() functions.
#			2. Added 2 new form actions. Their usage are as below:
#				(a) The "change_sequence_number()" function is the form where the user is given the option to enter the sequence number or directly increment by 1.
#				(b) The "update_sequence_number()" function is to update the sequence number in the JSON file. The function updates the sequence number and
#				then displays the data to the user before submitting it to the cloud.

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
	echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'"><input type="Submit" name="start_beginning" value="Start from the First!!!!" /></form><br/><hr>';
}

function display_json_data()
{
	echo '	<div id="json_editor"><div id="json_form_left"><p style=\"font-size:30px;\">This is the <strong>"'.$_SESSION['json_file_name'].'"</strong> file for the engine with MAC address <strong>'.$_SESSION['engine_mac'].'</strong>.</p><br/>';
	change_sequence_number();
	echo '<form id="editor" method="post" action="'.$_SERVER['PHP_SELF'].'">
			<textarea id="file_contents" rows=20% cols=90% name="json_content">'.$_SESSION['json_data'].'</textarea><br/>		
			<input type="submit" value="Submit" name="Submit4"/></form><br/></div>';
}

function change_sequence_number()
{
	$session_json_data=json_decode($_SESSION['json_data']);
	// var_dump($session_json_data);
	/* $contents=array();
	foreach($session_json_data as $name=>$value)
	{
		$contents[$name]=$value;
	}
	
	print_r($contents); */
	// var_dump($contents['settings']['header']['sequence']);
	echo '<form id="editor" method="post" action="'.$_SERVER['PHP_SELF'].'">
			<label>Change the sequence number here</label><input type="text" name="sequence_number" value="'.$session_json_data->settings->header->sequence.'"/>
			<input type="submit" value="Submit" name="Submit_Sequence_Number"/>
			<input type="submit" value="Increment by 1" name="Submit_Increment_1"/>
			</form><br/>';
	// echo $session_json_data->settings->header->sequence;
}

function update_sequence_number()
{
	$session_json_data=json_decode($_SESSION['json_data']);
	$session_json_data->settings->header->sequence=((array_key_exists('Submit_Sequence_Number',$_POST))?$_POST['sequence_number']:($_POST['sequence_number']+1));
	$_SESSION['json_data']=json_encode($session_json_data);
	display_json_files();
	display_json_data();
}
