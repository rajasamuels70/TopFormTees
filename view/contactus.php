<?php require_once '../view/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
        <link rel="stylesheet" type="text/css" href="../styles/contactus.css">

</head>
<body>
    <h2>Contact Us</h2>
    <?php if (!empty($errorMessage)) echo "<p style='color:red;'>$errorMessage</p>"; ?>
    <?php if (!empty($successMessage)) echo "<p style='color:green;'>$successMessage</p>"; ?>

    <form action="index.php" method="post">
        <input type="hidden" name="controllerRequest" value="contact_us">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" required><br>

        <label for="message">Message:</label>
        <textarea name="message" required></textarea><br>

        <button type="submit">Send Message</button>
    </form>
</body>
</html>

<?php require_once '../view/footer.php'; ?>