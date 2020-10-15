<?php
$page_title = "Muokkaa profiilia";
include_once 'partials/headers.php';
include_once 'partials/parseProfile.php';
?>

<div class="container">
    <section class="col col-lg-7">
        <h2>Muokkaa profiilia </h2><hr>
        <div>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>
        <div class="clearfix"></div>

        <?php if(!isset($_SESSION['username'])): ?>
            <P class="lead">Sinulla ei ole oikeuksia nähdä tätä sivua <a href="login.php">Kirjaudu sisään</a>
                Ei käyttäjää? <a href="signup.php">Rekisteröidy</a> </P>
        <?php else: ?>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="emailField">Email</label>
                        <input type="text" name="email" class="form-control" id="emailField" value="<?php if(isset($email)) echo $email; ?>">
                    </div>

                    <div class="form-group">
                        <label for="usernameField">Käyttäjä</label>
                        <input type="text" name="username" value="<?php if(isset($username)) echo $username; ?>" class="form-control" id="usernameField">
                    </div>

                    <div class="form-group">
                        <label for="fileField">Kuva</label>
                        <input type="file" name="avatar" id="fileField">
                    </div>

                    <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
                    <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                    <button type="submit" name="updateProfileBtn" class="btn btn-primary pull-right">
                        Päivitä profiili</button> <br />
                </form>

        <?php endif ?>
    </section>
</div>
<?php include_once 'partials/footers.php'; ?>
</body>
</html>