<?php
require_once 'resource/Database.php';
require_once 'resource/send-email.php';
require_once 'resource/utilities.php';

//jos nappi painettu 
if(isset($_POST['signupBtn'])){

    //form errors tarkistukset
    $form_errors = array();
    $required_fields = array('email', 'username', 'password');
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
    $fields_to_check_length = array('username' => 4, 'password' => 6);
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));
    $form_errors = array_merge($form_errors, check_email($_POST));

    //kirjautumistiedot muuuttujiin
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    //tarkistetaan onko sähköposti jo käytössä checkDuplicateEntries joka on /resource/utilities.php tiedostossa
    if(checkDuplicateEntries("users", "email", $email, $db)){
        $result = flashMessage("Valitsemasi sähköpostiosoite on jo käytössä");
    }
    else if(checkDuplicateEntries("users", "username", $username, $db)){
        $result = flashMessage("Valitsemasi käyttäjätunnus on jo käytössä");
    }
    //jos ei virheitä
    else if(empty($form_errors)){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try{
            //SQL insert
            $sqlInsert = "INSERT INTO users (username, email, password, join_date)
              VALUES (:username, :email, :password, now())";

            //PDO prepare komento poistaa erikoismerkit
            $statement = $db->prepare($sqlInsert);

            //PDO execute komento suorittaa queryn
            $statement->execute(array(':username' => $username, ':email' => $email, ':password' => $hashed_password));

            //jos yksi uusi rivi luotiin
            if($statement->rowCount() == 1){
                //user id on viimeisin id
                $user_id = $db->lastInsertId();
                //encode id
                $encode_id = base64_encode("encodeuserid{$user_id}");

                //prepare email body
                $mail_body = '<html>
                <body style="background-color:#CCCCCC; color:#000; font-family: Arial, Helvetica, sans-serif;
                                    line-height:1.8em;">
                <h2>User Authentication: Code A Secured Login System</h2>
                <p>Dear '.$username.'<br><br>Thank you for registering, please click on the link below to
                    confirm your email address</p>
                <p><a href="http://localhost/activate.php?id='.$encode_id.'"> Confirm Email</a></p>
                <p><strong>&copy;2016 ICT DesighHUB</strong></p>
                </body>
                </html>';

                $mail->addAddress($email, $username);
                $mail->Subject = " Oppipuoti ";
                $mail->Body = $mail_body;
               
            
                $result = flashMessage("Rekisteröityminen onnistui!", "Pass");
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

}

//activation
else if(isset($_GET['id'])) {
    $encoded_id = $_GET['id'];
    $decode_id = base64_decode($encoded_id);
    $user_id_array = explode("encodeuserid", $decode_id);
    $id = $user_id_array[1];
    
    $sql = "UPDATE users SET activated =:activated WHERE id=:id AND activated='0'";
    
    $statement = $db->prepare($sql);
    $statement->execute(array(':activated' => "1", ':id' => $id));
    
    if ($statement->rowCount() == 1) {
    $result = '<h2>Email Confirmed </h2>
    <p>Your email address has been verified, you can now <a href="login.php">login</a> with your email and password.</p>';
    } else {
    $result = "<p class='lead'>No changes made please contact site admin,
        if you have not confirmed your email before</p>";
    }
    }