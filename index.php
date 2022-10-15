<?php
    declare(strict_types = 1);
    define('PATH', getcwd());

    require PATH .'/app.php';
    require PATH .'/Helper/helper.class.php';
    require PATH .'/Models/database.php';  
    require PATH .'/Routers/router.php';
    require PATH .'/Routers/product.php'; 
    
    // head config.
    header("Access-Control-Allow-Origin: * ");    
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, PUT, PATCH");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    $app = new App($_SERVER['REQUEST_URI'],$_SERVER["REQUEST_METHOD"],file_get_contents('php://input'));
    $app->setDataBase($db);
    $app->setRouters($productRouter);
    $app->run();
?>