<?php
#include -> if missing, the program will run but get an error
#rewuire_one -> if missing, the program will halt, and will
#an error and will run the program below it (strict)
require_once "Database.php";

# note: the logic of ourapplication e.g. (CRUD - Create, Read, Update, Delete)
# will be in this class file
class User extends Database
{
    public function store($request)
    {
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username = $request['username'];
        $password = $request['password'];

        #apply hashing algorism
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        #SQL query string
        $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) VALUES('$first_name', '$last_name', '$username', '$hashed_password')";

        #execute the query string
        if ($this->conn->query($sql)) {
            header('location: ../views'); //go to index.php page
            exit;
        } else {
            die('Error in creating the user: ' . $this->conn->error);
        }
    }

    public function login($request)
    {
        $username = $request['username'];
        $password = $request['password'];

        # query atring
        $sql = "SELECT * FROM users WHERE username = '$username'";

        #get data from databases
        $result = $this->conn->query($sql);

        # check the username
        if ($result->num_rows == 1) {
            #check the password
            $user = $result->fetch_assoc();
            #$user = ['id' => 1, 'username' => 'john' ...];

            if (password_verify($password, $user['password'])) {
                #create a session variables for future use
                #temporary hold the universal data
                session_start();
                # use id in everwhere
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['fullname'] = $user['first_name'] . ' ' . $user['last_name']; //fullname will be reflected on dashboard.php

                //dashboad上部に値が反映される
                header('location:../views/dashboard.php');
            } else {
                die('pasword is incorrect');
            }
        } else {
            die('username does not exist');
        }
    }

    function logout()
    {
        session_start(); // start this to use session variables
        session_unset(); // execute this to unset the session variables set in the login method
        session_destroy(); //destroy removed the user to the login page

        header("location: ../views"); //redirect the user to the login page
        exit;
    }

    #retrieved all the users in the users table
    public function getAllUsers()
    {
        $sql = "SELECT id, first_name, last_name, username, photo FROM users";

        if ($result = $this->conn->query($sql)) {
            return $result;
        } else {
            die("Error in retrieving users." . $this->conn->error);
        }
    }

    #retrieved one user
    #note: $id is the id of the user we want to retrieve
    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id = $id";

        if ($result = $this->conn->query($sql)) {
            return $result->fetch_assoc();
        } else {
            dir("Error in retrieving one user." . $this->conn->error);
        }
    }

    public function update($request, $files)
    {
        session_start();
        $id = $_SESSION['id'];
        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username = $request['last_name'];

        #note: the file is handled differently
        //'photo' is the name of the input field from the form
        // 'name' --the name of the file
        $photo = $files['photo']['name'];
        //'photo' is the name of the input field from the form
        // 'tpm_name' refers to the temporary storage of our computer where the image is temporarily
        $photo_tmp =
            $files['photo']['tpm_name'];

        $sql = "UPDATE users SET first_name = '$first_name', last_name='$last_name', username = 'username' WHERE id=$id";

        if ($this->query($sql)) {
            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = "$first_name $last_name";

            #if there is an uploarded photo, save it to the db and save file to the images folder
            if ($photo) { //is it true that the user uploaded a photo?
                //then execute this
                $sql = "UPDATE users SET photo = '$photo' WHERE id ='$id'";
                //file destination folder
                $destination = "../assets/images/$photo";
                //execute the query above to save the image to the db, and move the uploarded file
                if ($this->conn->query($sql)) {
                    if (move_uploaded_file($photo_tmp, $destination)) {
                        header('location: ../views/dashboard.php');
                        exit;
                    } else {
                        die("Error in moving the photo");
                    }
                } else {
                    die("Error in uploarding photo: " . $this->conn->error);
                }
            }

            header('location: ../views/dashboard.php');
            exit;
        } else {
            die("Error in updatinig the user. " . $this->conn->error);
        }
    }
}
