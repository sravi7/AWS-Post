<?php
function display_engine()
{
	$file_contents=file_get_contents("C:\\Apache24\\htdocs\\Kelvin_Engine_Wi-Fi\\engine.txt");
	
	if(!empty($file_contents))
	{
		//old $contents=str_split($file_contents, "\n");
		//ran 
		$contents=explode("\n",$file_contents);
		// print_r($contents);
		echo '<p style="font-size:30px;">Please select the engine you would like to work.</p>
				<form id="select_mac" method="post" action="'.$_SERVER['PHP_SELF'].'" style="font-size:20px;">
					<label>MAC Address of the engine</label><br/>';
		foreach($contents as $id=>$key)
		{
			echo '<input type="radio" name="mac" value="'.$key.'" id="get_mac_input'.$id.'"/><label for="get_mac_input'.$id.'">'.strtoupper($key).'</label><br/>';
		}
		echo '<input type="submit" name="Submit1" value="Submit"/></form><br/>';			
	}
	else
	{
		echo '<p>Please enter the MAC Address for the engine you would like to work.</p>
				<form id="get_mac" method="post" action="'.$_SERVER['PHP_SELF'].'">
					<label>MAC Address of the engine</label><input type="text" id="get_mac_input" name="engine_mac"/>
					<input type="submit" name="Submit2" value="Submit"/>
				</form>';			
	}
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
