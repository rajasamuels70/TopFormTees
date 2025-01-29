<?php require_once '../view/header.php'; ?>
<div class="pleaselogin">
    <h1>Please Log in</h1>
    <p>Get the lowest prices, order tracking, and quicker checkouts</p>   
</div>


   <?php if (!empty($error_message)) { ?>
    <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php } ?>
    <head>
        <link rel="stylesheet" type="text/css" href="styles/login.css">
    </head>
    <fieldset>
        <legend>Secure Login:</legend>
        <div class="login-container">
            <form method="POST" action="customer_manager/index.php">
                <input type="hidden" name="controllerRequest" value="validate_login">  
                <!-- Add the code-->
                <label>Email: </label> 
                <input type="text" name="email" value="<?php echo isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : ''; ?>">
                <br>
                <label>Password: </label> 
                <input type="password" name="password" value="<?php echo isset($_COOKIE['password']) ? htmlspecialchars($_COOKIE['password']) : ''; ?>"> 
                <br>
                <button value="Login">Login</button>
<!--                <input type="submit" value="Login">-->
            </form> 
        </div>
    </fieldset>
   
<?php require_once '../view/footer.php'; ?>