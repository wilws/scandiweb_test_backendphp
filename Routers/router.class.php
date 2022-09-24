<?php


    // This Router matches the APIs with the correponding controller
    // In path "Routers/urls", this router will be instansided with defined "API:Function" object as arguments 

    class Router {

        private $get;
        private $post;
        private $delete;
        private $patch;
        private $put;


        public function __construct(array $get, array $post, array $delete, array $patch,array $put)
        {
            $this->get = $get;
            $this->post = $post;
            $this->delete = $delete;
            $this->patch = $patch;
            $this->put = $put;
        }


        public function apiProcessor(string $method, array $params, array $json_content, object $db) : string {

           $register = [];                                                         // Store the "API:Func" mapping object
           eval('$register = $this->'.strtolower($method).";");                    // assign a correct register according to the method (eg: GET / POST / DELETE )
           $response_func = $register['/'.$params[0]] ?? NULL;                     // If in the register no route is matched, set correspondent function $response_fun as "NULL"

           if (!$response_func) {                                                  // if no function is matched with the API, 
               return jsendFormatter('error',['No such API']);                     // Return error
           } 

           return call_user_func($response_func ,$params,$json_content, $db);     // Otherwise pass the function name  and execute 
        }


        public static function getApiContent(string $url) : array {

            // This static function break the URL into different portion: eg:
            // " <domain>/product/get-product/5 "   will become => 
            // 
            // $arrObj = array (
            //        'apiGroupName' => 'product',
            //         'params' => (
            //               'get-product',      ## ['params'][0] this indicate the correspondent function
            //               '5',                ## ['params'][1] this indicate the record id
            //         )
            // )


            $explode_url = explode("/", urldecode($url));    
            $apiGroupName = $explode_url[1];
            $_params = array_slice($explode_url,2);
            $params = array_filter($_params, function($v){
                $string = preg_replace('/[^A-Za-z0-9\-]/', '', $v);
                return (strlen(($string)) > 0);
            });

            return array(
                'apiGroupName' => $apiGroupName,
                'params' => $params
            );
        }
    }
?>