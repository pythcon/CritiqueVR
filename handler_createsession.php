<!------------------------------AUTHENTICATION----------------------->
        <?php
            session_set_cookie_params(600);
            session_start();
            error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
            ini_set('display_errors' , 1);
            include ("account.php");
            include("loginfunctions.php");
            $db = mysqli_connect($hostname, $username, $password, $project);
            mysqli_select_db($db, $project); 
            
            gatekeeper();

            //GET ALL INFO FROM PREVIOUS FORM
            $email              = $_SESSION['email'];
            $projectName        = $_POST["name"];
            $projectDescription = $_POST["description"];
            
            //Generate room code
            $code = createRoomCode();
            
            //Successfully passed all tests:
            $s = "INSERT INTO sessions VALUES('$email', '$projectName', '$code')"; 
            $t = mysqli_query($db,$s); 
            
            echo"
            <script>
                alert(\"Brainstorming session was created. Please log in with code: ".$code."\");
                window.location.replace(\"/vr/dashboard.php\");
            </script>";
        ?>
<!------------------------------------------------------------------->