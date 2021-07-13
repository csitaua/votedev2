<?php

require_once('validation.class.php');

$obj = new validation();

$obj->add_fields($_POST['uname'], 'req', 'Please Enter Username');
$obj->add_fields($_POST['uname'], 'username', 'Please enter valid Username');
$obj->add_fields($_POST['uname'], 'min=4', 'Username should be atleast 4 characters long');
$obj->add_fields($_POST['uname'], 'max=25', 'Username should not be more than 25 characters long');

$obj->add_fields($_POST['fname'], 'req', 'Please Enter First Name');
$obj->add_fields($_POST['fname'], 'name', 'Please Enter valid First Name');

$obj->add_fields($_POST['lname'], 'req', 'Please Enter Last Name');
$obj->add_fields($_POST['lname'], 'name', 'Please Enter valid Last Name');

$obj->add_fields($_POST['gender'], 'req', 'Please select Gender');

$obj->add_fields($_POST['bdate'], 'req', 'Please Enter Birth Date');
$obj->add_fields($_POST['bdate'], 'date=dd.mm.yy,dd/mm/yy,dd/mm/yyyy', 'Invalid Date Format');

$obj->add_fields($_POST['age'], 'req', 'Please select Age Range');
$obj->add_fields($_POST['age'], 'lte=1', 'Select Only 1 Age Range');

$obj->add_fields($_POST['password'], 'req', 'Password Required');
$obj->add_fields($_POST['password'], 'min=4', 'Enter Password atleast 4 characters long');
$obj->add_fields($_POST['password'], 'max=25', 'Password should not be more than 25 characters long');

$obj->add_fields($_POST['address'], 'req', 'Enter Address');
$obj->add_fields($_POST['address'], 'address', 'Please Enter valid Address');
$obj->add_fields($_POST['address'], 'max=200', 'Address should not be more than 200 characters long');

$obj->add_fields($_POST['zip'], 'req', 'Zip Code Required');
$obj->add_fields($_POST['zip'], 'zip', 'Invalid Zip code');
$obj->add_fields($_POST['zip'], 'uszip', 'Invalid Zip code');
$obj->add_fields($_POST['zip'], 'ukzip', 'Invalid Zip code');
$obj->add_fields($_POST['zip'], 'max=10', 'Zip code should not be more than 10 characters long');

$obj->add_fields($_POST['email'], 'req', 'Please Enter Email Address');
$obj->add_fields($_POST['email'], 'email', 'Enter valid Email Address');

$obj->add_fields($_POST['homephone'], 'req', 'Please Enter Phone No.');
$obj->add_fields($_POST['homephone'], 'phone=in,us', 'Invalid Phone Number');
$obj->add_fields($_POST['homephone'], 'max=20', 'Phone Number should not be more than 20 characters long');

$obj->add_fields($_POST['mob'], 'req', 'Please Mobile No Required');
$obj->add_fields($_POST['mob'], 'mobile', 'Invalid Mobile No');
$obj->add_fields($_POST['mob'], 'max=20', 'Mobile No. should not be more than 20 characters long');

$obj->add_fields($_POST['country'], 'req', 'Select Country');
$obj->add_fields($_POST['country'], 'lte=2', 'Select atmost 2 Countries');

$obj->add_fields($_FILES['image1'], 'req', 'Please Upload file');
$obj->add_fields($_FILES['image1'], 'ftype=jpg,gif,bmp', 'Invalid File Type');
$obj->add_fields($_FILES['image1'], 'fsize=500', 'File size is not more than 500b');
$obj->add_fields($_FILES['image1'], 'imgwh=100,100', '100x100 Image Resolution Required.');

$obj->add_fields($_FILES['file1'], 'req', 'Please Upload file');
$obj->add_fields($_FILES['file1'], 'ftype=txt,xml,csv,zip,tar,ctar,xls', 'Invalid File Type');
$obj->add_fields($_FILES['file1'], 'fsize=1048576', 'File size is not more than 1MB');

$obj->add_fields($_FILES['resume'], 'req', 'Please Upload Resume');
$obj->add_fields($_FILES['resume'], 'ftype=doc,pdf', 'Invalid File Type');

$error = $obj->validate();

if($error){
	echo "<font color='#FF0000' family='verdana' size=2>".$error."</font>";
}
else{
	echo "No Error...";
}

?>