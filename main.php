<?php	
# This is a PHP Script written for Testing the Kelvin Engines by posting it to the cloud.
# Author: Santosh Ravi
# Created on 10/27/2014

include 'header.php';
include 'functions.php';
session_start();
$_SESSION['link']="http://cdn.sealykelvin.com/id/";
$link=null;
if(array_key_exists('Submit1',$_POST))
{
	// old $_SESSION['engine_mac'] = $_POST['mac']; 
	#The next line of statement will remove the \r\n at the very end of the MAC address of the engine so that there is no space in the link.
	# Example: http://cdn.sealykelvin.com/id/0ABCDE /status.json  will be the link instead of http://cdn.sealykelvin.com/id/0ABCDE/status.json if the next line is not performed.
	$_SESSION['engine_mac']= strtoupper(preg_replace("/[\r\n]*/","",$_POST['mac']));
	
	echo '<p style="font-size:30px;">Please select the JSON file for the engine with MAC Address '.$_SESSION['engine_mac'].'</p>';
	display_json_files();
}
elseif(array_key_exists('Submit3', $_POST))
{
	if(array_key_exists('json', $_POST))
	{
		$_SESSION['json_file_name']=$_POST['json'];
		$_SESSION['link']=$_SESSION['link'].$_SESSION['engine_mac']."/".$_POST['json'];
		// echo "<h1>".$_SESSION['link']."</h1>";
		display_json_files();
		$link=file_get_contents($_SESSION['link']);
		$_SESSION['json_data']=$link;
		// $link=$link.$_SESSION['engine_mac'];	
		echo '<hr>';
		echo "<p style=\"font-size:30px;\">This is the <strong>".$_POST['json']."</strong> file for the engine with MAC address <strong>".$_SESSION['engine_mac']."</strong>.</p>";
		echo '<form id="editor" method="post" action="'.$_SERVER['PHP_SELF'].'">
				<textarea id="file_contents" rows=20% cols=90% name="json_content">'.$link.'</textarea><br/>		
				<input type="submit" value="Submit" name="Submit4"/>
		</form><br/>';	
	}
	else
	{
		echo 'Select one option';
		display_json_files();
	}
}
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
}
elseif(array_key_exists('Submit2', $_POST))
{
	if(array_key_exists('mac',$_POST))
	{
		$handle=fopen("C:\\Apache24\\htdocs\\Kelvin_Engine_Wi-Fi\\engine.txt", "a");
		$contents = fwrite($handle, $_POST['engine_mac']);
		fclose($handle);
		echo '<p style="font-size:30px;">Please select the JSON file for the engine with MAC Address '.$_POST['engine_mac'].'</p>';
		display_json_files();
	}
	else
	{
		echo 'Select one option';
		display_json_files();
	}
}
else
{
	display_engine();
}

echo '</div></body></html>'; 
