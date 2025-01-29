<?php

class ProductDB{
    
    public static function getAllProducts(){
        $db = Database::getDB();
        $query = "SELECT * FROM product WHERE isActive = 1";
        $statement = $db->prepare($query);
        $statement->execute();
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $products;
    }
}