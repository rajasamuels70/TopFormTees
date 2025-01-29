<?php

class CustomerDB{
    public static function getCustomerByEmail_Password($emailAddress, $password){
        $db = Database::getDB();
        $query = 'SELECT * FROM customer WHERE emailAddress = :emailAddress AND password = :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':emailAddress', $emailAddress);
        $statement->bindValue(':password', $password);
        $statement->execute();
        
         // Verify the password if the user exists
        if ($customer && password_verify($password, $customer['password'])) {
            return $customer; // Return customer details if credentials are valid
        }

        return null; // Return null if no match is found or password is invalid
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}