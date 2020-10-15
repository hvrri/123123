<?php
$page_title = "Profiili";
include_once 'partials/headers.php';
include_once 'partials/parseProfile.php';
?>

<div class="container">
    <div >
        <h1>Profiili</h1>
        <?php if(!isset($_SESSION['username'])): ?>
        <P class="lead">Sinulla ei ole oikeuksia  <a href="login.php">Kirjaudu sisään</a>
            Ei käyttäjää? <a href="signup.php">Rekisteröidy</a> </P>
        <?php else: ?>
            <section class="col col-lg-7">

                <div class="row col-lg-3" style="margin-bottom: 10px;">
                    <img src="<?php if(isset($profile_picture)) echo $profile_picture; ?>" class="img img-rounded" width="200"/>
                </div>

                <table class="table table-bordered table-condensed">
                    <tr><th style="width: 20%;">Käyttäjätunnus:</th><td><?php if(isset($username)) echo $username; ?></td></tr>
                    <tr><th>Sähköposti:</th><td><?php if(isset($email)) echo $email; ?></td></tr>
                    <tr><th>Liittymispäivämäärä:</th><td><?php if(isset($date_joined)) echo $date_joined; ?></td></tr>
                    <tr><th></th><td>
                            <a class="" href="edit-profile.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                                <span class="glyphicon glyphicon-edit"></span>Muokkaa profiilia</a> &nbsp; &nbsp;
                            <a class="" href="update-password.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                                <span class="glyphicon glyphicon-edit"></span>Vaihda salasana</a> &nbsp; &nbsp;
                            <a class="pull-right alert-warning" href="deactivate-account.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                                <span class="glyphicon glyphicon-trash"></span> Poista käyttäjä</a>
                        </td></tr>
                </table>
            </section>
        <?php endif ?>
    </div>
</div>
<?php include_once 'partials/footers.php'; ?>
</body>
</html>