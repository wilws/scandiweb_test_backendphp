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


?>