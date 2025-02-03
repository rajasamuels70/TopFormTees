<?php

class CustomerDB{
    public static function getCustomerByEmail_Password($emailAddress, $password) {
        $db = Database::getDB();
        $query = 'SELECT * FROM customer WHERE emailAddress = :emailAddress AND password = :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':emailAddress', $emailAddress);
        $statement->bindValue(':password', $password);
        $statement->execute();
        
        // Fetch customer data
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if ($row) {
            // Create and return a Customer object
            return new Customer(
                $row['id'],
                $row['customerRoleTypeId'],
                $row['firstName'],
                $row['lastName'],
                $row['address'],
                $row['city'],
                $row['state'],
                $row['zip'],
                $row['emailAddress'],
                $row['userName'],
                $row['password'],
                $row['dateAdded'],
                $row['dateUpdated']
            );
        }

        return null; // Return null if no match
    }
 }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  