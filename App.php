<?php

    class App 
    {
        private array  $routers;                
        private string $requestUrl;             
        private string $method;
        private string $apiGroupName;
        private array  $params;
        private array  $jsonBody;

        
        public function __construct(string $request_url, string $method, string $jsonBody)
        {
            $this->routers = array();
            $this->requestUrl = $request_url;
            $this->method = $method;
            $this->setJsonContent($jsonBody);
            $this->setApiContent();
        }

        public function setRouters(object $router)
        {
            $this->routers[$router->getRouterName()] = $router->getRouterMap();
        }

        public function setDataBase(object $db)
        {
            $this->db = $db;
        }

        private function setJsonContent(string $jsonBody)
        {
            $this->jsonBody = json_decode($jsonBody,true) ?? [];       // Parse json body and change it to array format
        }

        private function setApiContent() 
        {
            
            /** 
             * Get the url - eg: <domain>/product/get-products
             * explode the url - eg: "<domain>/product/get-product/1" will become :
             * ["apiGroupName":"product", "params":["get-products","1"]];
             * server hence konws that :
             * 1) it is a APIs of group  "product";           
             * 2) It has two params: [0] => "get-products"    # user wanna view a product
             *                       [1] => "1"               # the product's id is "1"
             */

             $explodeUrl = explode("/", urldecode($this->requestUrl));    
             $this->apiGroupName = $explodeUrl[1];

             $_params = array_slice($explodeUrl,2);
             $this->params = array_filter($_params, function($p){
                 $string = preg_replace('/[^A-Za-z0-9\-]/', '', $p);
                 return (strlen(($string)) > 0);
             });
        }

        public function run() 
        {
            $register = $this->routers[$this->apiGroupName][$this->method];    // To store the "API:Func" mapping object. Assign a correct register according to the method (eg: GET / POST / DELETE )
            $response_func = $register['/'.$this->params[0]] ?? NULL;          // If in the register no route is matched, set correspondent function $response_fun as "NULL"

            if (!$response_func) {                                             // if no function is matched with the API, 
                echo jsendFormatter('error',['No such API']);                  // Return error
                return;
            } 
            echo call_user_func($response_func ,$this->params,$this->jsonBody, $this->db);     // Otherwise pass the function name  and execute 
            return;
        }
    }

?>