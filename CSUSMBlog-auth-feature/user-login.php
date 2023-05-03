<?php
session_start();
//declare variables
$username = "";
$userPassword = "";

// Check if it is POST request.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get variables from form submission.
    $username = $_POST['username'];
    $userPassword = $_POST['userPassword'];

    // Validate form data.
    try {
        if (!isset($username) || !is_string($username)) {
            throw new Exception("Enter valid username");
        }
        if (!isset($userPassword) || !is_string($userPassword)) {
            throw new Exception("Enter valid password");
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
        die($message);
    }

    // Connect to SQL server
    try {
        $connString = "mysql:host=localhost; dbname=csusmblog";
        $user = "root";
        $pass = "root";
        $pdo = new PDO($connString, $user, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); //$pdo is the main SQL accessor variable
    } catch (Exception $e) {
        $message = $e->getMessage();
        die($message);
    }

    $statement= $pdo->prepare("SELECT * FROM Admin WHERE username=:username AND userPassword=:userPassword");
    $statement->execute([
        'username' => $username,
        'userPassword' => $userPassword,
    ]);
    $user = $statement->fetch();
    if(isset($user)){
        $_SESSION['username'] = $user['username'];
        $_SESSION['adminId'] = $user['adminId'];
        header("Location: blog-home.php");
    } else{
        header("Location: loginForm.html");
    }
}
