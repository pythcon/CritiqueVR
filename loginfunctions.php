<?php
    function getData($name, &$result){
        global $bad;
        global $db;
        if (!isset ($_POST[ $name ])){
            $bad = true;
        }
        if ($_POST[$name] == ""){
            $bad = true;
        }

        $result = mysqli_real_escape_string ($db, $_POST[$name]);
    }
//------------------------------------------------------------------//
    function auth ($u, $p, &$t, &$reset){
        global $db;
        
        $s = "SELECT * FROM accounts WHERE email = '$u'";
        
        $t = mysqli_query($db, $s) or die("Error Querying Database.");
        
        while ( $r = mysqli_fetch_array($t,MYSQLI_ASSOC) ) {
            $reset 				= $r[ "reset" ];
            $resetPassword     	= $r[ "resetPassword" ];
        }
        
        if ($reset){
            $s = "SELECT * FROM accounts WHERE (email = '$u' AND resetPassword = '$p') OR (email = '$u' AND password = '$p')";
            $t = mysqli_query($db, $s) or die("Error Querying Database.");
        }else{
            $s = "SELECT * FROM accounts WHERE email = '$u' AND password = '$p'";
            $t = mysqli_query($db, $s) or die("Error Querying Database.");
        }
        
        $num_rows = mysqli_num_rows($t);
        
        if ($num_rows>0){
            //sets reset to false and deletes temp password
            $s = "UPDATE accounts SET reset=NULL, resetPassword=NULL WHERE email='$u'";
            $t = mysqli_query($db, $s) or die("Error updating reset status.");
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
        //check if authenticated
        if (!$_SESSION['logged']){
            echo"
            <script>
                alert(\"Not logged in...\");
                window.location.replace(\"/vr/index.html\");
            </script>";
            exit();
        }
    }


//----------------------------------------------------------------------//
    function register ($u, $fn, $ln, $p, &$t){
        global $db;
        $p = md5($p);
        $s = "INSERT INTO accounts(email, firstname, lastname, password) VALUES('$u', '$fn', '$ln', '$p')";
        
        $t = mysqli_query($db, $s) or die("Error Querying Database.");
        
        $num_rows = mysqli_num_rows($t);
        
        if ($num_rows>0){
            return true;
        }
        else{
            return false;
        }
    }
//----------------------------------------------------------------------//
//function mailer
function forgotPasswordMailer($email, &$out){
    global $db;

    $s = "SELECT * FROM accounts where email = '$email'";
    $t = mysqli_query($db,$s) or die( mysqli_error($db));

//Successfully passed all tests:
    $randompassword = random_pass(6);//randomPassword(6,1,"lower_case");
    $randompassHashed = md5($randompassword);

    $s = "UPDATE accounts SET reset = True, resetPassword = '$randompassHashed' WHERE email = '$email'";
    mysqli_query ($db, $s) or die (mysqli_error($db));

    $out = "Password reset was requested.
    If you did not request this password reset, please log in normally and your account will remain secure.

    ~Your temporary password is: " .$randompassword ."~

    When you log in for the first time, please change your password.

    Best,
    ~CritiqueVR Webmaster~";

    $from = "CritiqueVR Webmaster";
    $to = $email;
    $subject = "CritiqueVR Password Reset";
    $message = $out;
    $headers = "From:" . $from;
    mail($to, $subject, $message, $header);

    echo"
    <script>
        alert(\"If you were registered in our system, a password reset email was sent. Please check your email.\");
        window.location.replace(\"/vr/index.html\");
    </script>";


}
function random_pass($length){
   $string = "";
   $chars = "abcdefghijklmanopqrstuvwxyz0123456789";
   $size = strlen($chars);
   for ($i = 0; $i < $length; $i++) {
       $string .= $chars[rand(0, $size - 1)];
   }
   return $string; 
}

function createRoomCode(){
    return random_pass(6);
}

function uploadFiles($num, $code, &$filesArray){
    $target_dir = "uploads/".$code."/";
    $target_file = $target_dir . basename($_FILES["oneFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if file already exists
    if (file_exists($target_file)) {
        die("Sorry, file already exists.");
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["oneFile"]["size"] > 500000) {
        die("Sorry, your file is too large.");
        $uploadOk = 0;
    }
    // Allow certain file formats
    /*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $uploadOk = 0;
    }*/
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        die("File(s) could not be uploaded.");
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["oneFile"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["oneFile"]["name"]). " has been uploaded.";
            array_push($filesArray,$target_file);
        } else {
            die("Sorry, there was an error uploading your file.");
        }
    }
    
    if ($num > 1){
        $target_file2 = $target_dir . basename($_FILES["twoFile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
        // Check if file already exists
        if (file_exists($target_file2)) {
            die("Sorry, file already exists.");
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["twoFile"]["size"] > 500000) {
            die("Sorry, your file is too large.");
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            die("File(s) could not be uploaded.");
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["twoFile"]["tmp_name"], $target_file2)) {
                echo "The file ". basename( $_FILES["twoFile"]["name"]). " has been uploaded.";
                array_push($filesArray,$target_file2);
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        }
    }
    if ($num > 2){
        $target_file3 = $target_dir . basename($_FILES["threeFile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));
        // Check if file already exists
        if (file_exists($target_file3)) {
            die("Sorry, file already exists.");
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["threeFile"]["size"] > 500000) {
            die("Sorry, your file is too large.");
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            die("File(s) could not be uploaded.");
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["threeFile"]["tmp_name"], $target_file3)) {
                echo "The file ". basename( $_FILES["threeFile"]["name"]). " has been uploaded.";
                array_push($filesArray,$target_file3);
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        }
    }
    if ($num > 3){
        $target_file4 = $target_dir . basename($_FILES["fourFile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file4,PATHINFO_EXTENSION));
        // Check if file already exists
        if (file_exists($target_file4)) {
            die("Sorry, file already exists.");
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fourFile"]["size"] > 500000) {
            die("Sorry, your file is too large.");
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            die("File(s) could not be uploaded.");
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fourFile"]["tmp_name"], $target_file4)) {
                echo "The file ". basename( $_FILES["fourFile"]["name"]). " has been uploaded.";
                array_push($filesArray,$target_file4);
            } else {
                die("Sorry, there was an error uploading your file.");
            }
        }
    }
    
}
?>

