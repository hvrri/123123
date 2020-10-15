<?php
$page_title = "User Authentication - Login Page";
include_once 'partials/headers.php';
include_once 'partials/parseLogin.php';
include('functions.php');
?>

<div class="container">
    <section class="col-lg-7">
        <h2>Kirjaudu </h2><hr>
        <div>
        <?php if(isset($result)) echo $result; ?>
        <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>
        <div class="clearfix"></div>
            <form action="" method="post">
                <div class="form-group">
                    <label for="usernameField">Käyttäjä</label>
                    <input type="text" class="form-control" name="username" id="usernameField" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="passwordField">Salasana</label>
                    <input type="password" name="password" class="form-control" id="passwordField" placeholder="Password">
                </div>

                <div class="checkbox">
                    <label>
                        <input name="remember" value="yes" type="checkbox"> Muista minut
                    </label>
                    <a class="pull-right" href="password_recovery_link.php">Unohditko salasanasi?</a>
                </div>
                <input type="hidden" name="token" value="<?php if(function_exists('_token')) echo _token(); ?>">
                <button type="submit" name="loginBtn" class="btn btn-primary pull-right">Kirjaudu</button>
            </form>
    </section>
</div>

<?php include_once 'partials/footers.php'; ?></body>
</html>