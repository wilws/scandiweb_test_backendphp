<?php

    class Router 
    {
        private string $routerName;
        private array $routerMap;

        public function setRouterName(string $name)
        {
            $this->routerName = $name;
        }

        public function setRouterMap(array $get,array $post,array $delete,array $put,array $patch)
        {
            $this->routerMap = array(
                'GET' => $get,
                'POST' => $post,
                'DELETE' => $delete,
                'PUT' => $put,
                'PATCH' => $patch
            );
        }

        public function getRouterName() : string
        {
            return $this->routerName;
        }

        public function getrouterMap() : array
        {
            return $this->routerMap;
        }
    }
?>