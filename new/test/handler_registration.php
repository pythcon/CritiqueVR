<?php
    session_start();
    include("account.php");
    include("loginfunctions.php");
    
//error reporting code
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set('display_errors' , 1);

//DB Connection
    $db = mysqli_connect($hostname, $username, $password, $project);

    if (mysqli_connect_errno())
      {	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
          exit();
      }
    print "Successfully connected to MySQL.<br>";
    mysqli_select_db($db,$project);

    $delay = 3;

//get data
    getData("email", $email);
    getData("pass", $pass);
    getData("firstname", $firstname);
    getData("lastname", $lastname);

//check to see if data is good
    if ($bad) exit("Bad Data");

//insert data into accounts table
register($email, $firstname, $lastname, $pass);

echo "
<script>
    alert(\"Successfully Registered. Please log in.\");
    window.location.replace(\"/vr/index.html\");
</script>
";