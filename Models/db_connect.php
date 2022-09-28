
<?php
    class DataBase {
        private $HOST; 
        private $USER; 
        private $PASSWORD;   
        private $NAME;
        private $PORT;

        public function __construct(string $host, string $user, string $password, string $name, int $port) {
            $this->HOST = $host;
            $this->USER = $user;
            $this->PASSWORD = $password;
            $this->NAME = $name;
            $this->PORT = $port;
        }

        public function connectDatabase(){
            
            $connect = mysqli_connect($this->HOST, $this->USER, $this->PASSWORD,$this->NAME, $this->PORT);
            if(!$connect){
                return 'Error ' . mysqli_connect_error();
            } else {
                return $connect;
            }
        }
    }

    $_SERVER['RDS_HOSTNAME'] = "db2.cbbec9tmnqzq.eu-west-2.rds.amazonaws.com";
    $_SERVER['RDS_USERNAME'] = "root";
    $_SERVER['RDS_PASSWORD'] = "123AB123";
    $_SERVER['RDS_DB_NAME'] = "MySql2";
    $_SERVER['RDS_PORT'] = 3306;
    $db = new mysqli($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);




  
    // Set $_SERVER para in    Elastic Beanstalk -> Scandiwebtest-env -> Tags
    // $DataBase = new DataBase($_SERVER['RDS_HOSTNAME'], $_SERVER['RDS_USERNAME'], $_SERVER['RDS_PASSWORD'], $_SERVER['RDS_DB_NAME'], $_SERVER['RDS_PORT']);
    // $db = $DataBase->connectDatabase();    


?>