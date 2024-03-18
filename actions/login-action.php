<?php
include "../classes/User.php";

#create/instantiate an object
$user = new User;

#call the method
$user->login($_POST);
//$_POST->will hold the data coming from the registration form 
// ex: $_POST['first-name'] = John;
