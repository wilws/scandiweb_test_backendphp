<?php
    require_once("db_connect.php");
    require("create_table.class.php");


    // Create tables in MySql by making a Class with defind database attributes as below.
    // "Create function" is in the parent Class "Table" (create_table.class.php)


    Class ProductTable extends Table {

        protected $table_name = "ProductTable";
        protected $sku = 'VARCHAR(30) NOT NULL';
        protected $name = 'VARCHAR(30) NOT NULL';
        protected $price = 'FLOAT(9,2) NOT NULL';
        protected $productType  = 'VARCHAR(30) NOT NULL';
        protected $spec  = 'VARCHAR(250) NOT NULL';
    }


    // This page will be imported in controller to check if the `ProductTable` exist in MySql database. Create one if not

    $table_exist = mysqli_query($db,'select 1 from `ProductTable` LIMIT 1');
    if($table_exist == FALSE)  {
        new ProductTable("ProductTable",$db);          // The first arg is the name of the Class. It must be exactly the same as the class name.  
    }                                                  // The second arg is the instance of database from "db_connect.php". It gives connection for the parent class to 
                                                       //  access and create table in database
?>                                                     