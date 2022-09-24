 <?php   
    Class Table {

        protected $table_name = "";
        protected $db;
        protected $id = 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY';
        protected $create_time = 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';


        public function __construct(string $table_name, object $db) {
            
            $this->table_name = $table_name;
            $this->db = $db;
            $this->createCommend();
        }

        protected function createTable(string $sql){

            if (mysqli_query($this->db, $sql)  === TRUE) {
                echo "Table Created successfully";
            } else {
                echo "Error creating table: ";
                mysqli_error($this->db->error);
            }
        }


        protected function createCommend(){
            
            $ReflectionClass = new ReflectionClass($this->table_name);
            $property_arr = $ReflectionClass->getProperties();
            $_sql = "CREATE TABLE ".$this->table_name." ( ";
            foreach($property_arr as $key){
                $name = $key->getName();         // Get all the properties'name
                if ($name === "table_name"){     // Except the table_name
                    continue;
                }
                if ($name === "db"){                    // Except the db instance
                    continue;
                }
                $setting = '';
                eval('$setting = $this->'.$name.';');  // And all the properties' data
                $_sql .= $name." ".$setting.",";    
            
            }
            $sql = rtrim($_sql, ",");        // remove the final ","
            $sql .= " )";
            $this->createTable($sql);
        }
    }
?>