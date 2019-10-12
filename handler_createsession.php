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
            $roomName           = $_POST["name"];
            $contentDescription = $_POST["description"];
            $creationReason     = $_POST["creationReason"];
            $presentationReason = $_POST["presentationReason"];

            //Generate room code
            $code = createRoomCode();
            
            //file upload
            $numOfFiles = $_POST["piece"];
            $numOfFiles = (int)$numOfFiles;

            //create session directory
            mkdir("uploads/".$code."/", 0744);
            
            //initialize $filesArray
            uploadFiles($numOfFiles, $code, $filesArray);
            
            //Successfully passed all tests:
            $s = "INSERT INTO sessions VALUES('$email', '$roomName', '$contentDescription', '$creationReason', '$presentationReason', '$filesArray', '$code', '$numOfFiles')"; 
            $t = mysqli_query($db,$s); 
            
            echo"
            <script>
                alert(\"Brainstorming session was created. Please log in with code: ".$code."\");
                window.location.replace(\"/vr/dashboard.php\");
            </script>";
        ?>
<!------------------------------------------------------------------->