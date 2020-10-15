<?php
$page_title = " {$_GET['u']}'n profiili";
include_once 'partials/headers.php';
include_once 'partials/parseProfile.php';

?>

<div class="container">
    <div >
        <h1><?php if(isset($username)) echo "{$username}'s"; ?> Profiili</h1>
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
<?php include_once 'partials/footers.php'; ?>
</body>
</html>