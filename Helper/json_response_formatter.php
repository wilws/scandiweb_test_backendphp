<?php


//  use JSend specification to return result.
function jsendFormatter(string $status, array $content):string {
    // If status = error, only $content[0] (error msg) is returned.

    $return = [];
    switch ($status) {
        case "success":
            $return = array(
                "status" => $status,
                "data" => $content
            );
            break;

        case "fail":
            $return = array(
                "status" => $status,
                "data" => $content
            );
            break;

        case "error":
            $return = array(
                "status" => $status,
                "message" => $content[0]
            );
            break;
        default:
            return $return;      
    };

    return json_encode($return);
}


function checkNum(array $num_arry){

    $check = checkNull($num_arry);
    if($check !== true){
        return $check;
    }

    $key = array_keys($num_arry)[0];
    $value = array_values($num_arry)[0];

    if (!is_numeric($value)){
       return "Invalid '".$key. "' value. It should be a number";
    } else {
       return true;
    }
}


function checkString(array $str_arr, int $len=0){
    
    $check = checkNull($str_arr);
    if($check !== true){
        return $check;
    }

    $key = array_keys($str_arr)[0];
    $value = array_values($str_arr)[0];

    if (strlen($value) >  $len){
        return "'".$key. "' too long. It should be within ". $len ." characters";
    } else {
       return true;
    }
}

function checkType(array $str_arr){
    // $key = array_keys($str_arr)[0];
    $value = array_values($str_arr)[0];
    $allowed_types = array("DVD","Book","Furniture");

    if (in_array($value, $allowed_types)) {
        return true;
    } else {
        return "Invalid 'Type'. Only 'DVD','Book', or 'Furniture' allowed ";
    }
}

function checkNull(array $arr){
    $key = array_keys($arr)[0];
    $value = array_values($arr)[0];
    
    if (is_null($value) or strlen(str_replace(" ","",$value)) <= 0 ){
       return "'".$key. "' should not be Null";
    } else {
       return true;
    }
}







?>