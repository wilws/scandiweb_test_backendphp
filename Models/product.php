<?php
    require_once("db_connect.php");
    require("create_table.class.php");


    // Create Models in MySql by creating Class
    // Use static function to extract data once the model is created

    Class ProductTable extends Table {

        protected $table_name = "ProductTable";
        protected $sku = 'VARCHAR(30) NOT NULL';
        protected $name = 'VARCHAR(30) NOT NULL';
        protected $price = 'FLOAT(9,2) NOT NULL';
        protected $productType  = 'VARCHAR(30) NOT NULL';
        protected $spec  = 'VARCHAR(250) NOT NULL';
        // protected $dvd_size = 'FLOAT(9,2) NOT NULL';
        // protected $book_weight = 'FLOAT(9,2) NOT NULL';
        // protected $furniture_height = 'FLOAT(9,2) NOT NULL';
        // protected $furniture_width = 'FLOAT(9,2) NOT NULL';
        // protected $furniture_length = 'FLOAT(9,2) NOT NULL';

    }


    // Check if the table exist. Create one if not
    $table_exist = mysqli_query($db,'select 1 from `ProductTable` LIMIT 1');
    if($table_exist == FALSE)  {
        // var_dump('table not exist');   
        new ProductTable("ProductTable",$db);
    } 
?>