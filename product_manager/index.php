<?php
$lifetime = 60 * 60 * 24 * 14; 
session_set_cookie_params($lifetime, '/'); 
session_start(); 

require_once('../model/database.php');
require_once('../model/product_db.php');

$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ( $controllerChoice == NULL) {
     $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ( $controllerChoice == NULL) {
         $controllerChoice = 'view_product';
    }
}  
if($controllerChoice == 'view_product'){
    
    include('product_view.php');
    
}

