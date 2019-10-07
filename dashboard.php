<!------------------------------AUTHENTICATION----------------------->
<?php
    session_set_cookie_params(600);
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    ini_set('display_errors' , 1);
    include("loginfunctions.php");
    include("account.php");

    //DB Connection
    $db = mysqli_connect($hostname, $username, $password, $project);

    if (mysqli_connect_errno())
      {	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
          exit();
      }
    
    gatekeeper();
    $email = $_SESSION['email'];

?>
<!------------------------------------------------------------------->
<!Doctype HTML>
<html lang="en">
<head>
	<title>CritiqueVR - Dashboard</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
    
<!-------------------------------------------------------------------------------------------->
<style>
    #createBrainstormingSession {display: none;}
    #listBrainstormingSessions {display: none;}
    
</style> 

<script>
    function appear(){
        createBrainstormingSessionPointer = document.getElementById("createBrainstormingSession")
        listBrainstormingSessionsPointer = document.getElementById("listBrainstormingSessions")
        dropDownMenu = document.getElementById("options")
        $toolChoice = dropDownMenu.value
        switch($toolChoice){
            case "1":
                createBrainstormingSessionPointer.style.display = "block"
                listBrainstormingSessions.style.display = "none"
                break;
            case "2":
                createBrainstormingSessionPointer.style.display = "none"
                listBrainstormingSessions.style.display = "block"
                break;
            default:
                createBrainstormingSessionPointer.style.display = "none"
                listBrainstormingSessions.style.display = "none"
        }
    }
</script>
<!-------------------------------------------------------------------------------------------->
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100">
                <div>
                    <div style="float:left"><a style="font-size: 16px" href="/vr/changepassword.php">Change Password</a></div>
                    <div style="float:right"><a style="font-size: 20px" href="/vr/logout.php">Logout</a></div>
                </div>
                <span><br></span>
					

                    <?php 
                    //print out name of user
                    $email = $_SESSION['email'];
                    $s = "SELECT * FROM accounts WHERE email = '$email'";
                    $t = mysqli_query($db, $s) or die("Error Querying Database.");

                    while ( $r = mysqli_fetch_array($t,MYSQLI_ASSOC) ) {
                        $firstName 				= $r[ "firstName" ];
                        $lastName            	= $r[ "lastName" ];
                    }
                    echo"
                    <span class=\"login100-form-title p-b-34 p-t-27\">
						Welcome ". $firstName. " ". $lastName." 
                    </span>
                    ";
                    ?>
                    <div align="center">
                        Please select something to do:
                        <select name = "options" id = "options" onchange="appear()">
                            <option value = "0">(select a tool)</option>
                            <option value = "1">Create New Brainstorming Session</option>
                            <option value = "2">List Brainstorming Sessions</option>
                        </select>
                    </div>
                    <hr>
                    
                    <!--CREATE BRAINSTORMING SESSION-->
                    <div id = "createBrainstormingSession">
                        <form class="login100-form validate-form" action="handler_createsession.php" method="post">
                            
                            <div class="wrap-input100 validate-input" data-validate = "Enter name of the room">
                                <input class="input100" type="text" name="name" placeholder="Project Name (ex. IT490 Demo)">
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                            </div>

                            <div class="wrap-input100 validate-input" data-validate = "Enter description of the room">
                                <input class="input100" type="text" name="description" placeholder="Project Description">
                                <span class="focus-input100" data-placeholder="&#xf207;"></span>
                            </div>

                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                <label class="label-checkbox100" for="ckb1">
                                    Test Checkbox
                                </label>
                            </div>

                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn">
                                    Create Session
                                </button>
                            </div>
				        </form>
                    </div>
                    
                    <!--LIST BRAINSTORMING SESSIONS-->
                    <div id = "listBrainstormingSessions" align="center">
                        <?php
                            $s = "SELECT * FROM sessions where email='$email'";
                            $t = mysqli_query($db,$s) or die("Error loading SQL Table.");
                            echo "Current Active Sessions: <b>".mysqli_num_rows($t). "</b>";
                            echo "<table border=2 cellpadding=10>";
                            while ( $r = mysqli_fetch_array($t,MYSQLI_ASSOC) ) {
                                $name                   = $r[ "name" ];
                                $code				    = $r[ "code" ];
                                echo "<tr>";
                                echo "<td>". $name. "</td>";
                                echo "<td>". $code. "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        ?>
                    </div>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>