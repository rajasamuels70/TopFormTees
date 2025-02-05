<?php

class CustomerDB{
    public static function getCustomerByEmail_Password($emailAddress, $password) {
        $db = Database::getDB();
        $query = 'SELECT * FROM customer WHERE EmailAddress = :emailAddress AND Password = :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':emailAddress', $emailAddress);
        $statement->bindValue(':password', $password);
        $statement->execute();
        
        // Fetch customer data
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();

        if ($row) {
            // Create and return a Customer object
            $customer = new Customer(
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
            return $customer;     
        }
        else{
            
        return null; // Return null if no match
            
        }

    }
    
    
    public static function addCustomer($customer) {
        // Get the database connection
        $db = Database::getDB();

        // SQL query to insert a new customer
        $query = 'INSERT INTO customer 
            (customerRoleTypeID, firstName, lastName, address, city, state, zip, emailAddress, userName, password, dateAdded, dateUpdated)
            VALUES 
            (:customerRoleTypeID, :firstName, :lastName, :address, :city, :state, :zip, :emailAddress, :userName, :password, NOW(), NOW())';

        // Prepare the statement
        $statement = $db->prepare($query);

        // Bind values from the Customer object
        $statement->bindValue(':customerRoleTypeID', $customer->getCustomerRoleTypeID());
        $statement->bindValue(':firstName', $customer->getFirstName());
        $statement->bindValue(':lastName', $customer->getLastName());
        $statement->bindValue(':emailAddress', $customer->getEmailAddress());
        $statement->bindValue(':userName', $customer->getUserName());
        $statement->bindValue(':password', $customer->getPassword());  // No hashing
        $statement->bindValue(':address', $customer->getAddress());
        $statement->bindValue(':city', $customer->getCity());
        $statement->bindValue(':state', $customer->getState());
        $statement->bindValue(':zip', $customer->getZip());

        // Execute the statement
        $statement->execute();
        $statement->closeCursor();
    }


   
 }
    
 