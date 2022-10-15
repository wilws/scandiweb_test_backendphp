<?php

require PATH .'/Models/product.php';
require PATH .'/Controllers/book.class.php';
require PATH .'/Controllers/dvd.class.php';
require PATH .'/Controllers/furniture.class.php';


class ProductController 
{
    
    // GET /product/get-products
    public static function getProducts(array $params, array $jsonBody, object $db) : string 
    {
        $ProductModel = new ProductModel($db);
        $records = $ProductModel->getProducts();

        if (count($records) > 0) {

            $sanitised_output = [];
            foreach ($records as $record) {
 
                $product= self::createProductObject($record);              // Create Product object for each record
                $productObj = $product['data'];
                
                array_push($sanitised_output,
                    array(
                        'id' => $productObj->getId(),
                        'sku' => htmlentities(trim($productObj->getSku())),
                        'name' => htmlentities(trim($productObj->getName())),
                        'price' => htmlentities(trim($productObj->getPrice())),
                        'productType' => htmlentities(trim($productObj->getType())),
                        'spec' => htmlentities(trim($productObj->getSpec())),
                    )
                );
            }
            $result = Helper::jsendFormatter('success',$sanitised_output);
        } else {
            $result = Helper::jsendFormatter('error', [$db -> error]);
        }

        return $result ;
    }


    // POST /product/create-product
    public static function createProduct(array $params, array $jsonBody, object $db) : string 
    {

       
        $result = self::createProductObject($jsonBody,true,$db);
        if ($result['state'] !== 'success') {
            return Helper::jsendFormatter('error', [$result['message']]);
        } 
        
        $product = $result['data'];
        $ProductModel = new ProductModel($db);
        $result = $ProductModel->createProduct(
            $product->getSku(),
            $product->getName(),
            $product->getPrice(),
            $product->getType(),
            $product->getSpec(),
        );

        if (!$result){
            return Helper::jsendFormatter('error', ['Cannot write product into database']); 
        } else {
            return Helper::jsendFormatter('success', array(
                    'result'=> "Product '".$product->getName()."' is created successfully",
                    'id'=> $db ->insert_id
                )
            ); 
        }
    }

    // DELETE /product/delete-products
    public static function deleteProducts(array $params, array $jsonBody, object $db) : string
    {
        $removeList = $jsonBody['removeList'];        // a list that contains ids that subjected to be removed.
        $ProductModel = new ProductModel($db);
        $result = $ProductModel->deleteProducts($removeList);
        if (!$result){
            return Helper::jsendFormatter('error', ['Delete failed']); 
        } else {
            $idString = join(',',$removeList);
            return Helper::jsendFormatter('success', array(
                'result'=> "items (id = $idString) are deleted.")
            );            
        }
    }

    // Non-Routing function
    private static function createProductObject(array $jsonBody, bool $checkUnique=false, ?object $db=null) : array 
    {     
        $Helper = new Helper();
        $type = $jsonBody['productType'];                // Check type. Ensure type is [Book, Furniture or DVD]
        $check = $Helper->checkType(["productType" => $type ]);
        if ($check['state'] !== 'success'){
            return array( 
                'state' => 'error',
                'message' => $check['message']
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
}



?>