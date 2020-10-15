<?php
$page_title = "User Authentication -  {$_GET['u']}'s Profile";
include_once 'partials/headers.php';
include_once 'partials/parseProfile.php';

?>

<div class="container">
    <div >
        <h1><?php if(isset($username)) echo "{$username}n"; ?> Profiili</h1>
            <section class="col col-lg-7">
                <div class="row col-lg-3" style="margin-bottom: 10px;">
                    <img src="<?php if(isset($profile_picture)) echo $profile_picture; ?>" class="img img-rounded" width="200"/>
                </div>

                <table class="table table-bordered table-condensed">
                    <tr><th style="width: 20%;">Käyttäjätunnus:</th><td><?php if(isset($username)) echo $username; ?></td></tr>
                    <tr><th>Tila:</th><td><?php if(isset($status)) echo $status; ?></td></tr>
                    <tr><th>Liittymispäivämäärä:</th><td><?php if(isset($date_joined)) echo $date_joined; ?></td></tr>
                </table>
            </section>
    </div>
</div>

        <?php if(!isset($_SESSION['username'])): ?>
        <P class="lead">Sinulla ei ole oikeuksia  <a href="login.php"></a>
        <?php else: ?>
            <section class="col col-lg-7">
                            <a class="" href="edit-profile.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                                <span class="glyphicon glyphicon-edit"></span>Muokkaa profiilia</a> &nbsp; &nbsp;
                            <a class="" href="update-password.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                                <span class="glyphicon glyphicon-edit"></span>Vaihda salasana</a> &nbsp; &nbsp;
                            <a class="pull-right alert-warning" href="deactivate-account.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                                <span class="glyphicon glyphicon-trash"></span> Poista käyttäjä</a>
        <?php endif ?>

<?php include_once 'partials/footers.php'; ?>
</body>
</html>