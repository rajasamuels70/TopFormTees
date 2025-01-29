<?php require_once '../view/header.php'; ?>
<h1>Register User</h1>

  <?php  echo $errorMessage ?>
  <form method="POST" action="user_manager/index.php">
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