<?php

class ProductDB {

    public static function getAllProducts() {
        try {
            $db = Database::getDB(); // Ensure Database::getDB() is correctly implemented
            $query = "SELECT ProductID, Description, Price, CategoryID FROM product WHERE isActive = 1";
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
}
