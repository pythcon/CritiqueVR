<?php
    session_start();
    include("account.php");
    include("loginfunctions.php");

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

//check to see if data is good
    if ($bad) exit("Bad Data");

//hash password
    $pass = md5($pass);

    if (!auth($email, $pass, $t)){
        redirect("<span style=\"color:red;\">Incorrect Credentials...Redirecting...</span>", "/vr/index.html", $delay);
    }
//only get here if youre authenticated
    $_SESSION["logged"] = true;
    $_SESSION["email"] = $email;

//store first and last name
    $row = mysqli_fetch_array($t,MYSQLI_ASSOC);
    $_SESSION["firstname"] = $row["firstname"];
    $_SESSION["lastname"] = $row["lastname"];

//redirect to dashboard
    redirect("<span style=\"color:green;\">You have successfully logged in...</span>", "/vr/dashboard.php", $delay);
?>