<?php
    function getData($name, &$result){
        global $bad;
        global $db;
        if (!isset ($_GET[ $name ])){
            $bad = true;
        }
        if ($_GET[$name] == ""){
            $bad = true;
        }

        $result = mysqli_real_escape_string ($db, $_GET[$name]);
    }
//------------------------------------------------------------------//
    function auth ($u, $p, &$t){
        global $db;
        
        $s = "SELECT * FROM accounts WHERE user = '$u' AND pass = '$p'";
        
        $t = mysqli_query($db, $s) or die(myslqi_error());
        
        $num_rows = mysqli_num_rows($t);
        
        if ($num_rows>0){
            return true;
        }
        else{
            return false;
        }
    }
//--------------------------------------------------------------------//
    function redirect($message, $targetfile, $delay){
        global $db;
        echo $message;
        
        header("refresh: $delay, url = $targetfile");
        
        exit();
    }
//---------------------------------------------------------------------//
    function gatekeeper(){
        global $db;
        $delay = 5;
        if (!isset ($_SESSION["logged"])){
            redirect ("<span style=\"color:red;\">Please Log In. Session was reset...</span>", "assignment2login.html", $delay);
        }
    }


//----------------------------------------------------------------------//

?>