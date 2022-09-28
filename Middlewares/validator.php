<?php

require_once("./Helper/json_response_formatter.php");

// This validator acts as middleware between the router and controller
// Data will be passed into the middleware before it is exeuted in controller and enterd to database.

class Validator{

    public static function paramNoCheck(array $param, int $required_no) : bool{
        if (count($param) != $required_no){
           return false;
        } else {
            return true;
        }
    }

    public static function intCheck( $no ) : bool{
        return is_int($no);
    }


    public static function outputSanitisation(array $data) : array {
        $sanitised_arr = [];
        foreach($data as $key=>$value){
            $sanitised_arr[$key] = htmlentities(trim($value));
        }
        return $sanitised_arr;
    }


    public static function  createProductCheck(array $json_content){

        
        // This function mainly for validating the input of "product/create-product" API

        $num_arr = ["price"];                    // Check if number or number string
        $str_arr = ["sku","name","spec"];        // Check if null and length (max:30 char)
        $type_arr = ["productType"];             // Check if "Book"/ "Funiture" / "DVD"

        $validation = true;                      // Pre-set it is true first. if invalid data found, it will be set as false and return to caller with $error_msg
        $error_msg = "";                         // Stroe error message

        foreach($num_arr as $key){

            $check = checkNum([$key => $json_content[$key]]);
            if ($check !== true){
                $validation = false;
                $error_msg .= $check. "; ";
            } 
        }

        foreach($str_arr as $key ){
            $check = checkString([$key => $json_content[$key]],30);
            if ($check !== true){
                $validation = false;
                $error_msg .= $check. "; ";
            } 
        }

        foreach($type_arr as $key){
            $check = checkType([$key => $json_content[$key]]);
            if ($check !== true){
                $validation = false;
                $error_msg .= $check. "; ";
            } 
        }

        return array(
            "validation" => $validation,           
            "error_msg" => $error_msg
        );
    }
}



?>