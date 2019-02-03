<?php
session_start();
mb_internal_encoding("UTF-8"); 
 function autoload($class)
 {
     
    if (preg_match('/Controller$/', $class))
    {
        if (strpos($class,"Ajax")!==false )
        {
            require("controllers/ajax/" . $class . ".php");
        }
        else
        {
            require("controllers/" . $class . ".php");
        }
    }
    else
    {
    require("models/" . $class . ".php");
    }
 }

 spl_autoload_register("autoload");
 Database::connect();
if( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    $router = new AjaxRouterController();
}
else
{
    $router = new RouterController();
}


 $router ->process(array($_SERVER['REQUEST_URI']));



