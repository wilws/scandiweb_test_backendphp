<?php

    // This Routers page is for setting api path and its correspondent function in controller
    // All APIs'group  "/product/" with be directed in this page.



    //  -- FOR SCALING UP -- 
    //
    // To scale up the application, for example, adding "cart" functions
    //  
    // - Step 1  
    // Create a file "cart.php" (lowercase) in "<root>/Routers/urls/"

    // - Step 2 
    // In newly created "cart.php" in step 1, initialise Router Object with method register :
    //
    // $Router = new Router(           
    //     <$get_register> 
    //     <$post_register> 
    //     <$delete_register>    
    //     <$put_register> 
    //     <$patch_register> 
    // ) 
    //
    // Structure of register array :
    // array(
    //    'API' => 'APIGroupName::Function"     (e.g.: "add-cart" = > Cart::addCart )
    // )

    // - Step 3
    // Then create a "cart.php" (lowercase) file under 'Controllers' folder:
    // Class Cart {
    //    public static function addCart() {...}
    // } 
    
    
    $Router = new Router( 

        // ************************************* //
        //    API with GET Request Register      //
        // ************************************* //
        $get_register = array(

            //GET  /product/get-products                   (#return all products) 
            '/get-products' => "Product::getProducts", 

            //GET  /product/get-product/{id}               (#return 1 products) 
            // '/get-product' => "Product::getProduct", 
        ),



        // *************************************//
        //    API with POST Request Register    //
        // *************************************//
        $post_register = array(

            //POST /product/create-product                  (#create a product)  
            '/create-product' => "Product::createProduct",
        ),



        // *************************************//
        //   API with DELETE Request Register   //
        // *************************************//
        $delete_register = array(
            //DELETE /product/delete-product/{id}           (#delete a product)
            '/delete-product' => "Product::deleteProduct",

            // DELETE /product/clear-products               (#delete all products)
            '/clear-products' => "Product::clearProduct",

            // DELETE /product/delete-products              (#delete selected products)
            '/delete-products' => "Product::deleteProducts",
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