<?php
include "../classes/User.php";

// instantiate an object
$user = new User;

//call the update method
$user->update($_POST, $_FILES);
# the $_POST --- holds the like the  first_name, last_name and username
# the $_FILE --- holds the file(image file) uploarded from the form
