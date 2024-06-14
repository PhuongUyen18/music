<?php 
    class Database{
        protected $conn;

        function __construct()
        {
            $this->conn =  new mysqli("localhost","root","","music_streamer");
            if($this->conn->connect_error){
                die("Connecting error".$this->conn->connect_error);
            }
        }
    }

?>