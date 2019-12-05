<?php
session_start();
include("account.php");
include("functions.php");

//DB Connection

//get data
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
$pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);

//hash password
$pass = md5($pass);

//insert data into accounts table
register($email, $pass, $firstName, $lastName);

echo "
<script>
    alert(\"Successfully Registered. Please log in.\");
    window.location.replace(\"index.html\");
</script>
";
?>