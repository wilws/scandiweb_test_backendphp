 <?php   

    //  This is the Class that use for creating table in database.

    Class Table {

        protected $table_name = "";                                                                         // The child class name as well as the table name in database.
        protected $db;                                                                                      // Instance of database for Mysql connection
        protected $id = 'INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY';                                       // Create Id colnum statement, for construct a sql statement
        protected $create_time = 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';         // Create create_time colnum statement, for construct a sql statement


        public function __construct(string $table_name, object $db) {
            
            $this->table_name = $table_name;
            $this->db = $db;
            $this->createCommend();                                                     // Construct sql `Create Table` commend 
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
            
            $ReflectionClass = new ReflectionClass($this->table_name);                    // Look up the properties in child
            $property_arr = $ReflectionClass->getProperties();                            // Get the properties and the colnum attributes
            $_sql = "CREATE TABLE ".$this->table_name." ( ";                               
            foreach($property_arr as $key){
                $name = $key->getName();                                                  // Extract the properties'name
                if ($name === "table_name"){                                              // Except the table_name
                    continue;
                }
                if ($name === "db"){                                                      // Except the db instance
                    continue;
                }
                $setting = '';                                                            // To store the attributes
                eval('$setting = $this->'.$name.';');                                     // Use eval to extraact attribute defined in child 
                $_sql .= $name." ".$setting.",";    
            
            }
            $sql = rtrim($_sql, ",");                                                     // remove the last ","
            $sql .= " )";
            $this->createTable($sql);
        }
    }
?>