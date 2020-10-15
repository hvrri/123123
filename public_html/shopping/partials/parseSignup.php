<?php
include_once 'resource/Database.php';
include_once 'resource/utilities.php';
//include_once 'resource/send-email.php';

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
