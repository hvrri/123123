<?php
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

//jos loginBtn painetaan
if (isset($_POST['loginBtn'], $_POST['token'])) {

    //vahvistaa tokenin 
    if (validate_token($_POST['token'])) {
        //valmistelee virhearrayn
        $form_errors = array();

        //vaaditut kentät
        $required_fields = array('username', 'password');
        //check_empty_fields ja virheet meneee $form_errors
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        //jos form errors on tyhjä niin
        if (empty($form_errors)) {
            //laitetaan kirjautumistiedot muuttujiin
            $user = $_POST['username'];
            $password = $_POST['password'];

            isset($_POST['remember']) ? $remember = $_POST['remember'] : $remember = "";

            //tarkistetaan onko käyttäjä olemassa
            $sqlQuery = "SELECT * FROM users WHERE username = :username";
            $statement = $db->prepare($sqlQuery);
            $statement->execute(array(':username' => $user));

            if ($row = $statement->fetch()) {
                $id = $row['id'];
                $hashed_password = $row['password'];
                $username = $row['username'];
                // $activated = $row['activated'];
                //tarkistaa onko käyttäjä aktivoinut tunnuksensa, en saanut toimimaan koska en saanut SMTP sähköposteja lähtemään
                if ($activated === "0") {

                    if (checkDuplicateEntries('trash', 'user_id', $id, $db)) {
                        //on aktivoinut
                        $db->exec("UPDATE users SET activated = '1' WHERE id = $id LIMIT 1");

                        //poistetaan tiedot trash tablesta 
                        $db->exec("DELETE FROM trash WHERE user_id = $id LIMIT 1");

                        //kirjaa käyttäjän sisään
                        prepLogin($id, $username, $remember);
                    } else {
                        $result = flashMessage("Sinulle on lähetetty aktivointikoodi");
                    }
                } else {
                    if (password_verify($password, $hashed_password)) {
                        prepLogin($id, $username, $remember);
                    } else {
                        $result = flashMessage("Antamasi salasana on väärä");
                    }
                }
            } else {
                $result = flashMessage("Antamasi käyttäjä on väärä");
            }
        } else {
            if (count($form_errors) == 1) {
                $result = flashMessage("Kirjautumisessa on ongelma ");
            } else {
                $result = flashMessage("Kirjautumisessa on " . count($form_errors) . " ongelmaa");
            }
        }
    } else {
    }
}
