<?php

    class App {

        private array $routers;
        private string $requestUrl;
        private string $method;
        private string $apiGroupName;
        private array $params;
        private array $json_content;


        public function __construct(string $request_url, string $method, string $json_contents){

            $this->routers = array();
            $this->requestUrl = $request_url;
            $this->method = $method;
            $this->setJsonContent($json_contents);
            $this->setApiContent();
        }

        public function setRouters(object $router){
           $this->routers[$router->getRouterName()] = $router->getRouterMap();
        }

        public function setDataBase(object $db){
             $this->db = $db;
        }

        private function setJsonContent(string $json_contents){
            $this->json_content = json_decode($json_contents,true) ?? [];       // Parse json body and change it to array format
        }
        
        private function setApiContent() {
            
            // Get the url - eg: <domain>/product/get-products
            // explode the url - eg: "<domain>/product/get-product/1" will become :
            // ["apiGroupName":"product", "params":["get-products","1"]];
            // server hence konws that :
            // 1) it is a APIs of group  "product";           
            // 2) It has two params: [0] => "get-products"    # user wanna view a product
            //                       [1] => "1"               # the product's id is "1"

            $explode_url = explode("/", urldecode($this->requestUrl));    
            $this->apiGroupName = $explode_url[1];

            $_params = array_slice($explode_url,2);
            $this->params = array_filter($_params, function($v){
                $string = preg_replace('/[^A-Za-z0-9\-]/', '', $v);
                return (strlen(($string)) > 0);
            });
        }

        public function run() {
           $register = $this->routers[$this->apiGroupName][$this->method];    // To store the "API:Func" mapping object. Assign a correct register according to the method (eg: GET / POST / DELETE )
           $response_func = $register['/'.$this->params[0]] ?? NULL;          // If in the register no route is matched, set correspondent function $response_fun as "NULL"

           if (!$response_func) {                                             // if no function is matched with the API, 
               echo jsendFormatter('error',['No such API']);                // Return error
               return;
            } 
           echo call_user_func($response_func ,$this->params,$this->json_content, $this->db);     // Otherwise pass the function name  and execute 
           return;
        }
    }

?>