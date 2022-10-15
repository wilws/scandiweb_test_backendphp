<?php
    require_once PATH .'/Models/database.php';
    require_once PATH .'/Models/model.php';

    
    Class ProductModel extends Model
    {
        protected string $sku = 'VARCHAR(30) NOT NULL';
        protected string $name = 'VARCHAR(30) NOT NULL';
        protected string $price = 'FLOAT(9,2) NOT NULL';
        protected string $productType  = 'VARCHAR(30) NOT NULL';
        protected string $spec  = 'VARCHAR(250) NOT NULL';

        public function __construct(object $db)
        {
            if(mysqli_query( $db,'select 1 from `ProductTable` LIMIT 1') == FALSE )  {     // If table no exist in db, create one.
               parent::__construct( "ProductTable" , $db);                                 // The first arg is the name of the Class. It must be exactly the same as the class name.  
            }                                                                            
            $this->db = $db;                                                                                                                                             
        }                                                                                

        public function createProduct(string $skuValue,string $nameValue, float $priceValue, string $typeValue, string $specValue) : bool 
        {
            $statement = $this->db->prepare("INSERT INTO ProductTable (sku, name, price, productType, spec ) VALUES (?, ?, ? , ?, ?)");
            $statement->bind_param("ssdss", $skuValue,$nameValue,$priceValue,$typeValue,$specValue);
            return $statement->execute();
        }

        public function getProducts() : array 
        {            
            $statement = "SELECT * FROM ProductTable";
            $fetch = $this->db->query($statement);
            return $fetch->fetch_all(MYSQLI_ASSOC) ?? [];   #MYSQLI_ASSOC = key-value pair
        }

        public function deleteProducts(array $ids) : bool 
        {   
            $idString = join(",",$ids);
            $statement = $this->db->prepare("DELETE FROM ProductTable where id in ($idString)");
            return $statement->execute();
        }
    }
?>                                                     