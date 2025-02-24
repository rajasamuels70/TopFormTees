<?php

class ProductDB {

    public static function getAllProducts() {
        try {
            $db = Database::getDB(); // Ensure Database::getDB() is correctly implemented
            $query = "SELECT ProductID, Description, Price, Size, CategoryID FROM product WHERE isActive = 1";
            $statement = $db->prepare($query);
            $statement->execute();
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            $statement->closeCursor();
            return $products;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage()); // Log errors for debugging
            return []; // Return empty array if there’s an error
        }
    }
    public static function getProductById($productID) {
        $db = Database::getDB();
        $query = "SELECT * FROM product WHERE ProductID = :productID";
        $statement = $db->prepare($query);
        $statement->bindValue(':productID', $productID, PDO::PARAM_INT);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $product;
    }

}
