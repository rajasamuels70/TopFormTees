<?php require_once '../view/header.php'; ?>

<h1>Register User</h1>

<!-- Display any error message -->
<?php if (!empty($errorMessage)) { echo "<p style='color:red;'>$errorMessage</p>"; } ?>

<!-- Display success message from redirect after registration -->
<?php if (isset($_GET['successMessage'])) {
    echo "<p style='color:green;'>" . htmlspecialchars($_GET['successMessage']) . "</p>";
} ?>
<head>
        <link rel="stylesheet" type="text/css" href="styles/registration.css">
    </head>

<form method="POST" action="customer_manager/index.php">
    <input type="hidden" name="controllerRequest" value="add_user" /> 

    <label>First Name:</label>
    <input type="text" name="firstName" required><br>

    <label>Last Name:</label>
    <input type="text" name="lastName" required><br>

    <label>Email Address:</label>
    <input type="email" name="emailAddress"><br>

    <label>Password:</label>
    <input type="password" name="password" required><br>

    <label>Street Address:</label>
    <input type="text" name="address"><br>

    <label>City:</label>
    <input type="text" name="city"><br>

    <label>State:</label>
    <input type="text" name="state"><br>

    <label>Zip Code:</label>
    <input type="text" name="postalCode"><br>

    <input type="submit" value="Register">
</form>

<?php require_once '../view/footer.php'; ?>
