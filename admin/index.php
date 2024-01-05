<?php
declare(strict_types=1);                                // Use strict types
require '../includes/database-connection.php';

session_start();                                         // Start/renew session
$logged_in = $_SESSION['logged_in'] ?? false;            // Is user logged in?


if ($_SERVER['REQUEST_METHOD'] == 'POST') {     // If form submitted
    $user_email = $_POST['email'];          // Email user sent
    $user_password = $_POST['password'];       // Password user sent
    //
    //SELECT * FROM `member` WHERE `email` = 'ivy@eg.link' AND `password` = 'c63j-82ve-2sv9-qlb38'

    $sql = "SELECT * FROM `member` WHERE `email` = :email AND `password` = :password;";

    $stmt = pdo($pdo, $sql, [
        $user_email,
        $user_password
    ]);
    $result = $stmt->fetch();
    print_r($result);
    if (count($result)) { // If details correct
         $_SESSION['logged_in'] = true;
        
        header('Location: account.php');       // Redirect to account page
        exit;                                  // Stop further code running
    } else {
        echo "Incorrect Info";
    }
}
?> 
<?php include '../includes/admin-header.php'; ?>
<h1>Login</h1>
<form method="POST" action="">
    Email: <input type="email" name="email" value=""><br>
    Password: <input type="password" name="password" value=""><br>
    <input type="submit" value="Log In">
</form>
<?php include '../includes/admin-footer.php'; ?>