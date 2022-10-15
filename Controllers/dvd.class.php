<?php

require_once PATH .'/Controllers/product.class.php';


class DVD extends Product 
{
    protected ?string $size = null;
    
    public function setSize(string $size)
    {

        $check = $this->Helper->checkNum(["size" => $size]);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";
        } else {
            $this->size = $size;
            $this->setSpec($this->size);
        }
    }
    public function getSize() : string {
        return $this->size;
    }
};


?>