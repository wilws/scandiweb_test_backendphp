<?php

require_once PATH .'/Controllers/product.class.php';

class Book extends Product 
{
    protected ?string $weight = null;

    public function setWeight(string $weight)
    {
        
        $check = $this->Helper->checkNum(["weight" => $weight]);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";
        } else {
            $this->weight = $weight;
            $this->setSpec($this->weight);
        }
    }

    public function getWeight() : string 
    {
        return $this->weight;
    }
};

?>