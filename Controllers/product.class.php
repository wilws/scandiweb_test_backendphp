<?php

require_once PATH .'/Controllers/abstractProduct.class.php' ;
require_once PATH .'/Helper/helper.class.php';

class Product extends AbstractProduct 
{

    protected ?string $error_msg  = null;
    protected ?bool $isAllValid = null;
    protected ?object $Helper;

    public function __construct(){
        $this->Helper = new Helper();
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $check =  $this->Helper->checkString(["name" => $name],30);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";
        } else {
            $this->name = $name;
        }
    }

    public function setPrice(string $price)
    {
        $check = $this->Helper->checkNum(["price" => $price]);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";
        } else {
            $this->price = $price;
        }
    }

    public function setSku(string $sku, bool $checkUnique=false , ?object $db=null)
    {
        $check = $this->Helper->checkString(["sku" => $sku],30);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";

        } else {
            // Check if unique sku
            if ($checkUnique) {
                if ($this->Helper->checkNoOfRowInDB($sku,'ProductTable', 'sku', $db) > 0) {
                    $this->isValid = false;
                    $this->error_msg .= 'The sku name is already used in other product. Please choose other name for the sku; ';;
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
        $check = $this->Helper->checkType(["type" => $type]);
        if ($check['state'] !== 'success') {
            $this->isValid = false;
            $this->error_msg .= $check['message']. "; ";
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


?>