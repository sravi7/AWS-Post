<?php
#get_json($mac,$name)  //get json file
#post_json($Json_file, $Json_name)  //this post the json file
#audio_name($name) //this read the name
#select_test_case()  //show select test case page
#test_result($message) //show page that ask enter result
#create_log( )
#logging($location, $message )
#close_log($location)

require_once 'functions.php';
#test values
global $test_values_in_an_array;
$test_values_in_an_array=array("new name","123456789","FFFFFFF","!@#$%^&*)");

function select_test_case(){
	#display_main_flame();
	if (isset($_SESSION['json_data']))		
	{
		$old_json=json_decode($_SESSION['json_data']);
		#echo "<p>" .var_dump($old_json)."</p>";
		$new_json = $old_json;
		if ( $_POST['run_test']='runtest' )
		{
			if(isset($_POST['testCase']))
			{
			foreach($_POST['testCase'] as $selected){
				echo $selected."</br>";
				$return=run_test_libaray($selected,$new_json);
			
				}
			#echo "<p>" .var_dump($old_json)."</p>";
			}
			else{ echo "no test case selected";}
			
		$_SESSION['json_data']=json_encode($new_json);
		}
	}
	// display_main_flame();
	display_json_files();
	display_main_flame();
	echo $return;
}

function display_main_flame()
{
	#display_json_files();
	echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'"><input type="Submit" name="start_beginning" value="Start from the First!!!!" /></form><br/><hr></form>';
	echo '	<div id="json_editor">
				<div id="json_form_left"><p style=\"font-size:30px;\">This is the <strong>""</strong> file for the engine with MAC address <strong>'.$_SESSION['engine_mac'].'</strong>.</p>
				<form id="editor" method="post" action="'.$_SERVER['PHP_SELF'].'">
				<textarea id="file_contents"  name="json_content">'.$_SESSION['json_data'].'</textarea><br/>		
				<input type="submit" value="Submit" name="Submit4"/>
				</form><br/></div>';
}

function run_test_libaray($testcase,$json)
{
		switch($testcase)
	{
		case "Change_name": 
			$json =change_name($json);
			post_json(json_encode($json));
			// $json->settings->data->bed_name="newname";
			$return = "name changed to: ".$json->settings->data->bed_name."<br/>";
			
			// return $return;
			#echo $json['settings']['data']['bed_name'];
			break;
		case 2: 
			echo "";
			break;
		case 3: 
			echo "";
			break;
		default:
			break;
	}
	
	return $return;
}
function get_json($mac,$name)
{
	$address="http://cdn.sealykelvin.com/id/".$mac."/".$name.".json";
	#echo $address;
	$json =file_get_contents($address);
	// echo $json;
	return json_decode($json);
}
function post_json($mac, $Json_name,$decode_Json)
{
	$Json=json_encode($decode_Json);
	
	// echo $Json;

	$result = file_get_contents('http://sealykelvin.com/endpoint/?id='.$mac, null, stream_context_create(array(
								'http' => array(
												'method' => 'POST',
												'header' => 'Content-Type: application/json' . "\r\n"
												. 'Content-Length: ' . strlen($Json) . "\r\n",
												'content' => $Json,
												),
	)));
}

function audio_name($name)
{
	echo '<audio autoplay>
			<source src="'.$name.'.mp3" type="audio/mpeg">
				Your browser does not support the audio element.
			</audio>';

}

function Show_case($testcase,$message='')
{
#print message
	echo $testcase;
	echo $message;
# show text box pass, fail, other chooice
	echo '
	<form id="editor" method="post" action="'.$_SERVER['PHP_SELF'].'">
	<textarea height:40px weight:120px  name="comments">comments: </textarea><br/>		
	<input type="submit" value="Pass" name="result"/>
	<input type="submit" value="Fail" name="result"/>
	';

}
	


?>