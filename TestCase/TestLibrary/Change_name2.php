<?php

function change_name2($mac, $json_name, $caseN){

	$json_file = get_json($mac,$json_name);
	

	$test_values_in_an_array=array("new name","123456789","FFFFFFF","!@#$%^&*)");
	$length = count($test_values_in_an_array);

	$varble=$test_values_in_an_array[$caseN-1];

	echo $varble;
	$json_file->settings->data->bed_name=$varble;
	echo "<br/><br/>";
	#print_r ($json_file);
	post_json($mac,$json_name,$json_file);
	$test_case = "Setting.Json - Change name > new name <br/>";
	$Message = 'is engine name changed to "'.$varble.'"?';
	Show_case($test_case, $Message);
	
	if( $caseN >= $length)
		{return "complete";}
	else
		{return "next";}


	}
	

	
	
			
?>