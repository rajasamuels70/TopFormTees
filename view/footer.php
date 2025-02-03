<footer>
        <p>&copy; 2025 Top Form Tees. All Rights Reserved.</p>
        <p>Developed by Rogerife Samuels</p>
        
        <p class="copyright">
        <?php 
        
           $firstName = "";
           $lastName = "";
           $userRoleID = "";
            if (isset($_SESSION['user']))
            {
                $user = $_SESSION['user'];
                $firstName = $user->getFirstName();
                $lastName = $user->getLastName();
                $userRoleID = $user->getUserRoleId();
            }
            
            $fullName = $firstName . " " . $lastName;
                
         ?>
            Welcome: <?php echo htmlspecialchars($fullName." (".$userRoleID.")"); ?>
        
    </p>
        
        
        
</footer>
