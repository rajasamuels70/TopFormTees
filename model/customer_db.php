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
        //$row = $statement->fetchAll(PDO::FETCH_ASSOC);
        $row = $statement->fetch();
        $statement->closeCursor();
        
        $firstName = $row['FirstName'];
        
        
        if ($row) {
            // Create and return a Customer object
            $customer = new Customer(
                $row['ID'],
                $row['FirstName'],
                $row['LastName'],
                $row['Address'],
                $row['City'],
                $row['State'],
                $row['Zip'],
                $row['EmailAddress'],
                $row['Password'],
                $row['CustomerRoleTypeId'],
                $row['DateCreated'],
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
            (firstName, lastName, address, city, state, zip, emailAddress, password, dateCreated)
            VALUES 
            (:firstName, :lastName, :address, :city, :state, :zip, :emailAddress, :password, NOW())';

        // Prepare the statement
        $statement = $db->prepare($query);

        // Bind values from the Customer object
        //$statement->bindValue(':customerRoleTypeID', $customer->getCustomerRoleTypeID());
        $statement->bindValue(':firstName', $customer->getFirstName());
        $statement->bindValue(':lastName', $customer->getLastName());
        $statement->bindValue(':emailAddress', $customer->getEmailAddress());
        //$statement->bindValue(':userName', $customer->getUserName());
        $statement->bindValue(':password', $customer->getPassword());  // No hashing
        $statement->bindValue(':address', $customer->getAddress());
        $statement->bindValue(':city', $customer->getCity());
        $statement->bindValue(':state', $customer->getState());
        $statement->bindValue(':zip', $customer->getZip());

        // Execute the statement
        $statement->execute();
        $statement->closeCursor();
    }
    public static function updateCustomer($customer) {
        $db = Database::getDB();
        $query = "UPDATE customer SET 
                    FirstName = :firstName,
                    LastName = :lastName,
                    EmailAddress = :email,
                    Address = :address,
                    City = :city,
                    State = :state,
                    Zip = :zip
                  WHERE ID = :customerId"; // Correct field name is ID

        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $customer->getFirstName());
        $statement->bindValue(':lastName', $customer->getLastName());
        $statement->bindValue(':email', $customer->getEmailAddress());
        $statement->bindValue(':address', $customer->getAddress());
        $statement->bindValue(':city', $customer->getCity());
        $statement->bindValue(':state', $customer->getState());
        $statement->bindValue(':zip', $customer->getZip()); // Fix binding to :zip
        $statement->bindValue(':customerId', $customer->getId());

        $success = $statement->execute();
        $statement->closeCursor();

        return $success;
    }



   
 }
    
 