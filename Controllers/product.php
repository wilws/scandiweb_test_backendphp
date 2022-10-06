<?php

require PATH .'/Models/product.php';
require PATH .'/Controllers/product.class.php';
require_once PATH .'/Helper/helperFunctions.php';


// This Product controller class provide static functions matched with the API maping in Routes/urls/product.php


class ProductController {

    // GET /product/get-products
    public static function getProducts(array $params, array $json_content, object $db) : string {
        $productTable = new ProductTable($db);
        $records = $productTable->getProducts();
        if (count($records) > 0){
            $sanitised_output = [];
            foreach ($records as $record ){
                $product= createProductObject($record); 
                $productObj = $product['data'];
                array_push($sanitised_output,array(
                    'id' => $productObj->getId(),
                    'sku' => htmlentities(trim($productObj->getSku())),
                    'name' => htmlentities(trim($productObj->getName())),
                    'price' => htmlentities(trim($productObj->getPrice())),
                    'productType' => htmlentities(trim($productObj->getType())),
                    'spec' => htmlentities(trim($productObj->getSpec())),
                ));
            }
            $result = jsendFormatter('success',$sanitised_output);
        } else {
            $result = jsendFormatter('error', [$db -> error]);
        }
        return $result ;
    }


    // POST /product/create-product
    public static function createProduct(array $params, array $json_content, object $db) : string {

        $result = createProductObject($json_content,$db);
        if($result['state'] !== 'success'){
            return jsendFormatter('error', [$result['message']]);
        } 
        
        $product = $result['data'];
        $productTable = new ProductTable($db);
        $result = $productTable->createProduct(
            $product->getSku(),
            $product->getName(),
            $product->getPrice(),
            $product->getType(),
            $product->getSpec(),
        );

        if (!$result){
            return jsendFormatter('error', ['Cannot write product into database']); 
        } else {
            return jsendFormatter('success', array(
                'result'=> "Product '".$product->getName()."' is created successfully",
                'id'=> $db ->insert_id)
            ); 
        }
    }

    // DELETE /product/delete-products
    public static function deleteProducts(array $params, array $json_content, object $db) : string{
        $rl = $json_content['removeList'];
        $productTable = new ProductTable($db);
        $result = $productTable->deleteProducts($rl);
        if (!$result){
            return jsendFormatter('error', ['Delete failed']); 
        } else {
            $idString = join(',',$rl);
            return jsendFormatter('success', array(
                'result'=> "items (id = $idString) are deleted.")
            );            
        }

    }
}



?>