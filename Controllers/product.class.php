<?php

abstract class AbstractProduct 
{

    protected ?string $name  = null;
    protected ?string $price = null;
    protected ?string $sku = null;
    protected ?string $spec = null;
    protected ?string $type = null;
    protected ?string $id = null;
    
    abstract public function setName(string $name);
    abstract public function setPrice(string $price);
    abstract public function setSku(string $sku, bool $checkUnique=false, ?object $db=null);   
    abstract public function setSpec(string $spec);
    abstract public function setId(string $id);

    public function getName() : string 
    {
        return $this->name;
    }

    public function getPrice() : string 
    {
        return $this->price;
    }

    public function getSku() : string 
    {
        return $this->sku;
    }

    public function getSpec() : string 
    {
        return $this->spec;
    }

    public function getType() : string 
    {
        return $this->type;
    }

    public function getId() : string 
    {
        return $this->id;
    }
};


class Product extends AbstractProduct 
{

    protected ?string $error_msg  = null;
    protected ?bool $isAllValid = null;

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $check = checkString(["name" => $name],30);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";
        } else {
            $this->name = $name;
        }
    }

    public function setPrice(string $price)
    {
        $check = checkNum(["price" => $price]);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";
        } else {
            $this->price = $price;
        }
    }

    public function setSku(string $sku, bool $checkUnique=false , ?object $db=null)
    {
        $check = checkString(["sku" => $sku],30);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";

        } else {
            // Check if unique sku
            if ($checkUnique) {
                if (checkNoOfRowInDB($sku,'ProductTable', 'sku', $db) > 0) {
                    $this->isValid = false;
                    $this->error_msg .= 'The sku name is already used in other product. Please choose other name for the sku.';
                    return;

                } else {
                    $this->sku = $sku;
                }
            } else {
                $this->sku = $sku;
            }
        }
    }

    public function setType(string $type)
    {
        $check = checkType(["type" => $type]);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";
        } else {
            $this->type = $type;
        }
    }

    public function setSpec(string $spec)
    {
        $this->spec = $spec;
    }

    public function getErrorMsg(): ?string
    {
        return $this->error_msg;
    }

    public function checkIsAllValid() : bool 
    {
        return true;
    }
}



class Book extends Product 
{

    protected ?string $weight = null;

    public function setWeight(string $weight)
    {
        
        $check = checkNum(["weight" => $weight]);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";
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


class DVD extends Product 
{

    protected ?string $size = null;
    
    public function setSize(string $size)
    {

        $check = checkNum(["size" => $size]);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";
        } else {
            $this->size = $size;
            $this->setSpec($this->size);
        }
    }
    public function getSize() : string {
        return $this->size;
    }
};

class Furniture extends Product 
{
    protected ?string $width  = null;
    protected ?string $length = null;
    protected ?string $height  = null;

    public function setWidth(string $width)
    {
        $check = checkNum(["width" => $width]);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";
        } else {
            $this->width = $width;
            $this->setFurnitureSpec();
        }
    }

    public function setHeight(string $height)
    {

        $check = checkNum(["height" => $height]);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";
        } else {
            $this->height = $height;
            $this->setFurnitureSpec();
        }
    }

    public function setLength(string $length)
    {
        $check = checkNum(["length" => $length]);
        if ($check !== true) {
            $this->isValid = false;
            $this->error_msg .= $check. "; ";
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
        if ($this->width && $this->height && $this->length){        
            $this->setSpec($this->height."X".$this->width."X".$this->length);
        }
    }
};



// non-routing function  
function createProductObject(array $jsonBody, bool $checkUnique=false, ?object $db=null) : array 
{     
    $type = $jsonBody['productType'];                // Check type. Ensure type is [Book, Furniture or DVD]
    $check = checkType(["productType" => $type ]);
    if ($check !== true){
        return array( 
            'state' => 'error',
            'message' => $check
        );   
    } 

    $product = null;                                        
    eval('$product = new '.$type.'();');                 // Create a product object
    if ($product == null) {                              // If not success, return error
        return array( 
            'state' => 'error',
            'message' => 'Cannot create product object',
        );                           
    
    } else {                                            // If creation success, set properties   

        $product->setSku($jsonBody['sku'],$checkUnique,$db);
        $product->setPrice($jsonBody['price']);
        $product->setName($jsonBody['name']);
        $product->setType($jsonBody['productType']);
        isset($jsonBody['weight'])? $product->setWeight($jsonBody['weight']):null;
        isset($jsonBody['size'])? $product->setSize($jsonBody['size']):null;
        isset($jsonBody['height'])? $product->setHeight($jsonBody['height']):null;
        isset($jsonBody['length'])? $product->setLength($jsonBody['length']):null;
        isset($jsonBody['width'])? $product->setWidth($jsonBody['width']):null;
        isset($jsonBody['spec'])? $product->setSpec($jsonBody['spec']):null;
        isset($jsonBody['id'])? $product->setId($jsonBody['id']):null;

        $err_msg = $product->getErrorMsg();
        if($err_msg){
            return array( 
                'state' => 'error',
                'message' => $err_msg,
            );
        } else {
            return array(
                'state' => 'success',
                'data' => $product,
            );
        }
    }
}
?>