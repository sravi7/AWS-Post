<?php	
# This is a PHP Script written for Testing the Kelvin Engines by posting it to the cloud.
# Author: Santosh Ravi
# Created on 10/27/2014
# Update on 11.11.2014: Changed the "Submit2" case where the if condition will be looking for "engine_mac", which was previously "mac".
#
# Update on 11.11.2014: Changed the "Submit2" case where instead of just submitting the engine's MAC address, the MAC address is concatenated with a new line character so that 
#						testing can be performed with 6 or more characters.
#
# Update on 11.12.2014: 1. Changed the "Submit4" case, where after submitting the data to the cloud, the user is given two options,i.e., 
#							(a) To work with the same engine, 
#							(b) To work with a different engine.
#			Depending upon the user action, the respective actions would take place.
#			2. Created an option to delete the engine from the "engine.txt" file if the user decides that the engine is not required.
#			3. Updated the "Submit2". This code will check if the user has entered any value in the text field or not. If no value is entered, then the user will be 
#							asked to enter a value.
#			4. Added a new feature where the user can reset and start from the beginning, irrespective of the page where there are working.

include 'header.php';
include 'functions.php';

session_start();
$_SESSION['link']="http://cdn.sealykelvin.com/id/";
$link=null;

# This condition adds the engines MAC to the "SESSION" variable and then displays the list of JSON files.
if(array_key_exists('Submit1',$_POST))
{
	// old $_SESSION['engine_mac'] = $_POST['mac']; 
	# The next line of statement will remove the "\r\n" at the very end of the MAC address of the engine so that there is no space in the link.
	# Example: http://cdn.sealykelvin.com/id/0ABCDE /status.json  will be the link instead of http://cdn.sealykelvin.com/id/0ABCDE/status.json if the next line is not performed.
	$_SESSION['engine_mac']= strtoupper(preg_replace("/[\r\n]*/","",$_POST['mac']));
	
	echo '<p style="font-size:30px;">Please select the JSON file for the engine with MAC Address '.$_SESSION['engine_mac'].'</p>';
	display_json_files();
	echo '<form method="post" action="http://localhost/Kelvin_Engine_Wi-Fi/Testing_Code/main.php"><input type="Submit" name="start_beginning" value="Start from the First!!!!" /></form><br/>';
}

# In this case, the new engine's MAC address is written to the file.
elseif(array_key_exists('Submit2', $_POST))
{
	if(strlen($_POST['engine_mac'])!=0)
	{
		$handle=fopen("C:\\Apache24\\htdocs\\Kelvin_Engine_Wi-Fi\\engine.txt", "a");
		fwrite($handle, $_POST['engine_mac'].PHP_EOL);
		fclose($handle);
		echo '<p style="font-size:30px;">Please select the JSON file for the engine with MAC Address '.strtoupper($_POST['engine_mac']).'</p>';
		display_json_files();
		echo '<form method="post" action="http://localhost/Kelvin_Engine_Wi-Fi/Testing_Code/main.php"><input type="Submit" name="start_beginning" value="Start from the First!!!!" /><br/></form>';
	}
	else
	{
		echo '<p style="font-size:30px;">You have not entered any value. Kindly enter a value.</p>';
		insert_new_engine();
	}
}

# This is the place where the contents of the JSON file is displayed. The user can work with this file or can select a different JSON file.
elseif(array_key_exists('Submit3', $_POST))
{
	if(array_key_exists('json', $_POST))
	{
		$_SESSION['json_file_name']=$_POST['json'];
		$_SESSION['link']=$_SESSION['link'].$_SESSION['engine_mac']."/".$_POST['json'];
		// echo "<h1>".$_SESSION['link']."</h1>";
		// $link=file_get_contents($_SESSION['link']);
		$_SESSION['json_data']=file_get_contents($_SESSION['link']);
		// $_SESSION['json_data']=$link;
		// $link=$link.$_SESSION['engine_mac'];	
		display_json_files();
		echo '<form method="post" action="http://localhost/Kelvin_Engine_Wi-Fi/Testing_Code/main.php"><input type="Submit" name="start_beginning" value="Start from the First!!!!" /></form><br/>';
		echo '<hr>';
		echo "<p style=\"font-size:30px;\">This is the <strong>".$_POST['json']."</strong> file for the engine with MAC address <strong>".$_SESSION['engine_mac']."</strong>.</p>";
		echo '<form id="editor" method="post" action="'.$_SERVER['PHP_SELF'].'">
				<textarea id="file_contents" rows=20% cols=90% name="json_content">'.$_SESSION['json_data'].'</textarea><br/>		
				<input type="submit" value="Submit" name="Submit4"/>
		</form><br/>';	
	}
	else
	{
		echo '<p style="font-size:30px;">Please make a selection.</p>';
		display_json_files();
		echo '<form method="post" action="http://localhost/Kelvin_Engine_Wi-Fi/Testing_Code/main.php"><input type="Submit" name="start_beginning" value="Start from the First!!!!" /></form><br/>';
	}
}

# This case submits the data to the cloud.
elseif(array_key_exists('Submit4', $_POST))
{
	$data_string = $_POST['json_content'];
	$result = file_get_contents('http://sealykelvin.com/endpoint/?id='.$_SESSION['engine_mac'], null, stream_context_create(array(
								'http' => array(
												'method' => 'POST',
												'header' => 'Content-Type: application/json' . "\r\n"
												. 'Content-Length: ' . strlen($data_string) . "\r\n",
												'content' => $data_string,
												),
	)));
	echo '<p style="font-size:25px;"> Data has been submitted to change the contents of <strong>'.$_SESSION['json_file_name'].'</strong> file for the engine with MAC address <strong>'.$_SESSION['engine_mac'].'</strong>.</p>';
	display_json_files();
	echo '<form method="post" action="http://localhost/Kelvin_Engine_Wi-Fi/Testing_Code/main.php"><input type="Submit" name="start_beginning" value="Start from the First!!!!" /></form><br/>';
}

# This case kicks in when the user decides to work with a different engine after submitting data to the cloud.
elseif(array_key_exists('start_beginning', $_POST))
{
	session_destroy();
	display_engine();
}

# This is condition kicks the form where the user can add a new engine.
elseif(array_key_exists('new_engine',$_POST))
{
	insert_new_engine();
}

# This option is selected when the user selects the engine they want to be deleted.
elseif(array_key_exists('delete_engine', $_POST))
{
	$file_contents=file_get_contents("C:\\Apache24\\htdocs\\Kelvin_Engine_Wi-Fi\\engine.txt");
	$file_contents=str_replace($_POST['mac'],'', $file_contents);
	file_put_contents("C:\\Apache24\\htdocs\\Kelvin_Engine_Wi-Fi\\engine.txt", $file_contents);
	display_engine();
}

 else
{
	display_engine();
}
