<?php

    class DataBase 
    {
        private $HOST; 
        private $USER; 
        private $PASSWORD;   
        private $NAME;
        private $PORT;

        public function __construct(string $host, string $user, string $password, string $name, int $port)
        {
            $this->HOST = $host;
            $this->USER = $user;
            $this->PASSWORD = $password;
            $this->NAME = $name;
            $this->PORT = $port;
        }

        public function connectDatabase()
        {
            $connect = mysqli_connect($this->HOST, $this->USER, $this->PASSWORD,$this->NAME, $this->PORT);
            if (!$connect) {
                return 'Error ' . mysqli_connect_error();
            } else {
                return $connect;
            }
        }
    }

  
    $DataBase = new DataBase($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
    $db = $DataBase->connectDatabase();
?>