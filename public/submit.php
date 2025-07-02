<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (empty($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['captcha']) {
    die('Incorrect CAPTCHA');
}

$username = validateUsername($_POST['username'] ?? '');
$email = validateEmail($_POST['email'] ?? '');
$homepage = validateUrl($_POST['homepage'] ?? '');
$text = validateText($_POST['text'] ?? '');

$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO messages (username, email, homepage, text, ip_address, user_agent) 
                          VALUES (:username, :email, :homepage, :text, :ip_address, :user_agent)");
    
    $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':homepage' => $homepage,
        ':text' => $text,
        ':ip_address' => $ip_address,
        ':user_agent' => $user_agent
    ]);

    header('Location: index.php?success=1');
} catch (PDOException $e) {
    die("Error saving the message: " . $e->getMessage());
}
?>