<?php
class Database
{
    #define properties
    private $server_name = "localhost";
    private $username = "root"; //username by default
    private $password = ""; //default is empty
    private $db_name = "the_company";
    protected $conn;

    #define the constractor 
    public function __construct()
    {
        //objectを新規作成するときに自動実行される
        $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);
        //built-in class file
        //note: in mysqli() it also have properties and methods that we can call in order to use it.

        if ($this->conn->connect_error) {
            die("Unable to connect to the database." . $this->conn->connect_error);
        }
    }
}
