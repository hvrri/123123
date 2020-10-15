<?php
$page_title = "Admin";
include_once 'partials/headers.php';
require_once('php/CreateDb.php');
require_once('./php/component.php');
include_once 'partials/parseMembers.php';
include_once 'partials/parseProfile.php';
include_once 'partials/parseChangePassword.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <!-- Bootstrap CDN 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    -->
    <link rel="stylesheet" href="style.css">
</head>

    <div>
        <?php
        // m��ritell��n tietokanta
        $database = new CreateDb("harhama_Productdb", "producttb");

        if (isset($_POST['add'])) {
            /// print_r($_POST['product_id']);
            if (isset($_SESSION['cart'])) {

                $item_array_id = array_column($_SESSION['cart'], "product_id");

                if (in_array($_POST['product_id'], $item_array_id)) {
                    echo "<script>alert('Tuote on jo ostoskorissa')</script>";
                    echo "<script>window.location = 'index.php'</script>";
                } else {

                    $count = count($_SESSION['cart']);
                    $item_array = array(
                        'product_id' => $_POST['product_id']
                    );

                    $_SESSION['cart'][$count] = $item_array;
                }
            } else {

                $item_array = array(
                    'product_id' => $_POST['product_id']
                );

                // Create new session variable
                $_SESSION['cart'][0] = $item_array;
                print_r($_SESSION['cart']);
            }
        }
        ?>
    </div>


<div class="container">
    <div class="flag">
        <h1>Admin</h1>
        <p class="lead">Poista tunnuksia<br>

            <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
                <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                <button onclick="return confirm('Do you really want to deactivate your account?')"
                        type="submit" name="deleteAccountBtn" class="btn btn-danger btn-block pull-right">
                    Poista käyttäjä</button> <br />
            </form>

                <?php if(count($members) > 0): ?>
                    <?php foreach ($members as $member): ?>
                        <div class="row col-lg-4" style="margin-bottom: 10px;">
                            <div class="media">
                                <div class="media-left">
                                    <a href="public_profile.php?u=<?= $member['username'] ?>">
                                        <img src="<?= $member['avatar'] ?>" class="media-object" style="width:60px">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">Käyttäjä:
                                        <a href="public_profile.php?u=<?=$member['username']?>">
                                            <?= $member['username'] ?>
                                        </a>
                                    </h4>
                                    <p>Liittymispäivämäärä: <?=strftime("%b %d, %Y", strtotime($member['join_date'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php else: ?>
                    <p>Käyttäjiä ei löytynyt</p>
                <?php endif; ?>
    </div>
<div class="container">
<button type"=submit">Poista</button>
</div>

<div class="container">
    <div class="flag">
        <h1>Admin</h1>
        <p class="lead">Poista tuotteita<br>

  <div id="myDropdown" class="dropdown-content">
<input type="checkbox"><a href="#">echo tunnus1</a></input>
<input type="checkbox"><a href="#">Link 1</a></input>
<input type="checkbox"><a href="#">Link 1</a></input>
<input type="checkbox"><a href="#">Link 1</a></input>
  </div>
<button type"=submit">Poista</button>
    </div>

    <div class="flag">
        <h1>Lis�� tuote</h1>
Tuotteen nimi<input type="textbox" placeholder="Tuotteen nimi"></input><br>
Tuotteen nimi<input type="textbox" placeholder="Tuotteen nimi"></input><br>
Tuotteen nimi<input type="textbox" placeholder="Tuotteen nimi"></input><br>
Tuotteen nimi<input type="textbox" placeholder="Tuotteen nimi"></input><br>

<button type"=submit">Luo tuote</button>
    </div>

<div class="container">
    <section class="col col-lg-7">
        <h2>Muuta tunnuksen salasana</h2><hr>
        <div>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>
        <div class="clearfix"></div>

        <?php if(!isset($_SESSION['username'])): ?>
            <P class="lead">Sinulla ei ole oikeuksia nähdä tätä sivua <a href="login.php">Kirjaudu sisään</a>
                Ei käyttäjää? <a href="signup.php">Rekisteröidy</a> </P>
        <?php else: ?>
            <hr />
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="currentpasswordField">Salasana</label>
                    <input type="password" name="current_password" class="form-control"
                           id="currentpasswordField" placeholder="Salasana">
                </div>

                <div class="form-group">
                    <label for="newpasswordField">Uusi salasana</label>
                    <input type="password" name="new_password" class="form-control"
                           id="newpasswordField" placeholder="Uusi salasana">
                </div>

                <div class="form-group">
                    <label for="confirmpasswordField">Uusi salasana</label>
                    <input type="password" name="confirm_password" class="form-control"
                           id="confirmpasswordField" placeholder="Uusi salasana">
                </div>

                <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
                <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                <button type="submit" name="changePasswordBtn" class="btn btn-primary pull-right">
                    Muuta</button> <br />
            </form>

        <?php endif ?>
    </section>
</div>

    <div class="flag">
        <h1>Muuta k�ytt�j�n nimi</h1>
Vanha nimi<input></input><br>
Uusi nimi<input></input><br>
<button type="submit">Muuta</button>
    </div>

    <div class="container">
        <div class="row text-center py-5">
            <?php

            $items = $database->getData();
            while ($row = mysqli_fetch_assoc($items)){
                component($row['product_name'], $row['product_price'], $row['product_image'], $row['id']);
            }
            ?>
        </div>
    </div>
</div>

<?php include_once 'partials/footers.php'; ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>