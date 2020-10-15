<?php
include_once 'resource/Database.php';
include_once 'resource/utilities.php';

if(isset($_POST['changePasswordBtn'], $_POST['token'])){
    if(validate_token($_POST['token'])){
        //tyhjä array johon virheet menee
        $form_errors = array();

        // vaaditut kentät jotka tarkistetaan
        $required_fields = array('current_password', 'new_password', 'confirm_password');

        //    ./resource/utilities.php tiedostossa on toiminto check_empty_fields joka tarkistaa yllämainitut $required_fields
        $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

        //kentät jotka tarkistetaan
        $fields_to_check_length = array('new_password' => 6, 'confirm_password' => 6);

        //kutsutaan funtkio check_min_length yllämainittuihin muuttujiin ja mahdolliset virheet menee $form_errors arrayhyn
        $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));


        //jos $form_errors on tyhjä eli virheitä ei ollut niin käsitellään lomake
        if(empty($form_errors)){
            $id = $_POST['hidden_id'];
            $current_password = $_POST['current_password'];
            $password1 = $_POST['new_password'];
            $password2 = $_POST['confirm_password'];

            //tarkistaa onko password1 sama kuin password2
            if($password1 != $password2){
                $result = flashMessage("New password and confirm password does not match");
            }else{
                try{
                    //suoritetaan toiminto
                    $sqlSquery = "SELECT password FROM users WHERE id = :id";
                    $statement = $db->prepare($sqlSquery);

                    $statement->execute(array(':id' => $id));
                    if ($row = $statement->fetch()){
                        $password_from_db = $row['password'];

                        //salasanan vahvistus 
                        if (password_verify($current_password, $password_from_db)) {
                            //uusi salasana hashattuna
                            $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

                            //SQL query salasanan päivitykseen
                            $sqlUpdate = "UPDATE users SET password = :password WHERE id =:id";
                            $statement = $db->prepare($sqlUpdate);
                            $statement->execute(array(':password' => $hashed_password, ':id' => $id));

                            //jos rowcount = 1 niin onnistui
                            if($statement->rowCount() === 1){
                                $result = "<script type=\"text/javascript\">
                                swal({
                                title: \"Operation Successful!\",
                                text: \"You password was updated successfully.\",
                                type: 'success',
                                confirmButtonText: \"Thank You!\" });
                                </script>";
                            //jos rowcount on tyhjä niin tietoja ei muutettu
                            }else{
                                $result = flashMessage("No changes saved");
                            }
                        }else{
                            $result = "<script type=\"text/javascript\">
                                swal({
                                title: \"OOPS!!\",
                                text: \"Old password is not correct, please try again\",
                                type: 'error',
                                confirmButtonText: \"Ok!\" });
                               </script>";
                        }

                    }else{
                        signout();
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
}