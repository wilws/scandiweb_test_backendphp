<?php
    require PATH .'/Controllers/product.php' ;
    $productRouter = new Router();
    $productRouter->setRouterName("product");
    $productRouter->setRouterMap(        
       
        $get = array(
            //GET  /product/get-products  (#return all products) 
            '/get-products' => "ProductController::getProducts", 
        ),

        $post = array(
            //POST /product/create-product (#create a product)  
            '/create-product' => "ProductController::createProduct",
        ),

        $delete = array(
            // DELETE /product/delete-products (#delete selected products)
            '/delete-products' => "ProductController::deleteProducts",
        ),

        $put = array(),

        $patch = array()
    );
?>