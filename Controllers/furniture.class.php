<?php
require_once PATH .'/Controllers/product.class.php' ;

class Furniture extends Product 
{
    protected ?string $width  = null;
    protected ?string $length = null;
    protected ?string $height  = null;

    public function setWidth(string $width)
    {
        $check = $this->Helper->checkNum(["width" => $width]);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";
        } else {
            $this->width = $width;
            $this->setFurnitureSpec();
        }
    }

    public function setHeight(string $height)
    {

        $check = $this->Helper->checkNum(["height" => $height]);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";
        } else {
            $this->height = $height;
             
            $this->setFurnitureSpec();
        }
    }

    public function setLength(string $length)
    {
        $check = $this->Helper->checkNum(["length" => $length]);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";
        } else {
            $this->length = $length;
            
            $this->setFurnitureSpec();
        }
    }

    public function getLength() : string 
    {
        return $this->length;
    }

    public function getWidth() : string 
    {
        return $this->width;
    }

    public function getHeight() : string 
    {
        return $this->height;
    }

    private function setFurnitureSpec() 
    {

        if (!is_null($this->width) && !is_null($this->height) && !is_null($this->length)){        
            $this->setSpec($this->height."X".$this->width."X".$this->length);
        }
    }
};

?>