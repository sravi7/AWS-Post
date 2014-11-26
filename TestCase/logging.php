<?php
function create_log( )
{
	date_default_timezone_set('EST');
	$file = date('m_d_H_i_s').$_SESSION["mac"].'.log';
	$myfile = fopen($file, "w");
	$message = date('y_m_d_H_i_s').'---'.$_SESSION["mac"]."---test log";
	fwrite($myfile, $message );
	#echo $file;
	return $file;
}

function logging($location, $message )
{	
	$myfile = fopen($location, "a");
	fwrite($myfile, $message );}

function close_log($location)
	{	fclose($location);	}



?>