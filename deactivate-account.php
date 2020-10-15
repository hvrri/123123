<?php
$page_title = "User Authentication - Edit Profile";
include_once 'partials/headers.php';
include_once 'partials/parseProfile.php';
include_once 'partials/parseDeactivate.php';
?>

<div class="container">
    <section class="col col-lg-7">
        <h2>Deactivate Account </h2><hr>
        <div>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>
        <div class="clearfix"></div>

        <?php if(!isset($_SESSION['username'])): ?>
            <P class="lead">Sinulla ei ole oikeuksia nähdä tätä sivua <a href="login.php">Kirjaudu sisään</a>
                Ei käyttäjää? <a href="signup.php">Rekisteröidy</a> </P>
        <?php else: ?>
            <!-- Deactivate Account Area -->
            <hr />
            <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
                <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                <button onclick="return confirm('Do you really want to deactivate your account?')"
                        type="submit" name="deleteAccountBtn" class="btn btn-danger btn-block pull-right">
                    Poista käyttäjä</button> <br />
            </form>
        <?php endif ?>
    </section>
</div>
<?php include_once 'partials/footers.php'; ?>
</body>
</html>