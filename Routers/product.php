<?php
    require PATH .'/Controllers/product.php' ;
    $productRouter = new Router();
    $productRouter->setRouterName("product");
    $productRouter->setRouterMap(        
       
        $get_methods = array(
            //GET  /product/get-products                   (#return all products) 
            '/get-products' => "ProductController::getProducts", 
        ),

        $post_methods = array(
            //POST /product/create-product                  (#create a product)  
            '/create-product' => "ProductController::createProduct",
        ),

        $delete_methods  = array(
            // DELETE /product/delete-products              (#delete selected products)
            '/delete-products' => "ProductController::deleteProducts",
        ),
        $put_methods = array(),
        $patch_methods = array()
        
    );
?>