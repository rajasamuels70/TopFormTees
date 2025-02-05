<?php

$lifetime = 60 * 60 * 24 * 14;
session_set_cookie_params($lifetime, '/');
require_once('../model/customer.php');
session_start();
require_once('../model/order_db.php');



require_once('../model/database.php');
require_once('../model/customer_db.php');




// Get the data from either the GET or POST collection.
$controllerChoice = filter_input(INPUT_POST, 'controllerRequest');
if ($controllerChoice == NULL) {
    $controllerChoice = filter_input(INPUT_GET, 'controllerRequest');
    if ($controllerChoice == NULL) {
        $controllerChoice = 'Not-Set (Null)';
    }
}

/*  The controller does three things
 *  1: Makes a decision based on the value of $controllerChoice
 *  2: Gathers the required resources/objects needed to display on the view
 *  3: Includes the appropriate view or redirects to a different page.
 */

if ($controllerChoice == 'login_user') {
    $email = "";
    $errorMessage = "";
    $password = "";

    // Clear previous session data
    session_destroy();
    $_SESSION = array();

    session_start();

    // Load the login view
    require_once("customer_login.php");
} 

else if ($controllerChoice == 'logout') {
    $email = "";
    $errorMessage = "";
    $password = "";

    // Clear the session
    $_SESSION = array();
    session_destroy();

    // Redirect to the login page
    include('customer_login.php');
    exit;
} 

else if ($controllerChoice == 'validate_login') {
    $emailAddress = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');

    if ($emailAddress == null || $password == null) {
        $errorMessage = "Please enter a valid email and password.";
        include('customer_login.php');
    } else {
        // Fetch customer object from database
        $customer = CustomerDB::getCustomerByEmail_Password($emailAddress, $password);

        if ($customer !== null) {
            // Ensure $customer is an instance of Customer before storing it in session
            if ($customer instanceof Customer) {
                $_SESSION['customer'] = $customer; // Store the object in session
                header("Location: ../customer_manager/?controllerRequest=dashboard");
                exit();
            } else {
                $errorMessage = "Error retrieving customer information.";
                include('customer_login.php');
            }
        } else {
            $errorMessage = "Incorrect email or password.";
            include('customer_login.php'); // Reload login page with error message
        }
    }
}
else if ($controllerChoice == 'dashboard'){
    if (!isset($_SESSION['customer'])) {
        header("Location: ?controllerRequest=login_user");
        exit();
    }
    //include('../view/header.php');  // Include the header
    include('accountdashboard.php'); // Load the account dashboard page
    include('../view/footer.php');  // Include the footer
}
else if ($controllerChoice == 'add_user') {
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $emailAddress = filter_input(INPUT_POST, 'emailAddress', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($firstName) || empty($lastName) || empty($password)) {
        $errorMessage = "Please fill in all required fields.";
        include("customer_register.php");
    } else {
        // Create the customer object (you can pass it to the addCustomer method if needed)
        $customer = new Customer($firstName, $lastName, $emailAddress, $password, $address, $city, $state, $postalCode);

        // Add the user to the database
        $result = CustomerDB::addCustomer($customer);

        if ($result) {
            // Clear session data
            $_SESSION = array();
            session_destroy();
            session_start(); // Start a new session

            // Redirect to login after successful registration
            $successMessage = "Registration successful. Please log in.";
            header("Location: customer_login.php?successMessage=" . urlencode($successMessage));
            exit();
        } else {
            $errorMessage = "There was an error with your registration. Please try again.";
            include("customer_register.php");
        }
    }
}
else if ($controllerChoice == 'contact_us'){
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $errorMessage = "All fields are required.";
        include('../view/contactus.php'); // Reload the contact form with an error message
    } else {
        // You can process the message here (e.g., send an email or store it in a database)
        $successMessage = "Your message has been sent successfully!";
        include('../view/contactus.php'); // Reload the contact form with a success message
    }
}
else if ($controllerChoice == 'logout') {
    $email = "";
    $errorMessage = "";
    $password = "";
    // This is clearing the session
    $_SESSION = array();
    session_destroy(); // Destroy the session
    include('customer_login.php'); // Redirect to the login page
    exit;
} 

else {
    // Default action
    $errorMessage = "Invalid request.";
    include('customer_login.php');
}