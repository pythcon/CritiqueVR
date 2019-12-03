<!------------------------------AUTHENTICATION----------------------->
        <?php
            session_start();
            include('functions.php');
            $pass = filter_input(INPUT_POST, 'passwordChange1', FILTER_SANITIZE_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, 'passwordChange2', FILTER_SANITIZE_SPECIAL_CHARS);
            
            if ($pass != $pass2){
                echo "
                <script>
                    alert(\"Password don't match. Please re-enter a new password.\");
                    window.location.replace(\"accountPage.php\");
                </script>
                ";
                die();
            }
            if (strlen($pass) < 6){
                echo "
                <script>
                    alert(\"Password must be at least 6 characters. Please re-enter a new password.\");
                    window.location.replace(\"accountPage.php\");
                </script>
                ";
                die();
            }
            $bad = false;
            if (!isset ($pass) || !isset ($pass2)){
                $bad = true;
            }
            if ($pass == "" || $pass2 == ""){
                $bad = true;
            }
            if ($bad){
                echo "
                <script>
                    alert(\"Password not valid.\");
                    window.location.replace(\"accountPage.php\");
                </script>
                ";
                die();
            }
            //Successfully passed all tests:
            $email = $_SESSION['email'];
            $pass = md5($pass);
            changePassword($email, $pass);

            echo"
            <script>
                alert(\"Password Changed. Please log in. \");
                window.location.replace(\"index.html\");
            </script>";
            $_SESSION['logged'] = false;
            session_destroy();
            
        ?>
<!------------------------------------------------------------------->