<?php
include_once 'resource/Database.php';
include_once 'resource/utilities.php';
include_once 'resource/send-email.php';

//jos nappia painetaan 
if(isset($_POST['passwordResetBtn'], $_POST['token'])){

    //tarkistetaan että token täsmää
    if(validate_token($_POST['token'])){

        //tyhjä array
        $form_errors = array();

        //kentät jotka halutaan tarkistaa
        $required_fields = array('email', 'reset_token', 'new_password', 'confirm_password');

        //kutsutaan tarkistusfunktio ja laitetaan virheet arrayhyn
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        //kentät jotka halutaan tarkistaa
        $fields_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

        //kutsutaan tarkistusfuntkio ja laitetaan virheet arrayhyn
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));


        //jos virhe array on tyhjä niin voidaan suorittaa kirjautuminen
        if(empty($form_errors)){
            //kirjautumistiedot muuttujiin
            $email = $_POST['email'];
            $reset_token = $_POST['reset_token'];
            $password1 = $_POST['new_password'];
            $password2 = $_POST['confirm_password'];

            //tarkistetaan onko uusisalasana1 ja uusisalasana2 samat
            if($password1 != $password2){
                $result = flashMessage("Uudet salasanat eivät täsmää");
            }else{
                try{
                    //Tarkistetaan email ja token
                    $query = "SELECT * FROM password_resets WHERE email =:email";
                    $queryStatement = $db->prepare($query);
                    $queryStatement->execute([
                        ':email' => $email
                    ]);

                    $isValid = true;

                    if($rows = $queryStatement->fetch()) {
                        //jos sähköposti löytyi
                        $stored_token = $rows['token'];
                        $expire_time = $rows['expire_time'];

                        if($stored_token !== $reset_token) {
                            $isValid = false;
                            $result = flashMessage("Väärä token");
                        }

                        if ($expire_time < date('Y-m-d H:i:s')) {
                            $isValid = false;
                            $result = flashMessage("Tämä reset token on vanhentunut");
                            //delete token
                            $db->exec("DELETE FROM password_resets
                                      WHERE email ='$email' AND token = '$stored_token'");
                        }
                    }else{
                        $isValid = false;
                        goto invalid_email;
                    }

                    //Salasanan reset sähköpostitettavalla tokenilla, ei toimi vielä. Ainoastaan salasanan vaihto ilman tokenia toimii
                    if($isValid){
                        $sqlQuery = "SELECT id FROM users WHERE email =:email";
                        $statement = $db->prepare($sqlQuery);
                        $statement->execute(array(':email' => $email));
                        if($rs = $statement->fetch()){
                            $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                            $id = $rs['id'];
                            $sqlUpdate = "UPDATE users SET password =:password WHERE id=:id";
                            $statement = $db->prepare($sqlUpdate);
                            $statement->execute(array(':password' => $hashed_password, ':id' => $id));

                            if ($statement->rowCount() == 1) {
                                //delete token
                                $db->exec("DELETE FROM password_resets
                                      WHERE email = '$email' AND token = '$stored_token'");
                            }

                            $result = "<script type=\"text/javascript\">
                            swal({
                            title: \"Updated!\",
                            text: \"Password Reset Successful.\",
                            type: 'success',
                            confirmButtonText: \"Thank You!\" });
                        </script>";
                        }
                        else{
                            invalid_email:
                            $result = "<script type=\"text/javascript\">
                            swal({
                            title: \"OOPS!!\",
                            text: \"The email address provided does not exist in our database, please try again.\",
                            type: 'error',
                            confirmButtonText: \"Ok!\" });
                        </script>";
                        }
                    }

                }catch (PDOException $ex){
                    $result = flashMessage("An error occurred: " .$ex->getMessage());
                }
            }
        }
        else{
            if(count($form_errors) == 1){
                $result = flashMessage("There was 1 error in the form<br>");
            }else{
                $result = flashMessage("There were " .count($form_errors). " errors in the form <br>");
            }
        }
    }else{
        $result = "<script type='text/javascript'>
                      swal('Error','This request originates from an unknown source, posible attack'
                      ,'error');
                      </script>";
    }

}else if(isset($_POST['passwordRecoveryBtn'], $_POST['token'])){

    if(validate_token($_POST['token'])){
        $form_errors = array();
        $required_fields = array('email');
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
        $form_errors = array_merge($form_errors, check_email($_POST));
        if(empty($form_errors)){
            $email = $_POST['email'];
            try{
                $sqlQuery = "SELECT * FROM users WHERE email =:email";
                $statement = $db->prepare($sqlQuery);
                $statement->execute(array(':email' => $email));
                if($rs = $statement->fetch()){
                    $username = $rs['username'];
                    $email = $rs['email'];
                    $expire_time = date('Y-m-d H:i:s', strtotime('1 hour'));
                    $random_string = base64_encode(openssl_random_pseudo_bytes(10));
                    $reset_token = strtoupper(preg_replace('/[^A-Za-z0-9\-]/', '', $random_string));

                    $insertToken = "INSERT INTO password_resets (email, token, expire_time)
                                    VALUES (:email, :token, :expire_time)";
                    $token_statement = $db->prepare($insertToken);
                    $token_statement->execute([
                        ':email' => $email, ':token' => $reset_token, ':expire_time' => $expire_time
                    ]);

                    //lähetetttävä sähköpostiviesti
                    $mail_body = '<html>
                        <body style="background-color:#CCCCCC; color:#000; font-family: Arial, Helvetica, sans-serif;
                                            line-height:1.8em;">
                        <h2>User Authentication: Code A Secured Login System</h2>
                        <p>Dear '.$username.'<br><br> To reset your login password, copy the token below and 
                        click on the Reset Password link then paste the token in the token field on the form:
                        <br /><br />
                        Token: '.$reset_token.' <br />
                        This token will expire after 1 hour
                        </p>
                        <p><a href="http://auth.dev/forgot_password.php"> Reset Password</a></p>
                        <p><strong>&copy;'.date('Y').' DEVSCREENCAST</strong></p>
                        </body>
                        </html>';

                    $mail->addAddress($email, $username);
                    $mail->Subject = "Password Recovery Message from DEVSCREENCAST";
                    $mail->Body = $mail_body;

                    //PHPMailer virheet
                    if(!$mail->Send()){
                        $result = "<script type=\"text/javascript\">
                         swal(\"Error\",\" Email sending failed: $mail->ErrorInfo \",\"error\");</script>";
                    }else{
                        $result = "<script type=\"text/javascript\">
                            swal({
                            title: \"Password Recovery!\",
                            text: \"Password Reset link sent successfully, please check your email address.\",
                            type: 'success',
                            confirmButtonText: \"Thank You!\" });
                        </script>";
                    }
                }
                else{
                    $result = "<script type=\"text/javascript\">
                            swal({
                            title: \"OOPS!!\",
                            text: \"The email address provided does not exist in our database, please try again.\",
                            type: 'error',
                            confirmButtonText: \"Ok!\" });
                        </script>";
                }
            }catch (PDOException $ex){
                $result = flashMessage("An error occurred: " .$ex->getMessage());
            }

        }
        else{
            if(count($form_errors) == 1){
                $result = flashMessage("There was 1 error in the form<br>");
            }else{
                $result = flashMessage("There were " .count($form_errors). " errors in the form <br>");
            }
        }
    }else{
        $result = "<script type='text/javascript'>
                      swal('Error','This request originates from an unknown source, posible attack'
                      ,'error');
                      </script>";
    }

}

