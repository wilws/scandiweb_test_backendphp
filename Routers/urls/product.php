<?php

    // This Router page for setting api path and its correspondent function
    // APIs name starts with "/product/" with be directed in this page.
    
    $Router = new Router( 


        // ************************************* //
        // ** API with GET Request Register  **  //
        // ************************************* //
        $get_register = array(

            //GET  /product/get-products  (#return all products) 
            '/get-products' => "Product::getProducts", 

            //GET  /product/get-product/{id}  (#return 1 products) 
            // '/get-product' => "Product::getProduct", 
        ),



        // *************************************//
        // ** API with POST Request Register ** //
        // *************************************//
        $post_register = array(

            //POST /product/create-product   (#create a product)  
            '/create-product' => "Product::createProduct",
        ),



        // *************************************//
        // * API with DELETE Request Register * //
        // *************************************//
        $delete_register = array(
            //DELETE /product/delete-product/{id}      #delete a product
            '/delete-product' => "Product::deleteProduct",

            // DELETE /product/clear-products           #delete all products
            '/clear-products' => "Product::clearProduct"
        ),




        // *************************************//
        // *** API with PUT Request Register ** //
        // *************************************//
        $put_register = array(),




        // *************************************//
        // ** API with PATCH Request Register * //
        // *************************************//
        $patch_register = array()
    );
?>