<?php

function TestMenu()
{
#--------header--------------
echo '
<!DOCTYPE html>
	<html><head>
		<style>
		span.tab{ padding: 30px;}

		#PageTile
		{
				width:100%;
				margin-left:auto;
				border:solid 1px black;
				text-align:center;
				margin-top: 2em;
				height:auto;
				background-color:#DFE1E8;
				font-family: "Lucida Bright",Georgia,serif;
			}
		#test_case_select_div
		</style>
		</head>	
		<body>
';
#-----body---------------

Echo'<div id="PageTile">
	<form method="post" id="goto"> 
	<input  type="submit" name="backToDisplay_engine" value="back to select engine" />
	---- Test menu for kevin  ---- select your test cases
	</form> 
	</div>
';

#test cases
#General
echo '<div id="test_case_select_div"><p style="font-size:20px;font-weight:bold">test case for General</p>
		<form method="post" id="test_flame_form" action="'.$_SERVER['PHP_SELF'].'" style="align:left;">
		<input type="checkbox" name="testCase[]" value="test case1" />test case1
		<input type="checkbox" name="testCase[]" value="test case2" />test case2
		<input type="checkbox" name="testCase[]" value="test case3" />test case3
		<input type="checkbox" name="testCase[]" value="test case4" />test case4
		<br/>';
		
#status
echo '<div id="test_case_select_div"><p style="font-size:20px;font-weight:bold">test case for status.json</p>
		
		<input type="checkbox" name="testCase[]" value="test case1" />status test case1
		<input type="checkbox" name="testCase[]" value="test case2" />status test case2 
		<input type="checkbox" name="testCase[]" value="test case3" />status test case3 
		<input type="checkbox" name="testCase[]" value="test case4" />status test case4 
		<br/>';
#settings
echo '<div id="test_case_select_div"><p style="font-size:20px;font-weight:bold">test case for settings.json</p>
		
		<input type="checkbox" name="testCase[]" value="Setting_Change_name" />Setting Change Name
		<input type="checkbox" name="testCase[]" value="Setting_Change_name2" />Setting Change Name2
		<input type="checkbox" name="testCase[]" value="Setting_test case3" />Setting_test case3
		<input type="checkbox" name="testCase[]" value="Setting_test case4" />Setting_test case4
		<br/>
		

		<input type="submit" name="run_test" value="Run Test"/>
		
		</form><br/></div></div>';






#-------end---------------
echo '</body></html>';
}

#TestMenu();
?>