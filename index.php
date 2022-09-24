<?php
    declare(strict_types = 1);
    require("./Routers/router.class.php");
    require("./Helper/json_response_formatter.php");


    // **** DataBase Config **** //
    define("HOST","");
    define("USER","");
    define("PASSWORD","");
    define("NAME","");
    define("PORT","");
    require("./Models/db_connect.php");



    // **** Header Config **** //
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PUT, PATCH");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


    // **** Routing Control **** //

    // Step 1 : Breakdown the URL api content.
    $method = $_SERVER["REQUEST_METHOD"];                                       // Get the method - eg: GET / POST / DELETE
    $json_content = json_decode(file_get_contents('php://input'),true) ?? [];   // Parse json body and change it to array format

    $url = $_SERVER['REQUEST_URI'];                                             // Get the url - eg: <domain>/product/get-products
    $api_content = Router::getApiContent($url);                                 // explode the url - eg: "<domain>/product/get-product/1" will become :
                                                                                // ["apiGroupName" = "product", "params" = ["get-products","1"];
                                                                                // server hence konws that :
                                                                                // 1) it is a APIs of group  "Product";           
                                                                                // 2) It has two params: [0] => "get-products"    # user wanna view a product
                                                                                ///                      [1] => "1"               # the product's id is "1"





    $result = "";           // To store the result of fetched result or error 

    // Step 2 : Import relevant routers
    if( !@include("./Routers/urls/".$api_content["apiGroupName"].".php") ){                    // Select the correct router regrading the "apiGroupName" 
        $result = jsendFormatter('error', ['Routing not Found. Maybe Invalid API']);           // If no such router PHP file found, return an error in JSend format

    } else {                                                                                   // If router found
        // Step 3 : Import correspondent controllers
        if( !@include("./Controllers/".$api_content["apiGroupName"].".php")  ){                // Try to import the rquired controller 
            $result = jsendFormatter('error', ['Controller not Found. Maybe Invalid API']);    // If no such controller PHP file found, return error.

        } else {    
            // Step 4 : Process the API                                                         // when both router and controller files are ready
            $result = $Router->apiProcessor($method,$api_content['params'],$json_content,$db);  // process the api, will return string with JSON format
        }
    }
    echo $result;
?>