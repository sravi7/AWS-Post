<?php
#last update 11/26 Ran
# 1 select a engine address 
# 2 display engine 6 json file
# 3 able to manual refresh json file 
# 4 able to log the json file if different
# 5 able to enable/disable auto reflash
# 6 able to high light which json file has updated text.
# 7 able to speak when json file has updated
# 8 save in logs in log folder
# 9- not implement yet- able to high light which value has been updated(font color = red)

#---pre condition for auto refresh------
$page = $_SERVER['PHP_SELF'];
if (isset($_SESSION["sec"])==false)
{	$_SESSION["sec"]= 360; }

#---make log dir--
if (!file_exists('log')) {
    mkdir('log', 0777, true);
}

#---header file------
echo '
<!DOCTYPE html>
	<html><head>
	<meta http-equiv="refresh" content="'.$_SESSION["sec"].'" URL='.$page.'">
		<style>
	html, body { 
		height: 100%;
	}
	#header {
		background-color:black;
		color:white;
		text-align:center;
		font-size: 150%;
    }
	#main_content{
		align=center;
	}

	#status { 
		background-color:#DDE2FB;
		height:45vh;
		width:33%;
		float:left;
				 
	}
	#settings {
		background-color:#B7C1FB;
		height:45vh;
		width:33%;
		float:left;
		 
	}
	#side-a {
		background-color:#8899FC;
		height:45vh;
		width:33%;
		float:left;
		  
	}
	#side-b {
		background-color:#A7F9FC;
		height:45vh;
		width:33%;
		float:left;
		  
	}

	#sleep-a {
		background-color:#6EDCDF;
		height:45vh;
		width:33%;
		float:left;
		  
	}
	#sleep-b {
		background-color:#4FCBD0;
		height:45vh;
		width:33%;
		float:left;
		  
	}
	#footer {
		background-color:black;
		color:white;
		clear:both;
		text-align:center;
		 }
		 
	#json_box{
		 height:90%;
		 width:auto;
		 overflow:scroll;
		 background-color:white;
		}	

	</style>
	</head>
	<body>

	<div id="main_content">';
	
// <?php
// $url=$_SERVER['REQUEST_URI'];
// header("Refresh: 5; URL=$url"); 
// ?>
