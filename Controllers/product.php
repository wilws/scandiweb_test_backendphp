<?php
require("./Models/product.php");
require_once("./Helper/json_response_formatter.php");
require("./Middlewares/validator.php");

class Product {

    // GET /product/get-products
    public static function getProducts(array $params, array $json_content, object $db) : string {
        
        $sql = "SELECT * FROM ProductTable";
        $fetch = $db->query($sql);
        $records = $fetch->fetch_all(MYSQLI_ASSOC) ?? [];   #MYSQLI_ASSOC = key-value pair

        if (count($records)> 0){
            $sanitised_output = [];
            foreach ($records as $arr ){
                array_push($sanitised_output,Validator::outputSanitisation($arr));
            }
            $result = jsendFormatter('success',$sanitised_output);
        } else {
            $result = jsendFormatter('error', [$db -> error]);
        }
        return $result ;
    }


    // DELETE /product/get-product/{id}
    public static function getProduct(array $params, array $json_content, object $db) : string{
        // { code here }
        return "getProduct";         
    }




    // POST /product/create-product
    public static function createProduct(array $params, array $json_content, object $db) : string {

        // Implement middleware to validate the data in $json_content
        $input_check = Validator::createProductCheck($json_content);
        if(!$input_check['validation']){
            return jsendFormatter("error",[rtrim($input_check['error_msg'], ";")]);     // exit function if validation is failed
        }


        // Construct MySql statement of create record. 
        $ReflectionClass = new ReflectionClass("ProductTable");          // Get all the properties'name from the model
        $property_arr = $ReflectionClass->getProperties();               
        
        $_cmd = "INSERT INTO ProductTable (";                         // construct the first part of the statement
        $_val = " VALUES (";                                          // construct the value part of the statement
    
        foreach($property_arr as $key){
            $name = $key->getName();                     // extract the properties'name from ReflectionClass object
            if ($name === "table_name"){continue;}       // no processing on data of "table_name"
            if ($name === "db"){continue;}               // no processing db instance
            if ($name === "id"){continue;}               // no processing on data of id. It will be handled by database
            if ($name === "create_time"){continue;}      // no processing on create_time. It will be handled by database
          
            $_cmd .= $name.",";  
            $_val .= "'$json_content[$name]',";  
        };

        $cmd = rtrim($_cmd, ",");            
        $val = rtrim($_val, ","); 
        $cmd .=" )";
        $val .= " )";
        $sql = $cmd.$val;

        $result = [];       // store the result of create record in datavvase
        if (mysqli_query($db, $sql)  === TRUE) {
            $result = jsendFormatter('success', array("result" => "Product '".$json_content["name"]."' is created successfully"));
        } else {
            $result = jsendFormatter('error', [$db -> error]);
        }
        return $result;
    }





    // DELETE /product/delete-product/{id}
    public static function deleteProduct(array $params, array $json_content, object $db) : string{
        // { code here }
        return "deleteProduct";         
    }





    // DELETE /product/clear-products
    public static function clearProduct(array $params, array $json_content, object $db) : string{
        $sql = 'DELETE FROM ProductTable';
        $result = [];       
        if (mysqli_query($db, $sql)  === TRUE) {
            $result = jsendFormatter('success', array("result" => "All records are delected."));
        } else {
            $result = jsendFormatter('error', [$db -> error]);
        }
        return $result;
    }
}








?>