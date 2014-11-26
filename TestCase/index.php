<?php
#create initial sessions 
include "logging.php";
include "run_test.php";
include 'ran_func.php';
session_start();

if (isset($_SESSION["filename"])==false)
	{
	$_SESSION["filename"]=create_log( );
	echo $_SESSION["filename"];
}

#$_SESSION['mac']
if (array_key_exists('Submit1', $_POST))
	{
		$len=strlen($_POST['mac']); #unknow reason there is extra space after engine address
		$engine_address=substr($_POST['mac'], 0, $len-2); #this delect last space 
		$_SESSION['mac']=$engine_address;
	}

#$_SESSION['Test_Cases']
if (isset($_SESSION['Test_Cases'])==false)
	{	$_SESSION['Test_Cases']='';
	}

#start case Number
if(isset($_SESSION['caseN'])==false)
{
	$_SESSION['caseN']=0;
}
#start case steps
if(isset($_SESSION['caseStep'])==false)
{
	$_SESSION['caseStep']=0;
}
#when back to Display_engine
if (array_key_exists('backToDisplay_engine', $_POST))
{
	unset($_SESSION['mac']);
	$_SESSION['Test_Cases']='';
	$_SESSION['caseStep']=0;
	$_SESSION['caseN']=0;
}
if (array_key_exists('backToTestMenu', $_POST))
{
	$_SESSION['Test_Cases']='';
	$_SESSION['caseStep']=0;
	$_SESSION['caseN']=0;
	unset($_SESSION["filename"]);
}

#when test case selected
# log is created
if (array_key_exists('run_test', $_POST))
{
	$_SESSION['Test_Cases']=$_POST['testCase'];
	$_SESSION["runTest"]="run";
	$_SESSION['caseStep']=0;
	$_SESSION['caseN']=0;
}
#$_SESSION["runTest"]
if(isset($_SESSION["runTest"])==False)
	{
	$_SESSION['Test_Cases']='';
	$_SESSION["runTest"]="run";
	}
	
//logging
if (array_key_exists("result",$_POST))
{
	$message= '
'.$_SESSION['Test_Cases'][$_SESSION['caseN']]." step ".$_SESSION['caseStep']." ".$_POST['result']."  ".$_POST['comments'];
	logging($_SESSION["filename"], $message );
}	
	

#///////////////////////////
#call out screens
#show display engine
if(isset($_SESSION['mac'])==False)
	{
	require_once ('functions.php');
	display_engine();	#this will display engine address and get $_POST['mac']
	}
	
	
#open test menu if no test_case
if(isset($_SESSION["mac"])==true and $_SESSION['Test_Cases']=="")
	{
		
		#$_SESSION['caseN']++;
		#echo "test meanu";
		include "TestMenu.php";
		TestMenu();
	}

#run test
if($_SESSION['Test_Cases']!='')
	{
	
	if ($_SESSION["runTest"]=="complete") 
		{	$_SESSION['caseStep']=0;
			$_SESSION['caseN']++;
			
		}
		
	if ($_SESSION["runTest"]=="next" or $_SESSION["runTest"]=="run")
		{
			$_SESSION["caseStep"]++;
		}
			
	$total_n_tesr_case= count($_SESSION['Test_Cases']);
	if ($total_n_tesr_case <= $_SESSION['caseN']) #show result
		{
			echo "display result";
			if (count($_SESSION['Test_Cases']) == $_SESSION['caseN'])
				{
					echo "display result";
					echo'
					<form method="post" id="test_flame_form"> 
					<br/>
					<br/>
					<input  type="submit" name="backToTestMenu" value="back to Test Menu" />
					</form> ';
					
				#display_result();
				}
		}
	else #run test screen
		{
			
			run_test();
		}
	
	}



#close window and close log

	
	
// #
echo "<br/><br/>-------------------------";
echo "<br/>mac: $_SESSION[mac]";
echo "<br/>Test_Cases: ";
print_r ($_SESSION['Test_Cases']);
 echo "<br/>caseN: $_SESSION[caseN]";
 echo "<br/>caseStep: $_SESSION[caseStep]";
 echo "<br/>runTest: $_SESSION[runTest]";
 echo "<br/>filename: $_SESSION[filename]";
# echo "<br/>$_SESSION[runTest]".$_SESSION['runTest'];




?>