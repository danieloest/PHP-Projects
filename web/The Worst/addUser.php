<?php
session_start();
include 'connect.php';
$username = $_POST['username'];
$pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
$passConfirm = $_POST['passwordConfirm'];
$passOriginal = $_POST['password'];
if ($passOriginal != $passConfirm)
{
    header('Location: signup.php?error=1');
    die();
}
else if (strlen($passOriginal) < 7 || !preg_match('~[0-9]~', $passOriginal))
{
    header('Location: signup.php?error=2');
    die();
}
else 
{
    $query = 'INSERT into worstusers(username, pass, isadmin) VALUES (:username, :pass, false)';
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':pass', $pass);
    $statement->execute();
    $_SESSION["username"] = $username;
    header('Location: home.php');
}
?>