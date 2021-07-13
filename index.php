<?php
$error = $_REQUEST['error'];
error_reporting(E_ALL);
ini_set('display_errors', '1');
include "support/deleteold.php";
removeold();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles/output.css" />
<title>CPVR Voting Registration</title>
</head>
<body class="font-sans antialiased p-10">
<div class="min-h-0 bg-blue-100 p-4 mx-auto w-4/6">
<form name="votereg" action="getballot.php" method="post">
	<div class="grid grid-cols-4 gap-2">
		<div><img src="img/cpvr.png" width="125"/></div>
		<div class="col-span-3 md:text-1xl lg:text-4xl text-center">Voter Registration</div>
		<div>&nbsp;</div>
		<div class="md:text-sm lg:text-base">Ballot Code:</div>
		<div class="col-span-2"><input type="text" name="ballot" maxlength="10" /></div>
		<div>&nbsp;</div>
		<div>Last Name:</div>
		<div class="col-span-2"><input type="text" name="lname" /></div>
		<div>&nbsp;</div>
		<div>&nbsp;</div>
		<div class="col-span-2"><input type="submit" value="Submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" /></div>
		<?php
		if ($error == 1){
			echo '<div>&nbsp;</div>
						<div>&nbsp;</div>
						<div class="col-span-2 text-red-500">Please Checked information entered and try again</div>';
		}
	?>
	</div>
</form>
</body>
</div>
</html>
