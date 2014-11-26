<?php
foreach (glob('TestLibrary/*') as $filename)
{
    include $filename;
}

function run_test()
	{
		echo '<html><body>';
		echo "<br/>run test: ".$_SESSION['Test_Cases'][$_SESSION['caseN']].' step: '.$_SESSION['caseStep'];


		switch ($_SESSION['Test_Cases'][$_SESSION['caseN']]) 
			{
			case "Setting_Change_name":
				echo "<br/>--test change names<br/>";
				$_SESSION['runTest']=change_name($_SESSION['mac'],"settings",$_SESSION['caseStep']);
				break;
			case "Setting_Change_name2":
				echo "<br/>--test change name 2<br/>";
				$_SESSION['runTest']=change_name2($_SESSION['mac'],"settings",$_SESSION['caseStep']);
				break;
				break;
			case 3:
				echo 'case3';
				break;
			case 4:
				echo 'case4';
				break;
			}

		echo '
		<form method="post" id="test_flame_form"> 
		<br/>
		<br/>
		<input  type="submit" name="backToTestMenu" value="back to Test Menu" />
		</form> 
		<br/>';







	}





?>